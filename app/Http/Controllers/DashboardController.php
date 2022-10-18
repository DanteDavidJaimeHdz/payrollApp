<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Movement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @class DashboardController
 * @author Dante Jaime
 * @description Controller to mannage Dashboard with month report
 */
class DashboardController extends Controller
{
    /**
     * @method getData
     * @author Dante Jaime
     * @description Method to get month data metrics 
     */
    public function getData(Request $request){
        $month =  $request->get('month', null);

        $data = Movement::select(
                            DB::raw('round(sum(extra_deliveries),2) as totalPayFromDeliveries'), 
                            DB::raw('round(sum(extra_bonus),2) as totalPayFromBonus'), 
                            DB::raw('round(sum(total_isr),2) as retentions'), 
                            DB::raw('round(sum(food_bonus),2) as foodBonus'),
                            DB::raw('round(sum(total_payroll),2) as totalSalary')
                            )
                ->where('month', $month)
                ->get();
        $totalRegisters = Movement::select('id')->where('month', $month)->count();
        $workedHours = $totalRegisters * (8*6*4);
        
        if (count($data) > 0) {
            $data[0]->workedHours = $workedHours;
        } 
        return $data[0];
    }

    /**
     * @method getEmployeeData
     * @author Dante Jaime
     * @description Method to get deliveries per employee for chart
     */
    public function getEmployeeData(Request $request) {
        $month =  $request->get('month', null);

        $data = Movement::select(DB::raw("CONCAT(employees.name, ' ', employees.lastname) as name"),'movements.deliveries')
                ->join('employees', 'employees.id', '=','movements.employee_id')->where('movements.month', $month)->get();
        return $data;
    }
}
