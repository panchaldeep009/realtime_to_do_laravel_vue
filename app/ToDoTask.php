<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDoTask extends Model
{
    protected $table = 'to_do';
    protected $fillable =[
        'to_do_task', 'to_do_user_id'
    ];
}
