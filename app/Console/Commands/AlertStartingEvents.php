<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class AlertStartingEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:alert-starting-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert attendees that their event is starting soon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $eventsToday = Event::whereBetween('start_time', [
            Carbon::today(),
            Carbon::tomorrow()->subSecond()
        ])->get();

        foreach ($eventsToday as $event) {
            $event->sendStartingNotification();
        }
    }
}
