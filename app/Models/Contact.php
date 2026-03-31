<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'phoneNumbers',
    ];

    // ✅ SAFE JSON CAST (recommended way in Laravel)
    protected $casts = [
        'phoneNumbers' => 'array',
    ];

    // ✅ Helper accessor (optional)
    public function getFilteredPhoneNumbersAttribute()
    {
        $phones = collect($this->phoneNumbers ?? [])
            ->pluck('number')
            ->filter()
            ->unique()
            ->implode(', ');

        return $phones ?: null;
    }
}