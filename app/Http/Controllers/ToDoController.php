<?php

namespace App\Http\Controllers;

use App\ToDoTask;
use App\ToDoUsers;

use Illuminate\Http\Request; 
use Validator;   

class ToDoController extends Controller
{
    /// (GET)/tasks
    public function getTasks(){
        return response()->json([
            "tasks" => ToDoTask::all(),
        ], 200);
    }
    
    /// (POST)/task
    public function postTask(Request $request){
        $validator = Validator::make($request->all(), [
            "task" => "required|max:255",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors(),
            ], 400);
        }

        $thisUser = ToDoUsers::select('to_do_user_id')->where("to_do_user_csrf", $request->header("X-CSRF"));
        
        if (!$thisUser->exists()) {
            return response()->json([
                "error" => "User not found",
            ], 200);
        }

        $newTask = new ToDoTask;
        $newTask->to_do_task = $request->task;
        $newTask->to_do_user_id = $thisUser->first()->to_do_user_id;
        $newTask->save();

        return response()->json([
            "message" => "Task added successfully",
        ], 200);
    }
    
    /// (PUT)/task
    public function updateTask(Request $request){
        $validator = Validator::make($request->all(), [
            "task_id" => "required",
            "task" => "required|max:255",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors(),
            ], 400);
        }

        $thisUser = ToDoUsers::select('to_do_user_id')->where("to_do_user_csrf", $request->header("X-CSRF"));
        $thisTask = ToDoTask::where("to_do_id", $request->task_id);

        if($thisTask->exists()){

            $thisTask->update([
                'to_do_task' => $request->task, 
                'to_do_user_id' => $thisUser->first()->to_do_user_id
            ]);

            return response()->json([
                "message" => "Task updated successfully",
            ], 200);
        } else {
            return response()->json([
                "error" => "Task not find",
            ], 400);
        }

    }

    /// (DELETE)/task
    public function deleteTask(Request $request){
        $validator = Validator::make($request->all(), [
            "task_id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors(),
            ], 400);
        }
        
        $thisTask = ToDoTask::where("to_do_id", $request->task_id);

        if($thisTask->exists()){

            $thisTask->delete();
            return response()->json([
                "message" => "Task Deleted successfully",
            ], 200);
        } else {
            return response()->json([
                "error" => "Task not find",
            ], 200);
        }
    }
}
    