<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\FacebookUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
  
// class FacebookController extends Controller
// {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function redirectToFacebook()
    // {
    //     return Socialite::driver('facebook')->redirect();
    // }
           
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//     public function handleFacebookCallback()
//     {
//         try {
//             $user = Socialite::driver('facebook')->user();
//             // dd($user); // Facebookから取得した情報を表示
//         } catch (\Exception $e) {
//             return redirect('login/facebook');
//         }

//         // すでにFacebook登録済みじゃなかったらユーザーを登録する
//         $userModel = FacebookUser::where('facebook_id', $user->id)->first();
//         if (!$userModel) {
//             $userModel = new User([
//                 'name' => $user->name,
//                 'email' => $user->email,
//                 'facebook_id' => $user->id
//             ]);
//             $userModel->save();
//         }
//         // ログインする
//         Auth::login($userModel);
//         // /homeにリダイレクト
        
//     }
//     public function logout()
//     {
//         $user = Auth::user();
//         Log::info('User Logged Out. ', [$user]);
//         Auth::logout();
//         Session::flush();
//         return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/home');
//     }
// }