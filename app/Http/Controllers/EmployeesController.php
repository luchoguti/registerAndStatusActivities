<?php

namespace App\Http\Controllers;

use App\Employees;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function getEmployees(){
        return Employees::all ();
    }
}
