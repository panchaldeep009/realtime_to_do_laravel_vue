<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDoUsers extends Model
{
    protected $table = 'to_do_users';
    protected $fillable = [
        'to_do_user_name', 'to_do_user_csrf'
    ];
}
