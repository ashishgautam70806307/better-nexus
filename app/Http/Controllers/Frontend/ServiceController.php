<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('frontend.pages.services', [
            'services' => config('frontend.services', []),
        ]);
    }

    public function show(string $slug): View
    {
        // Replace this catalog lookup with a published Eloquent query later.
        $catalog = config('frontend.services', []);
        abort_unless(array_key_exists($slug, $catalog), 404);
        $service = $catalog[$slug];

        // The view is a trusted catalog value, never the URL supplied by a visitor.
        return view($service['view'], ['service' => $service, 'slug' => $slug]);
    }
}
