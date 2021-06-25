<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Section;
use App\Models\invoices;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles_name',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles_name' => 'array',
    ];

    public function isOnline(){
        return Cache::has('user-is-online-'.$this->id);
    }
    public function Section()
    {
        return $this->hasMany(Section::class);
    }
    public function branchs()
    {
        return $this->hasMany(Branch::class);
    }
    public function Invoices()
    {
        return $this->hasMany(invoices::class);
    }
}
