<?php

namespace App\Http\Controllers;

use App\ToDoUsers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Carbon;

class ToDoUserController extends Controller
{
    /// (GET)/users
    public function getUsers(Request $request){
        $allUsers = ToDoUsers::select('to_do_user_name', 'updated_at')->where("to_do_user_csrf", "!=" , $request->header("X-CSRF"))->get();
        $thisUser = ToDoUsers::select('to_do_user_name', 'updated_at')->where("to_do_user_csrf", $request->header("X-CSRF"));
        return response()->json([
            "status" => 200,
            "users" => 

            /// Mapping Online status of Each Users
            array_map(function ($user){
                $last_update_time = new Carbon($user['updated_at']);
                $diff = $last_update_time->diffInSeconds(Carbon::now());
                $user['online'] = $diff < 10;
                return $user;
            }, json_decode(json_encode($allUsers), True)),

            "this_user" => $thisUser->exists() ? $thisUser->first() : false
        ]);
    }
    
    /// (GET)/user
    public function getUser(Request $request){
        $thisUser = ToDoUsers::where("to_do_user_csrf", $request->header("X-CSRF")) ;
        if($thisUser->exists()){
            return response()->json([
                "status" => 200,
                "user" => $thisUser->first(),
            ]);
        } else {
            return response()->json([
                "status" => 200,
                "error" => "User not found",
            ]);
        }

    }
    
    /// (POST)/user
    public function createUser(Request $request){

        $validator = Validator::make($request->all(), [
            "user_name" => "required|max:255",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "error" => $validator->errors(),
            ], 400);
        }

        $newUser = new ToDoUsers;
        $newUser->to_do_user_name = $request->user_name;
        $newUser->to_do_user_csrf = $request->header("X-CSRF");
        $newUser->save();

        return response()->json([
            "status" => 200,
            "message" => "Task added successfully",
        ]);
    }

    /// (DELETE)/user
    public function deleteUser(Request $request){
        
        $thisUser = ToDoUsers::where("to_do_user_csrf", $request->header("X-CSRF"));

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
    /// (DELETE)/keepOnline
    public function keepOnline(Request $request){
        
        $thisUser = ToDoUsers::where("to_do_user_csrf", $request->header("X-CSRF"));

        if($thisUser->exists()){
            $thisUser->update(["updated_at" => Carbon::now()]);
        }
    }
}
    