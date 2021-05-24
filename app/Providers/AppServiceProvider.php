<?php

namespace App\Providers;

use App\Models\Item;
use App\Models\User;
use App\Observers\ItemObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Item::observe(ItemObserver::class);

        User::observe(UserObserver::class);

        Schema::defaultStringLength(191);
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        Builder::macro('search', function ($field, $needle) {
            return $needle ? $this->where($field, 'like', "%{$needle}%") : $this;
        });

        Builder::macro('searchIn', function ($attributes, $needle) {
            return $this->where(function (Builder $query) use ($attributes, $needle) {
                foreach ($attributes as $attribute) {
                    $query->orWhere($attribute, 'LIKE', "%{$needle}%");
                }
            });
        });

//        ResetPassword::toMailUsing(function ($notifiable, $token) {
//            return (new MailMessage)
//                ->subject('PowerHub - Reset de Senha')
//                ->greeting('Olá!')
//                ->line('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.')
//                ->action(Lang::get('Aperte Aqui recuperar sua senha'), url(config('app.url').route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
//                ->line('Este link de redefinição de senha expirará em 60 minutos.')
//                ->line('Se você não solicitou uma redefinição de senha, nenhuma outra ação é necessária.');
//        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
