<?php

namespace App\Models;

use App\Models\User;
use App\Models\invoices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoices_details extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function invoices()
    {
        return $this->belongsTo(invoices::class);
    }
    public function Users()
    {
        return $this->belongsTo(User::class);
    }
}
