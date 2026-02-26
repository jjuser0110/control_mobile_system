<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRolesAndAbilities,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'username',
        'role_id',
        'is_active',
        'nric',
        'contact_no',
        'user_status',
        'front_ic',
        'back_ic',
        'company_name',
        'company_contact',
        'job_title',
        'salary',
        'salary_date',
        'bill_tnb',
        'bill_air',
        'slip_gaji',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['front_ic_url', 'back_ic_url'];

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function contact_number()
    {
        return $this->hasMany('App\Models\Contact')->where('displayName','!=',null);
    }

    public function call_logs()
    {
        return $this->hasMany('App\Models\CallLog');
    }

    public function images()
    {
        return $this->hasMany('App\Models\UserImage');
    }
        
    public function loans()
    {
        return $this->hasMany('App\Models\Loan');
    }

    public function getFrontIcUrlAttribute()
    {
        if ($this->front_ic && Storage::disk('public')->exists($this->front_ic)) {
            return asset('storage/' . $this->front_ic);
        }

        return null;
    }

    public function getBackIcUrlAttribute()
    {
        if ($this->back_ic && Storage::disk('public')->exists($this->back_ic)) {
            return asset('storage/' . $this->back_ic);
        }

        return null;
    }
}
