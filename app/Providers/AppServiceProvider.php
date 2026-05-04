<?php

namespace App\Providers;

use App\Models\UtilityBill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.partials.sidebar', function (\Illuminate\View\View $view): void {
            $tenantUnseenBillCount = 0;

            if (Auth::check() && Auth::user()->isTenant()) {
                $tenantUnseenBillCount = UtilityBill::query()
                    ->where('tenant_id', Auth::id())
                    ->whereNull('tenant_viewed_at')
                    ->count();
            }

            $view->with('tenantUnseenBillCount', $tenantUnseenBillCount);
        });
    }
}
