<?php

namespace App\Library\Services\Payroll;
use Carbon\Carbon;
use App\Timesheet;
use Illuminate\Support\Facades\DB;

class PayrollService implements PayrollServiceInterface
{
    public function generatePayroll(Date $date = null)
    { 
      if (!isset($date)) {
        $date = Carbon::now(); 
      }
      $week = $date->format("W");
      $year = $date->format("Y");
      $offical_time_in = '08:00:00';

      $date_range = $this->getStartAndEndDate($week, $year);
      \DB::listen(function($query) {
        var_dump($query->sql);
      });

      $timesheets = Timesheet::
                    where('time_in', '>=', $date_range[0])
                    ->where('time_in', '<=', $date_range[1])
                    ->get();
      
      $ts = \DB::table('timesheets')
              ->select('employee_id', 'time_in', 'time_out', 
                DB::raw('TIMEDIFF(CONCAT_WS(\' \', DATE(time_in),\''.$offical_time_in.'\'), time_in) AS late_hours'),
                DB::raw('TIMEDIFF(time_out, time_in) as total_hours'))
                ->whereDate('time_in', '>=', $date_range[0])
                ->whereDate('time_in', '<=', $date_range[1])
              ->get();
    /*
      $timesheets = $data= MyData::whereRaw('DATEDIFF(updated_at,created_at) < ?')
            ->setBindings([$days])
            ->get();

            orders = DB::table('orders')
                ->select('department', DB::raw('SUM(price) as total_sales'))
                ->groupBy('department')
                ->havingRaw('SUM(price) > ?', [2500])
                ->get();

            $users = DB::table('users')
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get();

    */

      return 'Output from Generate Payroll - '.$date->toDateTimeString().' - week #'.$week;
    }

    private function getStartAndEndDate($week, $year) {
      $dates[0] = date("Y-m-d", strtotime($year.'W'.str_pad($week, 2, 0, STR_PAD_LEFT)));
      $dates[1] = date("Y-m-d", strtotime($year.'W'.str_pad($week, 2, 0, STR_PAD_LEFT).' +6 days'));
      return $dates;
    }
}