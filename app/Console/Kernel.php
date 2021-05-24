<?php

namespace App\Console;

use App\Console\Commands\AcEmailCampaigns;
use App\Console\Commands\AcEmailInvalidAll;
use App\Console\Commands\AcLeadsAll;
use App\Console\Commands\AcLeadsToday;
use App\Console\Commands\AcLeadsYesterday;
use App\Console\Commands\AcLeadTagAll;
use App\Console\Commands\AcLeadTagToday;
use App\Console\Commands\AcLeadTagYesterday;
use App\Console\Commands\AcTagsAll;
use App\Console\Commands\AcTagsProjects;
use App\Console\Commands\FbCampaigns;
use App\Console\Commands\FbTokenExpiration;
use App\Console\Commands\FlushRedis;
use App\Console\Commands\GoogleSheetsSales;
use App\Console\Commands\GoogleTokenExpiration;
use App\Console\Commands\HotmartLeads;
use App\Console\Commands\HotmartProducts;
use App\Console\Commands\HotmartSalesAll;
use App\Console\Commands\HotmartSalesLastMonth;
use App\Console\Commands\HotmartSalesLastWeek;
use App\Console\Commands\HotmartSalesToday;
use App\Console\Commands\HotmartSalesYesterday;
use App\Console\Commands\DashboardStats;
use App\Console\Commands\WebhookCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AcEmailCampaigns::class,
        AcEmailInvalidAll::class,
        AcLeadsAll::class,
        AcLeadsToday::class,
        AcLeadsYesterday::class,
        AcTagsAll::class,
        AcLeadTagAll::class,
        AcLeadTagToday::class,
        AcLeadTagYesterday::class,
        AcTagsProjects::class,
        DashboardStats::class,
        FbCampaigns::class,
        FbTokenExpiration::class,
        FlushRedis::class,
        GoogleSheetsSales::class,
        GoogleTokenExpiration::class,
        HotmartLeads::class,
        HotmartProducts::class,
        HotmartSalesAll::class,
        HotmartSalesLastMonth::class,
        HotmartSalesLastWeek::class,
        HotmartSalesToday::class,
        HotmartSalesYesterday::class,
        WebhookCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        $schedule->command('tags:ac-all')->everyThirtyMinutes()->withoutOverlapping();
        $schedule->command('leadTags:ac-today')->everyThirtyMinutes()->withoutOverlapping();
        $schedule->command('leadTags:ac-yesterday')->dailyAt('02:00')->withoutOverlapping();
        $schedule->command('tags:ac-projects')->everyTenMinutes()->withoutOverlapping(); // falta preparar o job e mudar o anterior para 6h

        $schedule->command('campaign:ac')->everyTenMinutes()->withoutOverlapping();
//        $schedule->command('campaign:ac --p')->everyTenMinutes()->withoutOverlapping(); // falta preparar o job e mudar o anterior para 6h

        $schedule->command('products:hotmart-all')->hourly()->withoutOverlapping();

        $schedule->command('sales:hotmart-today')->everySixHours()->withoutOverlapping();
        $schedule->command('sales:hotmart-yesterday')->dailyAt('01:00')->withoutOverlapping();
        $schedule->command('sales:hotmart-month')->monthlyOn(1, '03:00')->withoutOverlapping();

        $schedule->command('sales:sheets --dp=20')->everyFifteenMinutes()->withoutOverlapping();
        $schedule->command('sales:sheets --dp=5000')->dailyAt('02:00')->withoutOverlapping();
        $schedule->command('sales:sheets --dp=10000')->weeklyOn(0, '03:30')->withoutOverlapping();
        $schedule->command('sales:sheets --dp=0')->twiceMonthly(1, 16,'04:00')->withoutOverlapping();

        $schedule->command('campaign:fb --dp=today')->hourly()->withoutOverlapping();
        $schedule->command('campaign:fb --dp=yesterday')->dailyAt('05:00')->withoutOverlapping();
        $schedule->command('campaign:fb --dp=7')->weeklyOn(1, '03:30')->withoutOverlapping();
        $schedule->command('campaign:fb --dp=30')->monthlyOn(1, '04:30')->withoutOverlapping();
        $schedule->command('token:fb-expiration')->dailyAt('06:00')->withoutOverlapping();
        $schedule->command('token:google-expiration')->dailyAt('06:00')->withoutOverlapping();

        $schedule->command('stats')->everyTenMinutes()->withoutOverlapping();

//        $schedule->command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping();

        $schedule->command('backup:clean')->daily()->at('01:30');
        $schedule->command('backup:run')->everyFourHours();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
