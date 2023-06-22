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
    public function handleFacebookCallback(Request $request)
    {
        try {
            $user = Socialite::driver('facebook')->userFromToken($request->input('access_token'));
        } catch (\Exception $e) {
            // 리디렉션 대신 JSON 응답을 반환합니다.
            return response()->json([
                'status' => 'failure',
                'message' => 'Facebook 로그인에 실패했습니다.',
            ]);
        }

        $userModel = User::where('facebook_id', $user->id)->first();

        if (!$userModel) {
            $userModel = new User([
                'name' => $user->name,
                'email' => $user->email,
                'facebook_id' => $user->id,
            ]);
            $userModel->save();
        }

        Auth::login($userModel);

        // 리디렉션 대신 JSON 응답을 반환합니다.
        return response()->json([
            'status' => 'success',
            'message' => '로그인에 성공하였습니다.',
        ]);
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
