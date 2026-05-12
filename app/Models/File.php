<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'file_name',
        'file_type',   // image | video | audio | pdf | text | file
        'size_bytes',
        'folder_path',
        'full_path',
        'mime_type',
        'is_downloaded',
        'modified_at',
    ];
}