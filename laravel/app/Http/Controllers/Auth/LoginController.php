<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Exception;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Response;

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
    protected $redirectAfterLogout = '/your-desired-logout-redirect-url';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        if (is_null($user) || $user->status == 1) {
            return back()->withErrors(['email' => '이 이메일은 사용할 수 없습니다']);
        }

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors(['email' => '이 이메일 주소로 가입된 사용자가 없거나 비밀번호가 틀렸습니다. 확인 후 다시 시도해주세요']);
    }

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */

     public function handleLinkedinCallback(Request $request): Application|RedirectResponse|Redirector
{
    try {
        $user = Socialite::driver('linkedin')->user();
    } catch (\Exception $e) {
        return redirect('/');
    }

    // 이 부분
    if (is_null($user->email)) {
        return redirect('/');
    }
    
    $authLinkedin = $this->findOrCreateLinkedin($user);
    Auth::guard('linkedin')->login($authLinkedin, true);

    return redirect()->to('/');
}

//     public function handleProviderCallback(): RedirectResponse
// {
//     try {

//         $user = Socialite::driver('facebook')->user();

//         if(!$user) {
//             // 만약 Facebook SDK에서 사용자 정보가 제대로 반환되지 않으면 에러 처리
//             return redirect()->route('login')->with('error', 'Facebook authentication error: Failed to fetch user information from Facebook.');
//         }

//         $finduser = User::where('facebook_id', $user->id)->first();

//         if($finduser){

//             Auth::login($finduser);

//             return redirect()->intended('dashboard');

//         }else{
//             $newUser = User::create([
//                 'name' => $user->name,
//                 'email' => $user->email,
//                 'facebook_id'=> $user->id,
//                 'password' => encrypt('Test123456')
//             ]);

//             Auth::login($newUser);

//             return redirect()->intended('dashboard');
//         }

//     } catch (Exception $e) {
//         // Facebook SDK에서 예외가 발생하면 에러 처리
//         return redirect()->route('login')->with('error', 'Facebook authentication error: '.$e->getMessage());
//     }
// }



    /**
     * Logout, Clear Session, and Return.
     *
     * @return void
     */
    public function logout(): RedirectResponse
    {
        $user = Auth::user();
        Log::info('User Logged Out. ', [$user]);
        Auth::logout();
        Session::flush();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/home');
    }

    public function loginWithFacebook()
    {
        return $this->redirectToProvider();
    }

}
