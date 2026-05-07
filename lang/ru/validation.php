<?php

return [
    'custom' => [
        'blocks_json.*.video' => [
            'max' => 'Файл слишком большой. Максимальный размер: 100 МБ.',
            'mimetypes' => 'Допустим только видеофайл (MP4/MOV/M4V).',
            'mimes' => 'Допустим только видеофайл (MP4/MOV/M4V).',
        ],
    ],

    'attributes' => [
        'blocks_json.*.video' => 'видео',
    ],
];
