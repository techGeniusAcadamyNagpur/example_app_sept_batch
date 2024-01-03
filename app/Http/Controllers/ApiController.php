<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Illuminate\Http\Request;
use Str;
use Twilio\Rest\Client;
use Validator;

class ApiController extends Controller
{
    public function Welcome()
    {
        $data = array();

        //main logic

        //end

        $final_data = "welcome";

        //standard format
        $data['status'] = 200;
        $data['message'] = "data get process successful";
        $data['data'] = $final_data;

        return response()->json($data);
    }

    public function AllUsersList()
    {
        $data = array();

        //main logic
        $users_data = DB::select("CALL get_all_users_data()");
        //end

        $final_user_data = array();

        foreach ($users_data as $user) {
            //for storing single user data
            $user_details = array();

            //filter the data
            $user_details['id'] = $user->id;
            $user_details['fName'] = $user->name;
            $user_details['lName'] = $user->lname;
            $user_details['gender'] = $user->gender;

            $hobbies = explode(", ", $user->hobbies);

            $user_details['hobbies'] = $hobbies;
            $user_details['mobile'] = $user->mobile_no;

            //for pushing data in final_user_data array
            $final_user_data[] = $user_details;
        }

        $final_data = $final_user_data;

        //send sms
        $country_code = "91";
        $mobile = "8830701905";
        $message = "Some is using your all user list API";
        $send_sms = $this->SendSMS($country_code, $mobile, $message);

        //standard format
        $data['status'] = 200;
        $data['message'] = "data get process successful";
        $data['data'] = $final_data;

        return response()->json($data);
    }

    public function Signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:users,email',
            'aadhar' => 'required|integer|min:11',
            'country_code' => 'required|integer|min:2',
            'mobile' => 'required|integer|digits:10',
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

            if ($insert_user) {
                try {
                    //send sms
                    $message = "Hi, " . $fname . " your signup was successful";
                    $send_sms = $this->SendSMS($country_code, $mobile, $message);
                } catch (\Exception $e) {
                    //skip
                }

                // send email
                $reciverEmail = $email;
                $reciverName = $fname;
                $subject = "Your signup was successful for out platform ";
                $body = "<html><head></head><body><p>Hello,</p><h1 style='color:green'>Welcome " . $fname . " to our platform.</h1></p></body></html";

                $send_sms = $this->SendEmail($reciverEmail, $reciverName, $subject, $body);

                $data['status'] = 200;
                $data['message'] = "signup successful";
                $data['data'] = "";
            } else {
                $data['status'] = 400;
                $data['message'] = "signup failed";
                $data['data'] = "";
            }

        }
        return response()->json($data);
    }

    public function SendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'countryCode' => 'required',
            'mobileNo' => 'required',
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

            $otp = rand(100000, 999999); //for 6 digit otp
            $otp_token = Str::random(25);

            try {
                //third party api code start

                $sid = env('TWILIO_SID');
                $token = env('TWILIO_TOKEN');
                $twilio = new Client($sid, $token);

                $message = $twilio->messages
                    ->create("+" . $countryCode . $mobileNo, // to
                        array(
                            "from" => "+12164555372",
                            "body" => "Hi, welcome Johns GYM your OTP is " . $otp,
                        )
                    );

                //third party api code end
            } catch (\Exception $e) {
                //skip
            }

            $created_at = date("Y-m-d h:i:s");
            $updated_at = date("Y-m-d h:i:s");

            $store_otp = DB::insert("CALL store_otp(?,?,?,?)", array($otp, $otp_token, $created_at, $updated_at));

            if ($store_otp) {

                $final_data = array();
                //$final_data['otp']=$otp;
                $final_data['otpToken'] = $otp_token;

                $data['status'] = 200;
                $data['message'] = "OTP successfully sent";
                $data['data'] = $final_data;
            } else {
                $data['status'] = 400;
                $data['message'] = "OTP sending failed";
                $data['data'] = [];
            }

        }
        return response()->json($data);
    }

    public function VerifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
            'otpToken' => 'required',
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

            if (count($verify_otp) > 0) {

                $update_verified_otp = DB::update("CALL update_verified_otp(?,?,?)", array($otp, $otpToken, $updated_at));

                if ($update_verified_otp) {
                    $data['status'] = 200;
                    $data['message'] = "OTP successfully verified";
                    $data['data'] = (object) [];
                } else {
                    $data['status'] = 400;
                    $data['message'] = "OTP already used";
                    $data['data'] = (object) [];
                }

            } else {
                $data['status'] = 400;
                $data['message'] = "invalid OTP";
                $data['data'] = (object) [];
            }

        }
        return response()->json($data);
    }

    public function SendSMS($countryCode, $mobileNo, $message)
    {
        //dd($message);
        //third party api code start

        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create("+" . $countryCode . $mobileNo, // to
                array(
                    "from" => "+12164555372",
                    "body" => $message,
                )
            );

        //third party api code end
    }

    public function SendEmail($reciverEmail, $reciverName, $subject, $body)
    {

        //third party code
        // Define the data as an associative array
        $data = array(
            "sender" => array(
                "name" => env('BROVO_EMAIL_NAME'),
                "email" => env('BROVO_EMAIL_SENDER'),
            ),
            "to" => array(
                array(
                    "email" => $reciverEmail,
                    "name" => $reciverName,
                ),
            ),
            "subject" => $subject,
            "htmlContent" => $body,
        );

        // Convert the associative array to a JSON string
        $jsonData = json_encode($data);

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.brevo.com/v3/smtp/email',
            CURLOPT_RETURNTRANSFER => true,
            // ... other options remain unchanged ...
            CURLOPT_POSTFIELDS => $jsonData, // Use the JSON data here
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'api-key: ' . env('BROVO_API_KEY'),
                'content-type: application/json',
                // ... other headers remain unchanged ...
            ),
        ));

        // Execute the request
        $response = curl_exec($curl);

        // Close cURL session
        curl_close($curl);

        // Handle the response as needed
        $decode = json_decode($response);

        $messageId = $decode->messageId;

        $created_at = date("Y-m-d h:i:s");
        $updated_at = date("Y-m-d h:i:s");

        $insert_log = DB::insert("CALL add_message_log(?,?,?)", array($messageId, $created_at, $updated_at));
        //dd($messageId);exit;

        // You can check $response and handle any errors or process the response accordingly

    }

    public function ImportColors(Request $request)
    {
        $validator = Validator::make($request->all(), [

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

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://reqres.in/api/unknown',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            // Handle the response as needed
            $decode = json_decode($response);

            $colors = $decode->data;
            //print_r($colors);exit;

            foreach ($colors as $color) {
                $color_id = $color->id;
                $name = $color->name;
                $color_code = $color->color;

                $insert_color = DB::insert("CALL insert_color(?,?,?)", array($color_id, $name, $color_code));
            }

            $data['status'] = 200;
            $data['message'] = "Successful";
            $data['data'] = (object) [];
        }
        return response()->json($data);
    }

    public function GetUserDetailsByName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
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

            $user_details = DB::select("CALL get_user_by_name(?)", array($fname));

            if (count($user_details) > 0) {

                $data['status'] = 200;
                $data['message'] = "User Found yahhhh";
                $data['data'] = $user_details[0];
            } else {
                $data['status'] = 400;
                $data['message'] = " User not found Nooo";
                $data['data'] = "";
            }

        }
        return response()->json($data);
    }

}
