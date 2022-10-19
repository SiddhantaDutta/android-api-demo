<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use DB;
class ApiController extends Controller
{
    public function register(Request $request)
    {
        $count=DB::table('users')->where('phone_no',$request->phone_no)->count();
        if($count==0){
            $table=new User;
            $table->name=$request->name;
            $table->phone_no=$request->phone_no;
            $table->password=md5($request->password);
            $table->token=$token=Hash::make($request->phone_no.time());
            $table->save();
            $data=[
                "id"=>$table->id,
                "name"=>$table->name,
                "phone_no"=>$table->phone_no,
                "token"=>$table->token
            ];
            $message="You have successfully registered.";
            $respo=200;
            $status='1';
        }else{
            $data=[];
            $message="This phone no already registered.";
            $respo=200;
            $status='0';
        }

         return response()->json([
                'data' =>$data,
              'message' => $message,
              'status' => $status
            ], $respo);
    }
    public function login(Request $request)
    {
        $count=DB::table('users')->where('phone_no',$request->phone_no)->count();
        if($count==0){
            $data=[];
            $message="This phone no is not registered.";
            $respo=200;
            $status='0';
        }else{
            $info=DB::table('users')->where('phone_no',$request->phone_no)->where('password',md5($request->password))->first();
            $table=User::find($info->id);
            $table->token=$token=Hash::make($request->phone_no.time());
            $table->save();
            $data=[
                "id"=>$table->id,
                "name"=>$table->name,
                "phone_no"=>$table->phone_no,
                "token"=>$table->token
            ];
            $message="You have successfully logedin.";
            $respo=200;
            $status='1';
        }
        return response()->json([
            'data' =>$data,
          'message' => $message,
          'status' => $status
        ], $respo);
    }
}
