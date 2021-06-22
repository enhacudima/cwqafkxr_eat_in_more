<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CvChefeV extends Model
{

    protected $table = 'cv_chefe_v';
    protected $connection = 'mysqlView';//via connectio 2


    public $primaryKey = 'id';

    public $timestamps=true;

    protected $guarded =array();

}
