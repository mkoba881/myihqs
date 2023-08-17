<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // 正しいクラスを指定する
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // 他のアクション省略...

    public function assignRoleForm()
    {
        //$users = User::where('role', '!=', 'admin')->get();
        $users = User::whereNull('role')->get();
        //dd($users);
        return view('admin.assign_role_form', compact('users'));
    }

    public function assignRole(Request $request)
    {
        $user = User::findOrFail($request->input('user_id'));
        $user->role = 'admin';
        $user->save();

        return redirect()->route('admin.assign_role_form')->with('success', '管理者権限が付与されました');
    }
}
