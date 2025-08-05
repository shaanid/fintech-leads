<?php

namespace App\Console\Commands;

use App\Imports\LeadImport as ImportsLeadImport;
use App\Jobs\AssignDealsJob;
use App\Jobs\LeadImportJob;
use App\Models\LeadImport;
use Illuminate\Console\Command;


class FundDealsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fund:deals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign deals';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Starting deal assigning');
            dispatch(new AssignDealsJob());
            $this->info('Deal assignment completed.');
        } catch (\Throwable $th) {
            info($th);
        }
    }
}
