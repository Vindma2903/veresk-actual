<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteOption extends Model
{
    public const BODY_TYPE_TEXT = 'text';
    public const BODY_TYPE_TEXTAREA = 'textarea';
    public const BODY_TYPE_HTML = 'html';
    public const BODY_TYPE_EMAIL = 'email';
    public const BODY_TYPE_JSON = 'json';

    protected $table = 'site_options';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
        'body',
        'body_json',
        'type',
    ];

    protected $casts = [
        'body_json' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (!empty($model->body_json) && is_string($model->body_json)) {
                $model->body_json = \json_decode($model->body_json, true);
            }
        });
    }
}
