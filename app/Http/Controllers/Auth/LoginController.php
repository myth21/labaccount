<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Define custom wrapper by trait

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers; // Trait for custom methods (overwritting)

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = Controller::AUTH_REDIRECT_TO;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request) // Default this is core method vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php
    {
        $inputData = $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        if ($inputData['email']) {
            $user = User::where('email', $inputData['email'])->first();
            if (!$user || !$user->active) {
                abort(403);
            }
        }

        return $inputData;
    }

    // Custom method, overwrite core method. This method is in parent.
    /*
    public function showLoginForm() // Default this is core method vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php
    {
        return 'Custom method is run';
    }
    */

}
