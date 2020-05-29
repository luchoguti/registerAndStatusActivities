<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Activities extends Model
{
    public $table = 'activities';
    protected $primaryKey = 'id_activities';

    protected $fillable = [
        'name','status','date_execute','id_employees'
    ];
    protected $hidden = [];

    public function ForeignKeyEmployees(){
        return $this->hasMany ('App\Employees','id_employees','id_employees')->with ('jobsArea');
    }
    public function getOptionStatusActivities(){
        $type = DB::select (DB::raw('SHOW COLUMNS FROM activities WHERE Field = "status"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        $i = 1;
        foreach(explode(',', $matches[1]) as $value){
            $v = trim( $value, "'" );
            $enum[$i] = $v;
            $i++;
        }
        return json_encode ($enum);
    }
}
