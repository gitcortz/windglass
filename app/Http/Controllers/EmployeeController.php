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


    public function update_employeeInfo(Request $request, Employee $employee)
    {
        $data = $request->json()->all();
        $employee_id = $data['employeeInformation']['employee_id'];
        if ($employee_id) {
            $employee = \App\Employee::find($employee_id);
            $employee->first_name = $data['employeeInformation']['first_name'];
            $employee->last_name = $data['employeeInformation']['last_name'];
            $employee->address = $data['employeeInformation']['address'];
            $employee->city = $data['employeeInformation']['city'];
            $employee->phone = $data['employeeInformation']['phoneNumber'];
            $employee->mobile = $data['employeeInformation']['mobileNumber'];
            $employee->hire_date = $data['employeeInformation']['hire_date'];
            $employee->notes = $data['employeeInformation']['notes'];
            $employee->salary = $data['employeeInformation']['salary'];
            $employee->position = $data['employeeInformation']['position'];
            $employee->save();

            $sssAmount = $data['employeeLoans']['sss'];
            $salaryAmount = $data['employeeLoans']['salaryLoan'];
            $valeAmount = $data['employeeLoans']['vale'];

            $sssLoan = EmployeeLoan::where('employee_id', $employee_id)
                                    ->where('loan_type_id', 1)
                                    ->where('status', 0)->first();
            if ($sssLoan) {
                $sssLoan->loan_amount =$sssAmount;
                $sssLoan->save();
            } else {
                $employee_loan = EmployeeLoan::create([
                    'employee_id' => $employee_id,
                    'loan_amount' => $sssAmount,
                    'loan_balance' => $sssAmount,
                    'loan_type_id' => 1,
                    'status' => 0,
                ]);
            }

            $salaryLoan = EmployeeLoan::where('employee_id', $employee_id)
                                            ->where('loan_type_id', 2)
                                            ->where('status', 0)->first();
            if ($salaryLoan) {
                $salaryLoan->loan_amount = $salaryAmount;
                $salaryLoan->save();
            } else {
                $employee_loan = EmployeeLoan::create([
                    'employee_id' => $employee_id,
                    'loan_amount' => $salaryAmount,
                    'loan_balance' => $salaryAmount,
                    'loan_type_id' => 2,
                    'status' => 0,
                ]);
            }
            
            $valeLoan = EmployeeLoan::where('employee_id', $employee_id)
                                            ->where('loan_type_id', 3)
                                            ->where('status', 0)->first();
            if ($valeLoan) {
                $valeLoan->loan_amount = $valeAmount;
                $valeLoan->save();
            } else {
                $employee_loan = EmployeeLoan::create([
                    'employee_id' => $employee_id,
                    'loan_amount' => $valeAmount,
                    'loan_balance' => $valeAmount,
                    'loan_type_id' => 3,
                    'status' => 0,
                ]);
            }
            
           // print_r($loan);
        }

       
    }
}
