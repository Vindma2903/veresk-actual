<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $table = 'pages';
    protected $fillable = [
        'title',
        'slug',
        'body_before',
        'body',
        'blocks_json',
        'is_active',
        'attachments',

        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'attachments' => 'json',
        'blocks_json' => 'array',
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
