<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Http\Traits\Paginatable;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeCollection;
use App\Http\Requests\EmployeeStoreRequest;


class EmployeeController extends Controller
{
    use Paginatable;
    public function index()
    {
        return new EmployeeCollection(Employee::paginate($this->getPerPage()));        
    }
 
    public function show(Employee $employee)
    {
        return ((new EmployeeResource($employee)));
    }
    public function store(EmployeeStoreRequest $request)
    {
        $validated = $request->validated();
        $employee = Employee::create($request->all());
        return response()->json($employee, 201);
    }
    public function update(EmployeeStoreRequest $request, Employee $employee)
    {
        $validated = $request->validated();
        $employee->update($request->all());
        return response()->json($employee, 200);
    }
    public function delete(Employee $employee)
    {
        $employee->delete();
        return response()->json(null, 204);
    }
}
