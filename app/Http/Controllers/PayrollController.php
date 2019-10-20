<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timesheet;
use App\Employee;
use App\EmployeeLoan;
use App\Dto\EmployeeTimeSheetDto;
use App\Dto\EmployeeTimesheetOtherFeesDto;
use App\Http\Traits\Paginatable;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PayrollTimesheetResource;

class PayrollController extends Controller
{
    use Paginatable;
 
    public function getTimesheetInformation(Request $request)
    {
        $employees = Employee::paginate($this->getPerPage());
        $timesheetCollection = array();
        foreach ($employees as $employee) {                    
            $timesheets = Timesheet::
                select('time_in as startTime','time_out as endTime')
                ->where('employee_id', '<=', $employee->id)
                ->where('time_in', '>=', $request->from)
                ->where('time_in', '<=', $request->to)
                ->get();
            
            $loan = $this->getLoan($employee);            
            $employeeTimesheet = new EmployeeTimeSheetDto($employee, $timesheets, $loan);            
            array_push($timesheetCollection, $employeeTimesheet);            
        }
        return json_encode($timesheetCollection);

    }

    private function getLoan(Employee $employee) {
        $vale = 0;
        $sss = 0;
        $salary = 0;

        $loans = EmployeeLoan::where('employee_id', '=', $employee->id)->get();
        foreach ($loans as $loan) {
            if ($loan->loanType->name == 'sss') {
                $sss = round($loan->loan_amount/$loan->loanType->month_term/4, 2);
            }
            if ($loan->loanType->name == 'salary') {
                $salary = $loan->loanType->fixed_amount;
            }
            if ($loan->loanType->name == 'vale') {
                $vale = $loan->loan_amount;
            }
        }

        $loanObj = new EmployeeTimesheetOtherFeesDto($sss, $salary, $vale);
        return $loanObj;
    }
}
