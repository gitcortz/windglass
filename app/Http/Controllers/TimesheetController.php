<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Timesheet;
use App\Http\Traits\Paginatable;
use App\Http\Resources\TimesheetResource;
use App\Http\Resources\TimesheetCollection;
use App\Http\Requests\TimesheetStoreRequest;
use Illuminate\Support\Arr;
use App\Library\Services\Payroll\PayrollServiceInterface;

class TimesheetController extends Controller
{
    use Paginatable;
    public function index()
    {
        return new TimesheetCollection(Timesheet::paginate($this->getPerPage()));        
    }
 
    public function show(Timesheet $timesheet)
    {
        return ((new TimesheetResource($timesheet)));
    }

    public function store(TimesheetStoreRequest $request)
    {
        $validated = $request->validated();
        $timesheet = Timesheet::create($request->all());
        return response()->json($timesheet, 201);
    }

    public function update(TimesheetStoreRequest $request, Timesheet $timesheet)
    {
        $validated = $request->validated();
        $timesheet->update($request->all());
        return response()->json($timesheet, 200);
    }
    public function delete(Timesheet $timesheet)
    {
        $timesheet->delete();
        return response()->json(null, 204);
    }

    public function upload(Request $request)
    {
        $path = $request->file('csv_file')->move(public_path());
        $data = array_map('str_getcsv', file($path));

        \App\FileUpload::create([
            'filename' => $request->file('csv_file')->getClientOriginalName(), 
            'header' => $request->has('header'),
            'data' => json_encode($data)
        ]);

        $csv_data = array_slice($data, 0, 2);
        ($csv_data);
    }

    public function uploadprocess(Request $request, PayrollServiceInterface $payrollServiceInstance)
    {
        $path = $request->file('csv_file')->move(public_path());
        $data = array_map('str_getcsv', file($path));

        /*\App\FileUpload::create([
            'filename' => $request->file('csv_file')->getClientOriginalName(), 
            'header' => $request->has('header'),
            'data' => json_encode($data)
        ]);*/

        $json = '[["Ac-2No","Name","sTime","Verify Mode","Machine","Exception"],["4","44444","15\/11\/2019 8:20 PM","FP\/PW\/RF\/FACE","4",""],["4","44444","15\/11\/2019 8:20 PM","FP\/PW\/RF\/FACE","4",""],["5","5555","15\/11\/2019 8:20 PM","FP\/PW\/RF\/FACE","4",""],["5","5555","15\/11\/2019 8:20 PM","FP\/PW\/RF\/FACE","4",""]]';
        $data = json_decode($json, true);
        $payrollServiceInstance->processCsvData($data);
        
    }

    
}
