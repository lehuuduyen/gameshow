<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function questions() {
        return $this->belongsToMany(Question::class)
                ->withPivot('order');
    }
}
