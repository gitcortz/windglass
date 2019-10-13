<?php

namespace App\Library\Services\Payroll;
use Carbon\Carbon;
use App\Timesheet;
use App\Payroll;
use App\PayrollTimesheet;
use Illuminate\Support\Facades\DB;

class PayrollService implements PayrollServiceInterface
{
    const OFFICIAL_TIME_IN = '08:00:00';
    const OFFICIAL_WORK_HOUR_PER_DAY = 9;

    public function generatePayroll(Date $date = null)
    {       
      \DB::listen(function($query) {
        var_dump($query->sql);
      });

      if (!isset($date)) {
        $date = Carbon::now(); 
      }

      $week = $date->format("W");
      $year = $date->format("Y");
      $date_range = $this->getStartAndEndDate($week, $year);
      $this->createPayrollTimeSheetsDB($date_range['start'], $date_range['end'], 
                              self::OFFICIAL_TIME_IN);
    /*  $timesheets_result = $this->getTimeSheetsDB($date_range['start'], $date_range['end'], 
                              self::OFFICIAL_TIME_IN);

            $payrolls = [];
            foreach ($timesheets_result as $timesheet) {
                $payroll = new Payroll();
                $payroll->group = $year.'-'.$week;                
                $payroll->employee_id = $timesheet->employee_id;
                $payroll->start_date = $date_range['start'];
                $payroll->end_date = $date_range['end'];
                $payroll->work_days = $date_range['end'];
                $payroll->rate = $date_range['end'];
                $payroll->late_hours = $date_range['end'];
                $payroll->overtime_hours = $date_range['end'];
                $payrolls[] = $payroll->attributesToArray();
            }
            var_dump($payrolls);
            //Payroll::insert($payrolls);
*/
    

      return 'Output from Generate Payroll - '.$date->toDateTimeString().' - week #'.$week;
    }

    private function getStartAndEndDate($week, $year) {
      $dates['start'] = date("Y-m-d", strtotime($year.'W'.str_pad($week, 2, 0, STR_PAD_LEFT)));
      $dates['end'] = date("Y-m-d", strtotime($year.'W'.str_pad($week, 2, 0, STR_PAD_LEFT).' +6 days'));
      return $dates;
    }

    private function createPayrollTimeSheetsDB($start, $end, $offical_time_in) {
      $timesheets_result = \DB::table('timesheets')
            ->select('employee_id', 'time_in', 'time_out', 
              DB::raw('TIMEDIFF(CONCAT_WS(\' \', DATE(time_in),\''.$offical_time_in.'\'), time_in) AS late_hours'),
              DB::raw('TIMEDIFF(time_out, time_in) as total_hours'))
              ->whereDate('time_in', '>=', $start)
              ->whereDate('time_in', '<=', $end)
              ->where('employee_id', 1)
            ->get();

      $payroll_timesheets = [];
      foreach ($timesheets_result as $timesheet) {
        $payroll_timesheet = new PayrollTimesheet();
        $payroll_timesheet->timesheet_date = date("Y-m-d",strtotime($timesheet->time_in));
        $payroll_timesheet->employee_id = $timesheet->employee_id;
        $total_work_hours =  $timesheet->late_hours > 0 
                              ? $timesheet->total_hours - $timesheet->late_hours 
                              : $timesheet->total_hours;

        $payroll_timesheet->work_hours = self::OFFICIAL_WORK_HOUR_PER_DAY -1;
        $payroll_timesheet->overtime_hours = 
                                $total_work_hours < self::OFFICIAL_WORK_HOUR_PER_DAY 
                                ? 0  
                                : (int)$total_work_hours - self::OFFICIAL_WORK_HOUR_PER_DAY;
        $payroll_timesheet->late_hours = 
                                $timesheet->late_hours < 0 
                                ? abs($timesheet->late_hours) 
                                : 0;
        $payroll_timesheets[] = $payroll_timesheet->attributesToArray();
      }

      var_dump($payroll_timesheets);

      PayrollTimesheet::insert($payroll_timesheets);
      
    }







    

              //var_dump($timesheets_result);
      /*
      foreach(array_chunk($timesheets_result, 100) as $timesheets){
          foreach($timesheets as $timesheet){
              echo $timesheet;
          }
      }

        $data = array(
            array(
                'name'=>'Coder 1', 'rep'=>'4096',
                'created_at'=> $now,
                'modified_at'=> $now
              ),
            array(
                'name'=>'Coder 2', 'rep'=>'2048',
                'created_at'=> $now,
                'modified_at'=> $now
              ),
            //...
        );

      */
      // /Timesheet::insert($data);


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
}