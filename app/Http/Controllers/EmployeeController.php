<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Http\Traits\Paginatable;
use Validator;

class EmployeeController extends Controller
{
    use Paginatable;

    public function index()
    {
        return Employee::paginate($this->getPerPage());
    }
 
    public function show(Employee $employee)
    {
        return $employee;
    }

    public function store(Request $request)
    {
        $rules = array (
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required|max:255',
            'city' => 'required|max:50',
            'salary' => 'required|numeric',
            'hire_date' => 'required|date',
        );

        $data = json_decode($request->getContent(), true);

        $validator = Validator::make($request->all(), $rules);
        if ($validator-> fails()){
            return response()->json($validator->errors(), 400);
        }
        else{
            $employee = Employee::create($request->all());
            return response()->json($employee, 201);
        }
    }

    public function update(Request $request, Employee $employee)
    {
        $employee->update($request->all());

        return response()->json($employee, 200);
    }

    public function delete(Employee $employee)
    {
        $employee->delete();

        return response()->json(null, 204);
    }
}
