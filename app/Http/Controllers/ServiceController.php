<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Support\PublicContentFallbacks;
use Illuminate\Database\QueryException;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            $services = Service::latest()->paginate(12);
        } catch (QueryException $exception) {
            $services = PublicContentFallbacks::paginate(PublicContentFallbacks::services(), 12);
            $this->logFallback($exception);
        }

        return view('services.index', compact('services'));
    }

    public function show(string $slug)
    {
        try {
            $service = Service::where('slug', $slug)->firstOrFail();
        } catch (QueryException $exception) {
            $service = PublicContentFallbacks::findBySlug(PublicContentFallbacks::services(), $slug);
            abort_unless($service, 404);
            $this->logFallback($exception);
        }

        return view('services.detail', compact('service'));
    }

    private function logFallback(QueryException $exception): void
    {
        logger()->warning('Service data could not be loaded; static fallback content was used.', [
            'message' => $exception->getMessage(),
        ]);
    }
}
