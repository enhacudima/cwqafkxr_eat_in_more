<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingV extends Model
{
    protected $table = 'booking_v';

    protected $guarded =array();

    public $primaryKey = 'id';

    public $timestamps=false;

        public function meals()
    {
        return $this->hasMany('App\BookingSyncMeal', 'key','booking_id');
    }

        public function repliesComment()
    {
        return $this->hasMany('App\Comments', 'parent_key','key');
    }

}
