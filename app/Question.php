<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'content',
        'description'
    ];

    public function sessions() {
        return $this->belongsToMany(Session::class)
                ->withPivot('order')
                ->orderBy('order', 'ASC');
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }
}
