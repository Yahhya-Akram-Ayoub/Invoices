<?php

namespace App\Models;

use App\Models\User;
use App\Models\invoices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory  ;
    protected $fillable = ['section_name','description','user_id'];



    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function invoices(){
        return $this->hasMany(invoices::class);
    }
}
