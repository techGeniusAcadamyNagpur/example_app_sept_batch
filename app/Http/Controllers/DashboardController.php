<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Dashboard()
    {
        if (Auth::check()) {

            $user = Auth::user();

            $fname = $user->name;
            $lname = $user->lname;

            $users_data = DB::select("CALL get_all_users_data()");
            //dd($users_data);

            return view('dashboard', compact('fname', 'lname', 'users_data'));
        } else {
            return redirect(url('login'))->with('fail', 'you need to login first to discover/access dashboard');
        }
    }

    public function DeleteUser($id)
    {
        $delete_user = DB::delete("CALL delete_user(?)", array($id));

        if ($delete_user) {
            return redirect(url('dashboard'))->with('success', 'User has been successfully deleted ');
        } else {
            return redirect(url('dashboard'))->with('fail', 'User Not deleted ');
        }
    }

    public function EditUser($id)
    {

        $user_data = DB::select("CALL user_data_by_id(?)", array($id));
        //dd($user_data);
        return view('edit_user', compact('user_data'));
    }

    public function Update(Request $request)
    {

        $this->validate($request, [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'aadhar' => 'required|integer|min:11',
            'country_code' => 'required|integer|min:2',
            'mobile' => 'required|integer|digits:10',
        ]);

        $id = $request->input('id');
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $email = $request->input('email');


        $gender = $request->input('gender');
        $religion = $request->input('religion');

        $hobbies = $request->input('hobbies');

        $hobbies_new = implode(", ", $hobbies);

        $aadhar = $request->input('aadhar');
        $country_code = $request->input('country_code');
        $mobile = $request->input('mobile');

        $created_at = date("Y-m-d h:i:s");
        $updated_at = date("Y-m-d h:i:s");

        $update_user = DB::update("CALL update_user(?,?,?,?,?,?,?,?,?,?,?)", array($id, $fname, $lname, $gender, $email, $religion, $hobbies_new, $aadhar, $country_code, $mobile, $updated_at));

        if($update_user){
            return redirect(url('dashboard'))->with('success', 'User Successfully Updated');
        }else{
            return redirect(url('dashboard'))->with('fail', 'User Not Updated');
        }
        
    }

    public function Logout(){
        if (Auth::check()) {

            $user = Auth::logout();

            return redirect(url('login'))->with('success', 'logout Successful');
        } else {
            return redirect(url('login'))->with('fail', 'you need to login first to discover/access dashboard');
        }
    }

    public function SendEmailDashbard()
    {
        if (Auth::check()) {
            return view('send_offer');
        } else {
            return redirect(url('login'))->with('fail', 'you need to login first to discover/access dashboard');
        }
    }

    public function SendOffer(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $title = $request->input('title');
        $description = $request->input('description');

        //query to get users
        $users_data = DB::select("CALL get_all_users_data()");

        foreach($users_data as $user){
            $user_email=$user->email;
            $user_fname=$user->name;

            // send email
            $reciverEmail = $user_email;
            $reciverName = $user_fname;
            $subject = $title;
            $body = $description;

            $send_sms = (new ApiController())->SendEmail($reciverEmail, $reciverName, $subject, $body);
        }
        //dd($users_data);



        return redirect(url('send_offer_dashboard'))->with('success', 'email sent successfully');
        
    }
}
