<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationReminderMail;
use Carbon\Carbon;

class SendReservationReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = '予約当日のリマインダーメールを送信';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        // 予約当日のデータを取得
        $reservations = Reservation::where('date', $today)->get();

        foreach ($reservations as $reservation) {
            // メール送信
            Mail::to($reservation->user->email)
                ->send(new ReservationReminderMail($reservation));

            $this->info("リマインダーメールを送信しました: " . $reservation->user->email);
        }

        return Command::SUCCESS;
    }
}
