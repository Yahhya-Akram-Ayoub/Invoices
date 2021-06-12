<?php

namespace App\Models;

use App\Models\Section;
use App\Models\invoices_attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use HasFactory ,SoftDeletes;

    protected $guarded = [];


    public function invoice()
    {
        return $this->hasMany(invoices_attachment::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
