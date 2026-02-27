<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute; // ✅ You must import this

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'phoneNumbers',
    ];

    // ✅ Define casts using Attribute helper methods

    protected function phoneNumbers(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    public function getFilteredPhoneNumbersAttribute()
    {
        $phones = collect($this->phoneNumbers ?? [])
            ->pluck('number')
            ->filter()       // remove null or empty
            ->unique()
            ->implode(', ');

        return $phones ?: null;
    }
}
