<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobsArea extends Model
{
    protected $table = 'jobs_area';
    protected $primaryKey = 'id_employees';
    protected $fillable = [
        'name_job'
    ];
}
