<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientOrder;
use App\Models\SystemNotification;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = ClientOrder::with('owner')->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))->latest()->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(ClientOrder $order)
    {
        $order->load('owner', 'product');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, ClientOrder $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,review,awaiting_approval,approved,in_progress,completed,cancelled',
            'offer_price' => 'nullable|numeric|min:0|required_if:status,awaiting_approval',
            'offer_details' => 'nullable|string|max:5000',
        ]);
        if ($order->order_type === 'fixed' && in_array($data['status'], ['awaiting_approval', 'review'], true)) {
            return back()->withErrors(['status' => 'Pesanan harga tetap tidak memerlukan tahap penawaran custom.']);
        }
        $order->update($data);
        SystemNotification::create([
            'user_id' => $order->user_id,
            'type' => 'order_updated',
            'title' => 'Status pesanan diperbarui',
            'body' => "Pesanan {$order->order_number} diperbarui menjadi ".str_replace('_', ' ', $data['status']).'.',
        ]);
        return back()->with('success', 'Pesanan berhasil diperbarui.');
    }
}
