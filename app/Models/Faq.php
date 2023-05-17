<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = ['topic_id','question','answer','status'];

    public function topic()
    {
        return $this->hasOne(FaqTopic::class,'id','topic_id');
    }
}
