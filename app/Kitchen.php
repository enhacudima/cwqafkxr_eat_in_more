<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{

    //
    protected $table = 'kitchen_details';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $fillable = [
        'aliase','full_address','type_stove_power_source', 'stove_backup', 'grill_available','oven_available','lat','lng','user_id','key','status',
    ];


        public function userKitchen()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
