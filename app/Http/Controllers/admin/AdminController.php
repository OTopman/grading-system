<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(){
        $data['page_title'] = "Dashboard";

        $data['total_student'] = User::where('role_id',1)->count();
        $data['total_staff'] = User::where('role_id',2)->count();
        $data['total_admin'] = User::where('role_id',3)->count();

        return view('admin.dashboard',$data);
    }

    public function users(){
        $data['page_title'] = "All Admin / Staff";
        return view('admin.users',$data);
    }

    public function students(){
        $data['page_title'] = "All Students";
        return view('admin.students',$data);
    }
}
