<?php

namespace App\Models;

use App\Models\invoices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoices_attachment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(invoices::class);
    }
    public function Users()
    {
        return $this->belongsTo(User::class);
    }
}
