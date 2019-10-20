<?php

namespace App\Dto;
use App\Employee;
use Illuminate\Database\Eloquent\Collection;

class EmployeeTimesheetOtherFeesDto implements \JsonSerializable
{
    private $vale = 0;
    private $salaryLoan = 0;
    private $sss = 0;

    public function __construct(float $sss, float $salaryLoan, float $vale)
    {
        $this->vale = $vale;
        $this->salaryLoan = $salaryLoan;
        $this->sss = $sss;
    }

    public function getVale()
    {
        return $this->vale;
    }

    public function getSalaryLoan()
    {
        return $this->salaryLoan;
    }

    public function getSss()
    {
        return $this->sss;
    }

    public function jsonSerialize()
    {
        return [        
            'vale' => $this->vale,
            'salaryLoan' => $this->salaryLoan,
            'sss' => $this->sss                    
        ];
    }
}

