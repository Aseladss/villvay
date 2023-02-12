<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'name', 'description', 'status'
    ];
    
    public function userhastodos()
    {
        return $this->hasMany('App\Userhastodo');
    }
}
