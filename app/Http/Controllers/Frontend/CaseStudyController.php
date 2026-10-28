<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CaseStudyController extends Controller
{
    public function index(): View
    {
        return view('frontend.pages.case-studies', [
            'caseStudies' => config('frontend.case-studies', []),
        ]);
    }

    public function show(string $slug): View
    {
        // Replace this catalog lookup with a published Eloquent query later.
        $catalog = config('frontend.case-studies', []);
        abort_unless(array_key_exists($slug, $catalog), 404);
        $caseStudy = $catalog[$slug];

        // The view is a trusted catalog value, never the URL supplied by a visitor.
        return view($caseStudy['view'], ['caseStudy' => $caseStudy, 'slug' => $slug]);
    }
}
