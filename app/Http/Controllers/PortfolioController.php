<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends EntryController
{
    public function show(string $slug)
    {
        $entry = Portfolio::query()->where('slug', '=', $slug)->firstOrFail();

        // Если не активно и (нет пользователя или пользователь не админ)
        if (!$entry->is_active && (!Auth::check() || !Auth::user()->is_admin)) {
            abort(404);
        }

        $this->createSeoMeta(
            $entry->meta_title ?? $entry->title,
            $entry->meta_description ?? $entry->body,
            $entry->meta_keywords
        );

        return view('entries.portfolio', [
            'entry' => $entry,
            'other_portfolios' => Portfolio::query()
                ->where('id', '!=', $entry->id)
                ->inRandomOrder()
                ->take(4)
                ->get(),
        ]);
    }
}
