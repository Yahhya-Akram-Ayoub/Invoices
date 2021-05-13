<?php

namespace App\Models;

use App\Models\invoices_attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoices extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function invoice()
    {
        return $this->hasMany(invoices_attachment::class);
    }
}
