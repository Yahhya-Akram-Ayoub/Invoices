<?php

namespace App\Notifications;

use App\Models\invoices;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class notifi_addInvoice extends Notification
{
    use Queueable;
    private  $invoice_number, $invoice_id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice_number,$invoice_id)
    {
        $this->invoice_number = $invoice_number;
        $this->invoice_id = $invoice_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }
    public function toDatabase($notifiable)
    {
        return [
            'title' =>  '  تمت اضافة الفاتورة ' . $this->invoice_number ,
            'user' => Auth::user()->name,
            'date' => Date::now(),
            'id' =>$this->invoice_id ,
        ];
    }
}
