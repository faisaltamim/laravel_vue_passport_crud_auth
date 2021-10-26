<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LoggedInUser extends Model {

    use Notifiable;

    protected $fillable = [
        'user_id', 'user_token',
    ];
}
