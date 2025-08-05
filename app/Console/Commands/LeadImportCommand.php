<?php

namespace App\Console\Commands;

use App\Jobs\LeadImportJob;
use App\Models\LeadImport;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class LeadImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lead-import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lead Import From Uploaded File';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Starting lead importing');

            LeadImport::pending()
                ->chunk(100, function (Collection $imports) {
                    foreach ($imports as $import) {
                        dispatch(new LeadImportJob($import));
                    }
                });

            $this->info('Lead Import completed.');
        } catch (\Throwable $th) {
            info($th);
        }
    }
}
