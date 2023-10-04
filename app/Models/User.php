<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes, HasRoles, HasApiTokens, Notifiable;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'profile_image',
        'email_verified_at',
        'password',
        'is_active',
        'deleted_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function userDetails(): HasOne
    {
        return $this->hasOne(UserDetails::class);
    }

    public function studentOptions(): HasOne
    {
        return $this->hasOne(StudentOptions::class);
    }

    public function companySubscription(): HasOne
    {
        return $this->hasOne(CompanySubscription::class,  'user_id', 'id');
    }

    public function teacherOptions(): HasOne
    {
        return $this->hasOne(TeacherOptions::class);
    }

    public function studentSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    public function availability(): HasMany
    {
        return $this->hasMany(Availability::class, 'teacher_id');
    }

    public function studentAutoScheduleTimes(): HasMany
    {
        return $this->hasMany(StudentAutoScheduleTime::class, 'student_id', 'id');
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class, 'user_id', 'id')
                    ->where('is_active', true);
    }

    public function userDevices(): HasMany
    {
        return $this->hasMany(UserDevice::class);
    }

    public function providers() : HasMany
    {
        return $this->hasMany(Provider::class,'user_id', 'id');
    }

}
