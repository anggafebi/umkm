<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientOrder;
use App\Models\Product;
use App\Models\SystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout(Product $product)
    {
        abort_if($product->price === null || (float) $product->price <= 0 || $product->price_is_starting_at, 404);
        return view('client.orders.checkout', compact('product'));
    }

    public function storeFixed(Request $request, Product $product)
    {
        abort_if($product->price === null || (float) $product->price <= 0 || $product->price_is_starting_at, 404);
        $data = $request->validate(['client_notes' => 'nullable|string|max:2000']);
        $order = ClientOrder::create([
            'order_number' => 'AD-'.now()->format('ymd').'-'.Str::upper(Str::random(6)),
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'order_type' => 'fixed',
            'price' => $product->price,
            'client_notes' => $data['client_notes'] ?? null,
            'status' => 'pending',
        ]);
        $this->notifyAdmins($order, 'Pesanan produk baru', "{$order->order_number} — {$order->product_name}");
        return redirect()->route('client.orders.show', $order)->with('success', 'Pesanan berhasil diajukan. Admin akan menindaklanjutinya.');
    }

    public function customForm(Request $request)
    {
        $product = $request->filled('product_id') ? Product::findOrFail($request->integer('product_id')) : null;
        $serviceName = $request->query('service', $product?->name);
        return view('client.orders.custom', compact('product', 'serviceName'));
    }

    public function storeCustom(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'service_type' => 'required|string|max:160',
            'project_name' => 'required|string|max:160',
            'description' => 'required|string|max:5000',
            'requested_features' => 'nullable|string|max:5000',
            'budget' => 'nullable|string|max:100',
            'client_notes' => 'nullable|string|max:2000',
        ]);
        $product = !empty($data['product_id']) ? Product::findOrFail($data['product_id']) : null;
        $order = ClientOrder::create([
            'order_number' => 'AD-'.now()->format('ymd').'-'.Str::upper(Str::random(6)),
            'user_id' => $request->user()->id,
            'product_id' => $product?->id,
            'product_name' => $product?->name ?: $data['service_type'],
            'order_type' => 'custom',
            'project_name' => $data['project_name'],
            'service_type' => $data['service_type'],
            'description' => $data['description'],
            'requested_features' => $data['requested_features'] ?? null,
            'budget' => $data['budget'] ?? null,
            'client_notes' => $data['client_notes'] ?? null,
            'status' => 'review',
        ]);
        $this->notifyAdmins($order, 'Pengajuan pesanan custom baru', "{$order->order_number} — {$order->project_name}");
        return redirect()->route('client.orders.show', $order)->with('success', 'Pengajuan pemesanan berhasil dikirim. Admin akan meninjau kebutuhan Anda.');
    }

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->latest()->paginate(10);
        return view('client.orders.index', compact('orders'));
    }

    public function show(Request $request, ClientOrder $order)
    {
        abort_unless($order->user_id === $request->user()->id, 404);
        return view('client.orders.show', compact('order'));
    }

    public function respondOffer(Request $request, ClientOrder $order)
    {
        abort_unless($order->user_id === $request->user()->id && $order->order_type === 'custom' && $order->status === 'awaiting_approval', 404);
        $data = $request->validate(['decision' => 'required|in:accept,revision']);
        $order->update([
            'status' => $data['decision'] === 'accept' ? 'approved' : 'review',
            'offer_responded_at' => now(),
        ]);
        $title = $data['decision'] === 'accept' ? 'Penawaran pesanan disetujui client' : 'Client meminta revisi penawaran';
        $body = "{$order->order_number} — {$order->owner->name}";
        \App\Models\User::whereIn('role', ['admin', 'editor'])->get()->each(function ($admin) use ($title, $body) {
            SystemNotification::create(['user_id' => $admin->id, 'type' => 'order_response', 'title' => $title, 'body' => $body]);
        });
        return back()->with('success', $data['decision'] === 'accept' ? 'Penawaran disetujui. Admin akan menghubungi Anda untuk tindak lanjut.' : 'Permintaan revisi penawaran telah dikirim kepada admin.');
    }

    private function notifyAdmins(ClientOrder $order, string $title, string $body): void
    {
        \App\Models\User::whereIn('role', ['admin', 'editor'])->get()->each(function ($admin) use ($order, $title, $body) {
            SystemNotification::create(['user_id' => $admin->id, 'type' => 'order_new', 'title' => $title, 'body' => $body]);
        });
    }
}
