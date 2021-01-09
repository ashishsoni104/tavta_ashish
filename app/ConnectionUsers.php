<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConnectionUsers extends Model
{
    //
    protected $table = 'connection_users';
    protected $fillable = [
        'sender_user_id','request_user_id','status'
    ];
    
}
