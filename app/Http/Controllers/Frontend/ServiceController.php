<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('frontend.pages.services', [
            'services' => config('virtual-assistant', []),
        ]);
    }

    public function show(string $slug): View
    {
        // Public slugs stay compatible with existing bookmarks.
        $catalog = config('virtual-assistant', []);
        abort_unless(array_key_exists($slug, $catalog), 404);
        $service = $catalog[$slug];

        $others = array_filter($catalog, fn ($item, $key) => $key !== $slug, ARRAY_FILTER_USE_BOTH);
        $relatedServices = array_slice($others, 0, 3, true);

        return view('frontend.pages.service-detail', compact('service', 'slug', 'relatedServices'));
    }
}
