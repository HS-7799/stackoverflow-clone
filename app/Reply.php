<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['question_id','user_id','body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }


    public function like()
    {
        return $this->likes()->attach();
    }
}
