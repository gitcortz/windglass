<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timesheet;
use App\Employee;
use App\Dto\EmployeeTimeSheetDto;
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
                
            $employeeTimesheet = new EmployeeTimeSheetDto($employee, $timesheets);            
            array_push($timesheetCollection, $employeeTimesheet);            
        }
        return json_encode($timesheetCollection);


        

    }
}
