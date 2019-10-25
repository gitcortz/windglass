<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeLoan;
use App\Timesheet;
use App\Http\Traits\Paginatable;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeCollection;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Resources\TimesheetCollection;
use App\Library\Services\Payroll\PayrollServiceInterface;

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

    public function payroll(Request $request, PayrollServiceInterface $payrollServiceInstance)
    {
        echo $payrollServiceInstance->generatePayroll();
    }

    public function timesheet(Request $request)
    {
        $timesheets = Timesheet::
                    where('employee_id', $request->employee_id)
                    ->where('time_in', '>=', $request->from)
                    ->where('time_in', '<=', $request->to)
                    ->paginate($this->getPerPage());
        
        return  new TimesheetCollection($timesheets);
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


    public function add_loan($employee_id, Request $request)
    {
        $previous_loans_count = EmployeeLoan::
                    where('employee_id', $employee_id)
                    ->where('loan_type_id', $request->input('loan_type_id'))
                    ->where('status', 0)
                    ->count();

        if ($previous_loans_count == 0)
        {
            $employee_loan = EmployeeLoan::create([
                'employee_id' => $employee_id,
                'loan_amount' => $request->input('loan_amount'),
                'loan_balance' => $request->input('loan_amount'),
                'loan_type_id' => $request->input('loan_type_id'),
                'status' => 0,
            ]);

            return response()->json($employee_loan, 201);
        }
        else {
            $json = [
                'status' => 'Add Loan Failed',
                'message' => 'invalid load, existing loan type for employee'
            ];
            return response()->json($json, 400);
        }

    }
}
