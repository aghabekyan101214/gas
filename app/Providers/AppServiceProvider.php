<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Client;
use App\StaticData;
use App\Http\Controllers\CountFuelsController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $bonus = Client::selectRaw("sum(bonus) as bonus")->first();
        $static = StaticData::first();
        if(isset($static->updated_at) && $static->updated_at != Carbon::today()) {
            $static->updated_at = Carbon::today();
            $static->seen_count = 0;
            $static->save();
        }
        $seen_count = $static->seen_count ?? 0;
        $current_count = count(CountFuelsController::count()) ?? 0;
        View::share('bonus_points', $bonus);
        View::share('seen_count', $seen_count);
        View::share('current_count', $current_count);
    }
}
