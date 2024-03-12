<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'description',
        'name',
        'type',
        'mime',
        'size',
        'path',
        'url'
    ];

    public function getRouteKeyName(): string
    {
        return 'external_id';
    }
}
