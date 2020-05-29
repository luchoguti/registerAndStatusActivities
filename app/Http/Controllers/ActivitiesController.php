<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivitiesResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Employees;
use App\Activities;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return ActivitiesResource::collection (Activities::with ('ForeignKeyEmployees')
            ->get ())
            ->map(function ($item){
            $now=Carbon::now ();
            $dateExecuteAct=Carbon::parse($item['date_execute']);
            $daysDifferent=$dateExecuteAct->diffInDays($now);
            if($now > $dateExecuteAct){
                $item['days_delay']= $daysDifferent;
            }else{
                $item['days_delay']= 0;
            }
            return $item;
            });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Activities::create([
            'name'=>$request->activity_info_basic['name'],
            'status'=>$request->activity_info_basic['status'],
            'date_execute'=>Carbon::parse ($request->activity_info_basic['date_execute'])->format('Y-m-d H:i'),
            'id_employees'=>$request->activity_info_basic['employees']
        ]);
        $dataResponse['status'] = 201;
        $dataResponse['message'] = "Activity create success.";
        return response()->json($dataResponse, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return Activities::where('id_activities','=',$id)->select(DB::raw ('*,CONVERT(status, SIGNED) as status_id'))->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        Activities::where('id_activities','=',$id)->update([
            'name'=>$request->activity_info_basic['name'],
            'status'=>$request->activity_info_basic['status'],
            'date_execute'=>Carbon::parse ($request->activity_info_basic['date_execute'])->format('Y-m-d H:i'),
            'id_employees'=>$request->activity_info_basic['employees']
        ]);
        $dataResponse['status'] = 201;
        $dataResponse['message'] = "Activity update success.";
        return response()->json($dataResponse, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function getOptionStatusActivities(){
        return (new \App\Activities)->getOptionStatusActivities();
    }
}
