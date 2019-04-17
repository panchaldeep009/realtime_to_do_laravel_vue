<?php

namespace App\Http\Controllers;

use App\ToDoUsers;

use Illuminate\Http\Request;
use Validator;    

class ToDoUserController extends Controller
{
    /// (GET)/users
    public function getUsers(){
        return response()->json([
            "status" => 200,
            "tasks" => ToDoUsers::all(),
        ]);
    }
    
    /// (POST)/get_user
    public function getUser(Request $request){

        $validator = Validator::make($request->all(), [
            "csrf_token" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "error" => $validator->errors(),
            ]);
        }
        
        
        $thisUser = ToDoUsers::where("to_do_user_csrf", $request->csrf_token);

        if($thisUser->exists()){

            return response()->json([
                "status" => 200,
                "user" => $thisUser->first(),
            ]);

        } else {
            return response()->json([
                "status" => 200,
                "error" => "User not find",
            ]);
        }

    }
    
    /// (POST)/user
    public function createUser(Request $request){

        $validator = Validator::make($request->all(), [
            "user_name" => "required|max:255",
            "csrf_token" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "error" => $validator->errors(),
            ], 400);
        }

        $newUser = new ToDoUsers;
        $newUser->to_do_user_name = $request->user_name;
        $newUser->to_do_user_csrf = $request->csrf_token;
        $newUser->save();

        return response()->json([
            "status" => 200,
            "message" => "Task added successfully",
        ]);
    }

    /// (DELETE)/user
    public function deleteUser(Request $request){
        $validator = Validator::make($request->all(), [
            "csrf_token" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "error" => $validator->errors(),
            ]);
        }
        
        $thisUser = ToDoUsers::where("to_do_user_csrf", $request->csrf_token);

        if($thisUser->exists()){

            $thisUser->delete();
            return response()->json([
                "status" => 200,
                "message" => "User Deleted successfully",
            ]);
        } else {
            return response()->json([
                "status" => 200,
                "error" => "User not find",
            ]);
        }
    }
}
    