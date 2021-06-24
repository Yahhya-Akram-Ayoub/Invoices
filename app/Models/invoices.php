<?php

namespace App\Models;

use App\Models\User;
use App\Models\Section;
use App\Models\invoices_details;
use App\Models\invoices_attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoices extends Model
{
    use HasFactory, SoftDeletes;
    use SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'invoices.invoice_number' => 5,
            'invoices.discount' => 5,
            'invoices.rate_vat' => 5,
            'invoices.total_amount' => 5,
            'invoices_details.amount_paid' => 8,
            'invoices_attachments.file_name' => 10,

        ],
        'joins' => [
            'invoices_details' => ['invoices.id','invoices_details.invoices_id'],
            'invoices_attachments' => ['invoices.id','invoices_attachments.invoices_id'],
        ],
    ];




    public function invoices_attachments()
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
