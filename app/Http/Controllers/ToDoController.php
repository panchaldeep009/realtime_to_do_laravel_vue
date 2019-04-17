<?php

namespace App\Http\Controllers;

use App\ToDoTask;

use Illuminate\Http\Request; 
use Validator;   

class ToDoController extends Controller
{
    /// (GET)/tasks
    public function getTasks(){
        return response()->json([
            "status" => 200,
            "tasks" => ToDoTask::all(),
        ]);
    }
    
    /// (POST)/task
    public function postTask(Request $request){
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "task" => "required|max:255",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "error" => $validator->errors(),
            ], 400);
        }

        $newTask = new ToDoTask;
        $newTask->to_do_task = $request->task;
        $newTask->to_do_user_id = $request->user_id;
        $newTask->save();

        return response()->json([
            "status" => 200,
            "message" => "Task added successfully",
        ]);
    }
    
    /// (PUT)/task
    public function updateTask(Request $request){
        $validator = Validator::make($request->all(), [
            "task_id" => "required",
            "task" => "required|max:255",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "error" => $validator->errors(),
            ]);
        }
        
        $thisTask = ToDoTask::where("to_do_id", $request->task_id);

        if($thisTask->exists()){

            $thisTask->update(['to_do_task' => $request->task]);

            return response()->json([
                "status" => 200,
                "message" => "Task updated successfully",
            ]);
        } else {
            return response()->json([
                "status" => 200,
                "error" => "Task not find",
            ]);
        }

    }

    /// (DELETE)/task
    public function deleteTask(Request $request){
        $validator = Validator::make($request->all(), [
            "task_id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "error" => $validator->errors(),
            ]);
        }
        
        $thisTask = ToDoTask::where("to_do_id", $request->task_id);

        if($thisTask->exists()){

            $thisTask->delete();
            return response()->json([
                "status" => 200,
                "message" => "Task Deleted successfully",
            ]);
        } else {
            return response()->json([
                "status" => 200,
                "error" => "Task not find",
            ]);
        }
    }
}
    