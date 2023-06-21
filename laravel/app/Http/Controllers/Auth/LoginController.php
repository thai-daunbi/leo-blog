<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

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
    public function handleProviderCallback(): RedirectResponse
    {

        // error_log("hi");
        // exit;
        try {
            $user = Socialite::driver('facebook')->user();
            // dd($user); // Facebookから取得した情報を表示
        } catch (\Exception $e) {
            return redirect('login/facebook');
        }

        // すでにFacebook登録済みじゃなかったらユーザーを登録する
        $userModel = User::where('facebook_id', $user->id)->first();
        if (!$userModel) {
            $userModel = new User([
                'name' => $user->name,
                'email' => $user->email,
                'facebook_id' => $user->id
            ]);
            $userModel->save();
        }
        // ログインする
        Auth::login($userModel);
        // /home으로 리디렉션합니다
        return redirect('home');
    }


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
