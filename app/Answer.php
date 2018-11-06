<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public static $QUESTION = 1;
    public static $ANSWER = 2;
    public static $RESOLVER = 3;
    public static $MASK = 4;
    public static $INTRO = 5;

    protected $fillable = [
      'tag',
      'path',
      'url'
    ];

    public function question() {
        return $this->belongsTo(Question::class);
    }
}
