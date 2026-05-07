<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    protected $table = 'portfolios';

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'body_before',
        'body',
        'is_active',
        'attachments',

        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'attachments' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $slug = $model->slug;
            if (empty($slug)) {
                $slug = $model->title;
            }

            $model->slug = Str::slug($slug);
        });
    }
}
