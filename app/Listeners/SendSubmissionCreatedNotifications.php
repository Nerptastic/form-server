<?php

namespace App\Listeners;

use App\Events\SubmissionCreated;
use App\Models\User;
use App\Notifications\NewSubmission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSubmissionCreatedNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SubmissionCreated $event): void
    {
      foreach (User::whereNot('id', $event->submission->user_id)->cursor() as $user) {
        $user->notify(new NewSubmission($event->submission));
      }
    }
}
