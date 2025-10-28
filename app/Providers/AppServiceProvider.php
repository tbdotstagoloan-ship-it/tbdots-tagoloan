<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Repositories\Reports\ReportRepositoryInterface;
use App\Repositories\Reports\ReportRepository;
use Illuminate\Support\Facades\View;
use App\Models\MedicationAdherence;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
    }  

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // share missed adherence count (last 7 days) with all views
        try {
            $since = Carbon::now()->subDays(7)->toDateString();
            $missedCount = MedicationAdherence::where('status', 'missed')
                ->whereDate('date', '>=', $since)
                ->distinct('username')
                ->count('username');

            View::share('missedAdherenceCount', $missedCount);
        } catch (\Throwable $e) {
            // during migrations or when DB is not available, avoid breaking rendering
            View::share('missedAdherenceCount', 0);
        }
    }
}
