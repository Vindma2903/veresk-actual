<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Service;
use App\Models\ServiceWork;
use Illuminate\Support\Facades\Auth;

class ServiceController extends EntryController
{

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $entry = Service::query()->where('slug', '=', $slug)->firstOrFail();

        // Если не активно и (нет пользователя или пользователь не админ)
        if (!$entry->is_active && (!Auth::check() || !Auth::user()->is_admin)) {
            abort(404);
        }

        $this->createSeoMeta(
            $entry->meta_title ?? $entry->title,
            $entry->meta_description ?? $entry->body,
            $entry->meta_keywords,
            $entry->title_img
        );

        if ($slug === 'landshaftnoe-proektirovanie') {
            $pageEntry = Page::query()->where('slug', '=', $slug)->first();
            if ($pageEntry) {
                $this->createSeoMeta(
                    $pageEntry->meta_title ?? $pageEntry->title,
                    $pageEntry->meta_description ?? $pageEntry->body,
                    $pageEntry->meta_keywords
                );

                return view('pages.landshaftnoe-proektirovanie', [
                    'entry' => $pageEntry,
                ]);
            }

            return view('pages.landshaftnoe-proektirovanie', [
                'entry' => $entry,
            ]);
        }

        return view('entries.service', [
            'entry' => $entry,
            'root_id' => Service::findNodeRootId($entry->id),
            'service_works' => ServiceWork::query()->orderBy('position')->select('thumbnail')->pluck('thumbnail')->shuffle()->toArray(),
            'tree' => Service::toTree(),
        ]);
    }
}
