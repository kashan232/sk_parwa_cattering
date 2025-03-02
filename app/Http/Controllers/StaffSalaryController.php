<?php

namespace App\Http\Controllers;

use App\Models\StaffSalary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffSalaryController extends Controller
{
    
    public function StaffSalary()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            $staffs_salaires = StaffSalary::all();
            $staffs = User::where('usertype', '=', 'staff')->get();
            return view('admin_panel.staff_salary.staff_salary', [
                'staffs_salaires' => $staffs_salaires,
                'staffs' => $staffs,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function store_StaffSalary(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            StaffSalary::create([
                'staff_name'          => $request->staff_name,
                'staff_date'          => $request->staff_date,
                'staff_year'          => $request->staff_year,
                'staff_month'          => $request->staff_month,
                'staff_amount'          => $request->staff_amount,
                'staff_status'          => $request->staff_status,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'Staff salary  has been  generated successfully');
        } else {
            return redirect()->back();
        }
    }
    public function update_StaffSalary(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            // dd($request);
            $update_id = $request->input('staff_id');
            $name = $request->input('name');
            $email = $request->input('email');
            $username = $request->input('username');


            StaffSalary::where('id', $update_id)->update([
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
