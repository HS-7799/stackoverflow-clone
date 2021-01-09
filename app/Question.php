<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function($question){
            $question->slug = Str::slug($question->title);
        });

    }

    protected $fillable = ['title','slug','body','user_id','category_id'];
    // protected $with = ['replies'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)->latest();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getPathAttribute()
    {
        return "/questions/$this->slug";
    }
}
