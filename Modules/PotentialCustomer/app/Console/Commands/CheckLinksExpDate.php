<?php

namespace Modules\PotentialCustomer\app\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Modules\PotentialCustomer\app\Models\Link;


class CheckLinksExpDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-links-exp-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $links = Link::whereNotNull('expired_at')
        ->where('expired_at', '<', now())
        ->get();
        foreach($links as $link)
        {
            if ($link->expired_at && Carbon::now()->gt($link->expired_at)) {
                $link->update([
                    'status' => 'inactive'
                ]);
            }
        }
    }
}
