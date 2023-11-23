<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
