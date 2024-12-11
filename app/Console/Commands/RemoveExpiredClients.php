<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Client;
use Carbon\Carbon;

class RemoveExpiredClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clients:remove-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove clients whose end_schedule has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        // Find and delete expired clients
        $expiredClients = Client::where('end_schedule', '<', $now)->get();

        foreach ($expiredClients as $client) {
            $this->info("Deleting client: {$client->name}");
            $client->delete();
        }

        $this->info('Expired clients removed successfully.');
    }
}
