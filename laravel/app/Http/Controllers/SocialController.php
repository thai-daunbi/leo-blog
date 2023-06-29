<?php

namespace App\Http\Controllers;

use App\Models\Linkedin;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    /**
     * Redirect the user to the LinkedIn authentication page.
     *
     * @return RedirectResponse
     */
    public function redirectToLinkedIn(): RedirectResponse
    {
        return Socialite::driver('linkedin')->redirect();
    }

    /**
     * Obtain the user information from LinkedIn.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws ValidationException
     */
    // public function handleLinkedinCallback(Request $request): Application|RedirectResponse|Redirector
    // {
    //     $user = null;
    //     try {
    //         $user = Socialite::driver('linkedin')->user();
    //     } catch (\Exception $e) {
    //         return redirect('/');
    //     }

    //     $authLinkedin = $this->findOrCreateLinkedin($user);
    //     Auth::guard('linkedin')->login($authLinkedin, true);

    //     return redirect()->to('/');
    // }


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

    /**
     * Return user if exists; create and return if doesn't.
     *
     * @param $linkedinUser
     * @return mixed
     */
    public function findOrCreateLinkedin($linkedinUser): mixed
    {
        $linkedin = Linkedin::where('provider_id', $linkedinUser->id)->first();
        if ($linkedin) {
            return $linkedin;
        }

        return Linkedin::create([
            'name' => $linkedinUser->name,
            'email' => $linkedinUser->email,
            'provider' => 'linkedin',
            'provider_id' => $linkedinUser->id,
            'password' => encrypt('123456dummy')
        ]);
    }

    public function login(string $provider)
    {
        if (!array_key_exists($provider, config('services'))) {
            return redirect('login')->with('error', $provider . ' is not supported.');
        }
        return Socialite::driver($provider)
                        ->redirect();
    }

    public function callback(String $provider)
    {
        try{
            $socialUser = Socialite::driver($provider)->user();

            $socialAccount = Linkedin::where([
                'provider_name' => $provider,
                'provider_id'   => $socialUser->id
            ])->first();

            // If Social Account Exist then Find User and Login
            if($socialAccount){
                $socialAccount->update([
                    'token' => $socialUser->token,
                ]);

                Auth::login($socialAccount->user);
                return redirect()->route('dashboard');
            }

            // Find User
            $user = User::where([
                'email'=> $socialUser->getEmail()
            ])->first();

            if(!$user){
                if ($socialUser->getName()){
                    $name = $socialUser->getName();
                } else {
                    $name = $socialUser->getNickName();
                }

                $user = User::create([
                    'email'=>$socialUser->getEmail(),
                    'name' =>$name,
                    'profile_photo_path' => $socialUser->getAvatar(),
                    'email_verified_at' => now(),
                ]);
            }

            // Create Social Accounts
            $user->socialAccounts()->create([
                'provider_name' => $provider,
                'name'          => $socialUser->name,
                'email'         => $socialUser->email,
                'provider_id'   => $socialUser->id,
                'token'         => $socialUser->token,
            ]);

            Auth::login($user);
            return redirect()->route('dashboard');

        }catch(\Exception $e){
            return redirect()->route('login');
        }

    }
}
