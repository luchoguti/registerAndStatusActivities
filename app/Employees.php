<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id_employees';
    protected $fillable = [
        'first_name','second_name','type_identification','number_identification','id_job_area'
    ];
    public function jobsArea(){
        return $this->hasMany ('App\JobsArea','id_job_area','id_job_area');
    }
}
