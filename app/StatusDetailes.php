<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusDetailes extends Model
{

    //
    protected $table = 'status_details';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $guarded =array();



}
