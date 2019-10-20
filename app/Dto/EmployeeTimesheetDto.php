<?php

namespace App\Dto;
use App\Employee;
use Illuminate\Database\Eloquent\Collection;

class EmployeeTimesheetDto implements \JsonSerializable
{
    private $name;
    private $employeeRate = 0;
    private $timesheet;
    private $fees;

    public function __construct( Employee $employee, Collection $timesheetCollection, EmployeeTimesheetOtherFeesDto $loans)
    {
        $this->name = $employee->first_name.' '.$employee->last_name;
        $this->employeeRate = $employee->salary;
        $this->timesheet = $timesheetCollection;
        $this->fees =$loans;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmployeeRate()
    {
        return $this->employeeRate;
    }

    public function getTimesheet()
    {
        return $this->timesheet;
    }

    public function jsonSerialize()
    {
        return [
            'userInformation' => [
                'name' => $this->name,
                'employeeRate' => (float) $this->employeeRate
            ],
            'timeLog' => $this->timesheet,
            'otherFees' => $this->fees,
        ];
    }
}

