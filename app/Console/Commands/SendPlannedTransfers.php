<?php

namespace App\Console\Commands;

use App\Mail\SendTransferMail;
use App\Mail\TransferMail;
use App\Plan;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPlannedTransfers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendplannedtransfers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send planned transfers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $transfers = Plan::all();
        foreach($transfers as $transfer)
        {
            if(Carbon::parse($transfer->planned_at)->lte(Carbon::now()->addHours(3)))
            {
                $user = User::whereId($transfer->to)->first();
                $from = User::whereId($transfer->user_id)->first();

                $to = $user->account()->where('user_id', $transfer->to)->first();
                $result = floatval($to->amount) + floatval($transfer->amount);
                $to->amount = round($result,2);
                $to->save();

                Mail::to($user->email)->send(new TransferMail($from->email, $from->name, $transfer->amount, $to->amount));

                Mail::to($from->email)->send(new SendTransferMail($from->name, $user->name, $transfer->amount));

                $transfer->delete();
            }
        }
    }
}
