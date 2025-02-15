<?php

declare(strict_types=1);

namespace Modules\Common\Logs\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteOldAccessLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-access-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete access logs older than six months.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        DB::table('access_logs')->where('created_at', '<', $sixMonthsAgo)->delete();
        $this->info('Old access logs deleted successfully.');

        return 0;
    }
}
