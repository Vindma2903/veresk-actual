<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class PageController extends EntryController
{
    public function show(?string $slug = 'homepage')
    {
        $entry = Page::query()->where('slug', '=', $slug)->firstOrFail();

        // Если не активно и (нет пользователя или пользователь не админ)
        if (!$entry->is_active && (!Auth::check() || !Auth::user()->is_admin)) {
            abort(404);
        }

        $serviceSliderData = [];
        if ($slug === 'homepage') {
            $serviceSliderData = Service::query()
                ->where('is_show_homepage', '=', true)
                ->where('is_active', '=', true)
                ->inRandomOrder()
                ->select(['title', 'slug'])
                ->take(15)
                ->get()
                ->toArray()
            ;
        }

        $this->createSeoMeta(
            $entry->meta_title ?? $entry->title,
            $entry->meta_description ?? $entry->body,
            $entry->meta_keywords
        );

        return view('entries.page', [
            'entry' => $entry,
            'service_slider_data' => $serviceSliderData,
        ]);
    }
}
