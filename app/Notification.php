<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['user_id', 'type', 'slug', 'message', 'read'];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
