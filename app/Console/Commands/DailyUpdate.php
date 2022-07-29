<?php

namespace App\Console\Commands;

use App\Models\JobVacancies;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Console\Command;

class DailyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update coins every day';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $coinsLimit = Setting::OrderBy('id', 'desc')->first();
         User::increment('coins', $coinsLimit?$coinsLimit->coins_limit:5);

    }
}
