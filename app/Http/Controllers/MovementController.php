<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

class MovementController extends Controller
{
    /**
     * @method createMovement
     * @author Dante Jaime
     * @description method to create or Updates new movement
     */
    public function createOrUpdateMovement(Request $request){
        try {
            $id = $request->get('id');
            $employeeId = $request->get("employeeId", null);
            $month = $request->get("month", null);
            $deliveries = $request->get("deliveries", null);
            
            $data = [
                'employee_id' => $employeeId,
                'month' => $month,
                'deliveries' => $deliveries ?? 0
            ];
            //['subtotal' => $subtotal, 'extraFood' => $extraFood, 'bonusRol' => $bonusRol, 'bonusDelivery' => $bonusDelivery]
            $subtotal = ConfigController::subtotalPayroll($data);
            //['total' => $total, 'totalISR' => $totalISR]
            $total = ConfigController::totalPayroll($subtotal['subtotal']);
            $extraBonus = $subtotal['bonusRol'];
            $foodBonus =  $subtotal['extraFood'];
            $sub = $subtotal['subtotal'];
            $totalISR = $total['totalISR'];
            $totalPayroll = $total['total'];
            $base = $subtotal['base'];
            $extra_deliveries = $subtotal['bonusDelivery'];
            /*$arrayData = [
                'employee_id' => $employeeId,
                'month' => $month,
                'deliveries' => $deliveries ?? 0,
                'extra_bonus' => $subtotal['bonusRol'],
                'food_bonus' => $subtotal['extraFood'],
                'subtotal' => $subtotal['subtotal'],
                'total_isr' => $total['totalISR'],
                'total_payroll' => $total['total'],
                'base' =>  $subtotal['base'],
                'extra_deliveries' => $subtotal['bonusDelivery']
            ];*/
            if($id !== 'null') {
              DB::beginTransaction();
              DB::select("CALL editMovement(?,?,?,?,?,?,?,?,?,?,?)", [$id, $employeeId, $month,$deliveries, $extraBonus, $foodBonus, $sub, $base, $extra_deliveries, $totalISR, $totalPayroll], true);
              DB::commit();
            }
            else {
              $validateMonth = Movement::where('month', $month)->where('employee_id', $employeeId)->first();
              if($validateMonth) {
                throw new Exception("Mes registrado previamente para el empleado");
              }
              DB::beginTransaction();
              DB::select("CALL createMovement($employeeId, '$month',$deliveries, $extraBonus, $foodBonus, $sub, $base, $extra_deliveries, $totalISR, $totalPayroll);");
              DB::commit();
            }
            
            //Movement::insert($arrayData);
            
            $response['message'] = "Success!";
            $response['success'] = true;
            return $response;
        }
        catch (Exception $e) {
            //returns an array with message error
            $response['message'] = "Error!";
            $response['success'] = false;
            $response['exception'] = $e->getMessage();
            return $response;
        }
    }


    /**
     * @method getList
     * @author Dante Jaime
     * @description Method to get List of movements
     */
    public function getList(){
      $data = Movement::select('movements.id', 'employees.name', 'employees.lastname','month', 'deliveries')
              ->join('employees', 'employees.id', '=', 'movements.employee_id')
              ->get();
      return $data;
    }

    /**
     * @method searchData
     * @author Dante Jaime
     * @description Method that search info to get selected data to edit
     */
    public function searchData(Request $request){
      $id =  $request->get('id', null);
      $data = Movement::select('movements.id', 'employees.name', 'employees.lastname','month', 'deliveries', 'employee_id as employeeId')
              ->join('employees', 'employees.id', '=', 'movements.employee_id')
              ->where('movements.id', $id)
              ->first();
      return $data;
    }
    /**
     * @method getReport
     * @author Dante Jaime
     * @description Method to get full report of movements with employee, hours, etc.
     */
    public function getReport(){
    $data = Movement::select('movements.id', 'employees.name as employee_name', 'employees.lastname as employee_last_name','roles.name as role_name','month', 'deliveries','base as base_salary', 'extra_deliveries', 'extra_bonus', 'food_bonus', 'subtotal', 'total_payroll')
              ->join('employees', 'employees.id', '=', 'movements.employee_id')
              ->join('roles', 'roles.id', '=', 'employees.role_id')
              ->get();
      return $data;
    }
}
