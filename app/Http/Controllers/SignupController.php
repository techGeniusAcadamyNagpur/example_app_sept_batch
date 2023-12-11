<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function Index()
    {

        $a = 10;
        $b = 20;

        $sum = "the sum is " . $a + $b;
        $sub = "the sub is " . $a - $b;
        $div = "the sum is " . $a / $b;

        print_r($sum);
    }

    public function Signup(Request $request)
    {
        $this->validate($request, [
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email',
            'aadhar'=>'required|integer|min:11',
            'country_code'=>'required|integer|min:2',
            'mobile'=>'required|integer|digits:10',
        ]);

        

        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $email = $request->input('email');

        $password = Hash::make($request->input('password'));

        $gender = $request->input('gender');
        $religion = $request->input('religion');

        $hobbies = $request->input('hobbies');
        
        $hobbies_new = implode(", ", $hobbies);

        $aadhar = $request->input('aadhar');
        $country_code = $request->input('country_code');
        $mobile = $request->input('mobile');

        $created_at = date("Y-m-d h:i:s");
        $updated_at = date("Y-m-d h:i:s");

        $insert_user = DB::insert("CALL signup(?,?,?,?,?,?,?,?,?,?,?,?)", array($fname, $lname, $gender, $email, $password, $religion, $hobbies_new, $aadhar, $country_code, $mobile, $created_at, $updated_at));

        //dd($insert_user);

        // send email
        $reciverEmail = $email;
        $reciverName = $fname;
        $subject = "Your signup was successful for out platform ";
        $body = "<html><head></head><body><p>Hello,</p><h1 style='color:green'>Welcome " . $fname . " to our platform.</h1></p></body></html";

        $send_sms = (new ApiController())->SendEmail($reciverEmail, $reciverName, $subject, $body);

         return redirect(url('login'))->with('success', 'Account Successfully Created please login to continue');
    }
}
