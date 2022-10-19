<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
            $table->save();
            $data=[
                "id"=>$table->id,
                "name"=>$table->name,
                "phone_no"=>$table->phone_no
            ];
            $message="You have successfully registered.";
            $respo=200;
        }else{
            $data=[];
            $message="This phone no already registered.";
            $respo=200;
        }

         return response()->json([
                'data' =>$data,
              'message' => $message,
            ], $respo);

    }
}
