<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Hash;
use Str;

class ApiController extends Controller
{
    public function Welcome()
    {
        $data=array();

        //main logic
        
        //end

        $final_data="welcome";

        //standard format
        $data['status']=200;
        $data['message']="data get process successful";
        $data['data']=$final_data;


        return response()->json($data);
    }

    public function AllUsersList()
    {
        $data=array();

        //main logic
        $users_data = DB::select("CALL get_all_users_data()");
        //end

        $final_user_data=array();

        foreach($users_data as $user){
            //for storing single user data
            $user_details=array();

            //filter the data
            $user_details['id']=$user->id;
            $user_details['fName']=$user->name;
            $user_details['lName']=$user->lname;
            $user_details['gender']=$user->gender;

            $hobbies=explode(", ", $user->hobbies);

            $user_details['hobbies']=$hobbies;
            $user_details['mobile']=$user->mobile_no;

            //for pushing data in final_user_data array
            $final_user_data[]=$user_details;
        }

        $final_data=$final_user_data;

        //standard format
        $data['status']=200;
        $data['message']="data get process successful";
        $data['data']=$final_data;


        return response()->json($data);
    }

    public function Signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email|unique:users,email',
            'aadhar'=>'required|integer|min:11',
            'country_code'=>'required|integer|min:2',
            'mobile'=>'required|integer|digits:10',
        ]);
        if ($validator->fails()) {

            $errors = "";
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                // Go through each message for this field.
                foreach ($messages as $message) {
                    $errors .= $message;
                    $data['message'] = $errors;
                }
            }
            $data['status'] = 400;
            $data['data'] = (object) [];
        } else {
            //main logic

        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $email = $request->input('email');

        $password = Hash::make($request->input('password'));
        //print_r($password);exit;

        $gender = $request->input('gender');
        $religion = $request->input('religion');

        $hobbies = $request->input('hobbies');
        
        $hobbies_new = $hobbies;

        $aadhar = $request->input('aadhar');
        $country_code = $request->input('country_code');
        $mobile = $request->input('mobile');

        $created_at = date("Y-m-d h:i:s");
        $updated_at = date("Y-m-d h:i:s");

        $insert_user = DB::insert("CALL signup(?,?,?,?,?,?,?,?,?,?,?,?)", array($fname, $lname, $gender, $email, $password, $religion, $hobbies_new, $aadhar, $country_code, $mobile, $created_at, $updated_at));
        
        if($insert_user){
            $data['status']=200;
            $data['message']="signup successful";
            $data['data']="";
        }else{
            $data['status']=400;
            $data['message']="signup failed";
            $data['data']="";
        }

        }
        return response()->json($data);
    }

    public function SendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'countryCode'=>'required',
            'mobileNo'=>'required',
        ]);
        if ($validator->fails()) {

            $errors = "";
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                // Go through each message for this field.
                foreach ($messages as $message) {
                    $errors .= $message;
                    $data['message'] = $errors;
                }
            }
            $data['status'] = 400;
            $data['data'] = (object) [];
        } else {
            //main logic

        $countryCode = $request->input('countryCode');
        $mobileNo = $request->input('mobileNo');

        $otp=rand(100000,999999); //for 6 digit otp
        $otp_token=Str::random(25);

        //third party api code start


        //third party api code end

        $created_at = date("Y-m-d h:i:s");
        $updated_at = date("Y-m-d h:i:s");

        $store_otp = DB::insert("CALL store_otp(?,?,?,?)", array($otp, $otp_token, $created_at, $updated_at));
        
        if($store_otp){

            $final_data=array();
            $final_data['otp']=$otp;
            $final_data['otpToken']=$otp_token;

            $data['status']=200;
            $data['message']="OTP successfully sent";
            $data['data']=$final_data;
        }else{
            $data['status']=400;
            $data['message']="OTP sending failed";
            $data['data']=[];
        }

        }
        return response()->json($data);
    }

    public function VerifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp'=>'required',
            'otpToken'=>'required',
        ]);
        if ($validator->fails()) {

            $errors = "";
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                // Go through each message for this field.
                foreach ($messages as $message) {
                    $errors .= $message;
                    $data['message'] = $errors;
                }
            }
            $data['status'] = 400;
            $data['data'] = (object) [];
        } else {
            //main logic

        $otp = $request->input('otp');
        $otpToken = $request->input('otpToken');

        $created_at = date("Y-m-d h:i:s");
        $updated_at = date("Y-m-d h:i:s");

        $verify_otp = DB::select("CALL verify_otp(?,?)", array($otp, $otpToken));
        
        if(count($verify_otp)>0){

            $update_verified_otp = DB::update("CALL update_verified_otp(?,?,?)", array($otp, $otpToken, $updated_at));

            if($update_verified_otp){
                $data['status']=200;
                $data['message']="OTP successfully verified";
                $data['data']=(object)[];
            }else{
                $data['status']=400;
                $data['message']="OTP already used";
                $data['data']=(object)[];
            }
           
        }else{
            $data['status']=400;
            $data['message']="invalid OTP";
            $data['data']=(object)[];
        }

        }
        return response()->json($data);
    }
}
