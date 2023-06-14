<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }
    
    public function show($id)
    {
        $user = User::with('city')->find($id); // $id에 해당하는 모델 인스턴스를 조회합니다.

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'cityName' => $user->city->name,
            'Email' => $user->email,
        ]);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'city_id' => 'required|integer',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'city_id' => $request->input('city_id'),
            'email' => $request->input('email'),
        ]);

        return response()->json(['message' => 'User created!', 'user' => $user], 201);
    }

    public function update(Request $request, $id)
    {
        // 업데이트할 사용자 데이터를 찾습니다.
        $user = User::find($id);

        // 사용자 데이터가 존재하지 않을 경우, 404 에러를 반환합니다.
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // 클라이언트 측에서 보낸 데이터로 사용자 데이터를 업데이트합니다.
        $user->name = $request->input('name');
        $user->city_id = $request->input('city_id');
        $user->email = $request->input('email');

        // 업데이트된 사용자 데이터를 저장합니다.
        $user->save();

        // 업데이트된 사용자 데이터를 반환합니다.
        return response()->json($user);
    }
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }
    

}
