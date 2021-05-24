<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Integration;
use App\Notifications\SendNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class GoogleTokenExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:google-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return void
     */
    public function handle()
    {
        $acts = Account::All();
        foreach ($acts as $act) {

            $googleCredentials = (new Integration)->googleCredentials($act->id);
            $users = Account::find($act->id)->users;

            if (isset($googleCredentials->status) and $googleCredentials->status == 0) {
                Notification::send($users, new SendNotification(
                        'Importante: O seu Token do Google está Expirando',
                        'Olá!',
                        'O token de acesso ao Google está expirando.',
                        'Se você não renovar seu token, em breve não será mais possível atualizar os dados de vendas e campanhas.',
                        'Clique aqui para renovar seu Token Agora',
                        url('/login'),
                        'Obrigado por usar o PowerHub!')
                );
            }
        }
    }
}
