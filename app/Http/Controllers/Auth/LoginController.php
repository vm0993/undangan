<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function legacyAuthRedirect() {
        return redirect()->route('login');
    }
    
    protected function credentials(Request $request)
    {
        $field = $this->field($request);

        return [
            $field => $request->get($this->username()),
            'password' => $request->get('password'),
        ];
    }

    public function field(Request $request)
    {
        $email = $this->username();

        return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'username';
    }

    protected function validateLogin(Request $request)
    {
        $field = $this->field($request);

        //$tenantId = \Vimasolusi\Models\Tenant::where('subdomain',$request->subdomain)->get()->first();

        //dd(Route::getCurrentRoute()->getParameter('subdomain'));
        $messages = ["{$this->username()}.exists" => 'The account you are trying to login is not registered or it has been disabled.'];

        $this->validate($request, [
            $this->username() => "required|exists:users,{$field}",
            'password' => 'required',
            //'tenant_id' => $tenantId->id,
        ], $messages);
    }
    
    private function loginFailed()
    {
        return redirect()
            ->back()
            ->withInput()
            ->with('error','Login failed, please try again!');
    }

    /*protected function authenticated(Request $request, $user)
    {
        $user->last_seen_at = Carbon::now()->format('Y-m-d H:i:s');
        $user->save();
    }*/
    
    public function login(Request $request)
    {
        $this->validateLogin($request);
        
        $login_type = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL ) 
            ? 'email' 
            : 'username';

        $request->merge([
            $login_type => $request->input('email')
        ]);
        
        if(Auth::guard()->attempt($request->only($login_type, 'password'))){
            return redirect(route('dashboard'));
        }
        //Authentication failed...
        return $this->loginFailed();
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush(); 
        $request->session()->regenerate(); 
        return redirect('/login');
    }

    public function sessionLocked(Request $request)
    {
        //$userName = auth()->user()->username;
        $this->guard()->logout();
        $request->session()->flush(); 
        $request->session()->regenerate();

        return redirect('/locked');
    }

    public function locked()
    {
        if(!session('lock-expires-at')){
            return redirect('/');
        }

        if(session('lock-expires-at') > now()){
            return redirect('/');
        }

        return view('auth.locked');
    }

    public function unlock(Request $request)
    {
        $check = Hash::check($request->input('password'), $request->user()->password);

        if(!$check){
            return redirect()->route('login.locked')->withErrors([
                'Your password does not match your profile.'
            ]);
        }

        session(['lock-expires-at' => now()->addMinutes($request->user()->getLockoutTime())]);

        return redirect('/');
    }
}
