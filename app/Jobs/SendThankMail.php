<?php

namespace App\Jobs;

use App\Mail\TestMail;
use App\Mail\ThankMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendThankMail implements ShouldQueue
{
    use Queueable;

    public $products;
    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct($products,$user)
    {
        $this->products = $products;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Mail::to('test@example.email')->send(new TestMail());
        Mail::to($this->user)->send(new ThankMail($this->products,$this->user));
    }
}
