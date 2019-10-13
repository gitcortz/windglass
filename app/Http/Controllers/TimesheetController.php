<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Timesheet;
use App\Http\Traits\Paginatable;
use App\Http\Resources\TimesheetResource;
use App\Http\Resources\TimesheetCollection;
use App\Http\Requests\TimesheetStoreRequest;


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
}
