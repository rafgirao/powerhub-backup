<?php

namespace App\Http\Controllers\Auth;

use App\Models\Account;
use App\Models\User;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,strict,dns,spoof,filter', 'max:255', 'unique:users'],
            'user_type' => ['required'],
            'company' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $data['name'] = filter_var($data['name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $data['company'] = filter_var($data['company'], FILTER_SANITIZE_SPECIAL_CHARS);

        //Create User
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['user_type'],
            'password' => Hash::make($data['password']),
        ]);

        //Create Account
        $account = Account::create(['company' => $data['company']]);

        //Create UserAccount
        (new UserAccountController)->create($user, $account);
//        (new UserAccountController)->create(User::whereId(17367)->first(), $account);

        return $user;
    }
}
