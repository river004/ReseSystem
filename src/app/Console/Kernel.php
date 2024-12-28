<?php

namespace App\Console;

use App\Console\Commands\SendReservationReminders;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * アプリケーションのコンソールコマンドを登録します。
     *
     * @var array
     */
    protected $commands = [
        // ここでカスタムコマンドを登録できます
        SendReservationReminders::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // 毎朝8時にリマインダーメールを送信
        $schedule->command('reminders:send')->dailyAt('8:00'); // 例: reminders:send コマンドを毎朝8時に実行

        // スケジュールタスクを設定します
        $schedule->command('inspire')->everyMinute();  // 例: inspire コマンドを毎分実行
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
