<?php

namespace App\Models;

use App\Models\User;
use App\Models\Section;
use App\Models\invoices_details;
use App\Models\invoices_attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoices extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];


    public function invoices_attachment()
    {
        return $this->hasMany(invoices_attachment::class);
    }
    public function invoices_details()
    {
        return $this->hasMany(invoices_details::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function Users()
    {
        return $this->belongsTo(User::class);
    }
}
