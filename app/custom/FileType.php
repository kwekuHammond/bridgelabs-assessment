<?php

namespace App\custom;

enum FileType
{
    const IMAGE = 'image';
    const VIDEO = 'video';
    const AUDIO = 'audio';
    const DOCUMENT = 'document';

    const VALID_TYPES = [
        self::IMAGE,
        self::DOCUMENT,
        self::VIDEO,
        self::AUDIO,
    ];
}
