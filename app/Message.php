<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function user()
    {
        return $this->belongTo(User::class);
    }

    public function chat()
    {
        return $this->belongTo(Chat::class);
    }
}
