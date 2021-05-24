<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Integration;
use App\Notifications\SendNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class FbTokenExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:fb-expiration';

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

            $fbCredentials = (new Integration)->fbCredentials($act->id);
            $users = Account::find($act->id)->users;

            if (isset($fbCredentials->expiresIn) and $fbCredentials->expiresIn < Carbon::now()->addDays(3)) {
                Notification::send($users, new SendNotification(
                        'Importante: O seu Token do Facebook está Expirando',
                        'Olá!',
                        'O token de acesso ao Facebook está expirando.',
                        'Se você não renovar seu token, em breve não será mais possível atualizar os dados de campanhas.',
                        'Clique aqui para renovar seu Token Agora',
                        url('/ln/facebook'),
                        'Obrigado por usar o PowerHub!')
                );
            }

            if (isset($fbCredentials->status) and $fbCredentials->status == 0) {
                Notification::send($users, new SendNotification(
                    'Atenção: O seu Token do Facebook Expirou',
                    'Olá!',
                    'O seu token de acesso ao Facebook expirou.',
                    'Não é mais possível atualizar os dados de campanhas.',
                    'Clique aqui para renovar seu Token Agora',
                    url('/ln/facebook'),
                    'Obrigado por usar o PowerHub!'),
                );
            }
        }
    }
}
