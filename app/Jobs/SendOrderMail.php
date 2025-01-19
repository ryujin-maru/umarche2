<?php

namespace App\Jobs;

use App\Mail\OrderMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendOrderMail implements ShouldQueue
{
    use Queueable;

    public $product;
    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct($product,$user)
    {
        $this->product = $product;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->product['email'])
        ->send(new OrderMail($this->product,$this->user));
    }
}
