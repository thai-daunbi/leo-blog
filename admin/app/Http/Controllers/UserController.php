<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('user.edit', compact('user'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
        ]);

        $request->user()->update($request->all());
        return redirect()->route('user.edit')->with('success', '프로필이 수정되었습니다.');
    }
    public function toggleActivation(User $user)
    {
        $user->email_verified_at = $user->email_verified_at ? null : now();
        $user->save();

        return redirect()->back()->with('success', '사용자 상태가 변경되었습니다');
    }

}
