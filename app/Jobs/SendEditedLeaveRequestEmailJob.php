<?php

namespace App\Jobs;

use App\Mail\LeaveRequestEdited;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEditedLeaveRequestEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $leaveRequest;
    public $tries = 3;
    public $retryAfter = 60;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(config('app.hr_email'))->send(new LeaveRequestEdited($this->leaveRequest));
    }
}
