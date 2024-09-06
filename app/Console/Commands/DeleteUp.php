<?php

namespace App\Console\Commands;

use App\Models\Monitoring;
use Illuminate\Console\Command;

class DeleteUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-up';

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
        $limit = 10;
        $data = Monitoring::count();

        if ($data > $limit) {
            Monitoring::orderBy('waktu')->limit($data - $limit)->delete();
        }
    }
}
