<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experiences extends Model
{
    
    //
    protected $table = 'experiences';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $fillable = [
        'title', 'experience_from', 'experience_to','time_id','charger_from','charger_to','currency_id','ref','user_id','key','status','description'
    ];


        public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
