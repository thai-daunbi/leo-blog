<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function settings()
    {
        // 관련된 설정 데이터를 반환할 수 있습니다.
        return view('settings');
    }

    public function index()
    {
        $users = User::all()->each(function ($user) {
            if ($user->status == 0) {
                $user->status = '활성화';
            } else {
                $user->status = '비활성화';
            }
        });

        return view('settings', ['users' => $users]);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit',compact('user'));
    }

    public function deactivateUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 1; // Set the account to active
        $user->email_verified_at = NULL;
        // $user->update(['status' => 1, 'email_verified_at' => NULL]);
        $user->save();
        return redirect()->back()->with('message', '사용자 계정이 비활성화되고 이메일 인증이 취소었습니다.');
    }

    public function activateUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 0; // Set the account to active
        $user->email_verified_at = now(); // Set the email verification date to now
        $user->save();

        return redirect()->back()
        ->with('user-activated', "User (ID: {$id}) has been 활성화되고 이메일 인증이 완료되었습니다.");
    }

    public function accountInfoStore(Request $request)
{
    $user = \Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }

    $request->validateWithBag('account', [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', ':255', 'unique:users,email,' . $user->id],
    ]);

    $updateSuccess = $user->update($request->except(['_token']));

    if ($updateSuccess) {
        $message = "Account updated successfully.";
    } else {
        $message = "Error while saving. Please try again.";
    }

    return redirect()->route('edit-user', [$user->id])->with('account_message', $message);
}


    public function changePasswordStore(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required', Password::defaults()],
            'confirm_password' => ['required', 'same:new_password', Password::defaults()],
        ]);
        $validator->after(function ($validator) use ($request) {
            if ($validator->failed()) return;
            if (!Hash::check($request->input('old_password'), \Auth::user()->password)) {
                $validator->errors()->add(
                    'old_password', 'Old password is incorrect.'
                );
            }
        });
        $validator->validateWithBag('password');
        $user = \Auth::user()->update([
            'password' => Hash::make($request->input('new_password')),
        ]);
        if ($user) {
            $message = "Password updated successfully.";
        } else {
            $message = "Error while saving. Please try again.";
        }
        return redirect()->route('edit-user', [\Auth::user()->id])->with('password_message', $message);
    }
}
