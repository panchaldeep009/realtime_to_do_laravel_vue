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
        $allUsers = ToDoUsers::select('to_do_user_id', 'to_do_user_name', 'updated_at')->where("to_do_user_csrf", "!=" , $request->header("X-CSRF"))->get();
        $thisUser = ToDoUsers::select('to_do_user_id', 'to_do_user_name', 'updated_at')->where("to_do_user_csrf", $request->header("X-CSRF"));
        
        // To Keep Current user Online 
        if($thisUser->exists()){
            $thisUser->update(["updated_at" => Carbon::now()]);
        }

        return response()->json([
            "users" => 

            /// Mapping Online status of Each Users
            array_map(function ($user){
                $last_update_time = new Carbon($user['updated_at']);
                $diff = $last_update_time->diffInSeconds(Carbon::now());
                $user['online'] = $diff < 3;
                return $user;
            }, json_decode(json_encode($allUsers), True)),

            "this_user" => $thisUser->exists() ? $thisUser->first() : false
        ], 200);
        
    }
    
    /// (GET)/user
    public function getUser(Request $request){
        $thisUser = ToDoUsers::where("to_do_user_csrf", $request->header("X-CSRF")) ;
        if($thisUser->exists()){
            return response()->json([
                "user" => $thisUser->first(),
            ], 200);
        } else {
            return response()->json([
                "error" => "User not found",
            ], 404);
        }

    }
    
    /// (POST)/user
    public function createUser(Request $request){

        $validator = Validator::make($request->all(), [
            "user_name" => "required|max:255",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors(),
            ], 400);
        }

        $newUser = new ToDoUsers;
        $newUser->to_do_user_name = $request->user_name;
        $newUser->to_do_user_csrf = $request->header("X-CSRF");
        $newUser->save();

        return response()->json([
            "message" => "Task added successfully",
        ], 200);
    }

    /// (DELETE)/user
    public function deleteUser(Request $request){
        
        $thisUser = ToDoUsers::where("to_do_user_csrf", $request->header("X-CSRF"));

        if($thisUser->exists()){

            $thisUser->delete();
            return response()->json([
                "message" => "User Deleted successfully",
            ], 200);
        } else {
            return response()->json([
                "error" => "User not find",
            ], 404);
        }
    }
}
    