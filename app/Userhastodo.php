<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userhastodo extends Model
{
    protected $fillable = [
        'todo_id','user_id','comments'
    ];
    public function todos()
    {
        return $this->belongsTo('App\Todo');
    }
    public function usrs()
    {
        return $this->belongsTo('App\User');
    }
}
