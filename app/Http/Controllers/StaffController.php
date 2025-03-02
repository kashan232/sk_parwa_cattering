<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function staff()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            // dd($userId);
            $staffs = User::where('admin_id', '=', $userId)->where('usertype', '=', 'staff')->get();
            // dd($staffs);
            return view('admin_panel.staff.staff', [
                'staffs' => $staffs
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function store_staff(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            User::create([
                'admin_id'    => $userId,
                'name'          => $request->name,
                'username'          => $request->username,
                'email'          => $request->email,
                'usertype'          => $request->usertype,
                'password'          => $request->password,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'Staff has been  created successfully');
        } else {
            return redirect()->back();
        }
    }
    public function update_staff(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            // dd($request);
            $update_id = $request->input('staff_id');
            $name = $request->input('name');
            $email = $request->input('email');
            $username = $request->input('username');


            User::where('id', $update_id)->update([
                'name'          => $name,
                'username'          => $username,
                'email'          => $email,
                'updated_at' => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'Staff Updated Successfully');
        } else {
            return redirect()->back();
        }
    }
}
