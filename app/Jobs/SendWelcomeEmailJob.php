<?php

namespace App\Jobs;

use App\Mail\AccountCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user, $employee, $password;

    public $tries = 3;

    public $retryAfter = 60;    //  1 minute
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $employee, $password)
    {
        $this->user = $user;
        $this->employee = $employee;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new AccountCreated($this->user, $this->employee, $this->password));
    }
}
