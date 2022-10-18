<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Employee;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * @method saveConfig
     * @author Dante Jaime
     * @description Method for save default config
     * @note It's an initial configuration, user may not be able
     * to create a new one, just edit.
     */
    public function saveConfig(Request $request){
        try {
            $semanal_days = $request->get("semanal_days");
            $day_hours = $request->get("day_hours");
            $min_salary = $request->get("min_salary");
            $default_hour_salary = $request->get("default_hour_salary");
            $default_isr = $request->get("default_isr");
            $extra_isr = $request->get("extra_isr");

            $data = [
                'semanal_days' => $semanal_days,
                'day_hours' => $day_hours,
                'min_salary' => $min_salary,
                'default_hour_salary' => $default_hour_salary,
                'default_isr' => $default_isr,
                'extra_isr' => $extra_isr
            ];

            $validate = self::validations($data);

            if ($validate['status'] == 500) {
                throw new Exception($validate['message']);
            }
            Config::first()->update($data);
    
            $response['message'] = "Configuración guardada correctamente.";
            $response['success'] = true;
            return $response;
        }
        catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = false;
            $response['exception'] = $e->getMessage();
            return $response;
        }
    }
    /**
     * @method validations
     * @author Dante Jaime
     * @param $data
     * @description method to validate configuration inputs
     */
    private function validations($data) {
        foreach($data as $key => $value) {
            if ($value == "" || $value == null) {
                return ["data" => $key, "message" => 'Empty Data ' + $key, "status" => 500];
            }
        }

        if ($data['semanal_days'] > 7) {
            return ["data" => 'semanal_days', "message" => 'Días Inválidos', "status" => 500];
        }
        if ($data['day_hours'] > 24) {
            return ["data" => 'semanal_days', "message" => 'Horas Inválidas', "status" => 500];
        }

        return ["data" => "" ,"message" => "Datos Correctos", "status" => 200];
    }
    /**
     * @method totalPayroll
     * @author Dante Jaime
     * @description Method to operate with default config to get totalPayroll
     * @param $subtotal float
     * @return Object
     */

    public function getConfig() {
        $config =  Config::first();
        return $config;
     }
     

    /**
     * @method subtotalPayroll
     * @author Dante Jaime
     * @description method to get subtotal based on Config and rol
     * @param
     * @return Array
     */
    public static function subtotalPayroll($data) {
        $subtotal = 0;
        $bonusDelivery = 0;
        $bonusRol = 0;
        $extraFood = 0;
        $base = 0;
        $extraDeliveries = 0;

        $config = Config::first();

        $employee = Employee::where('id',$data['employee_id'])->first();
        $role = Role::find($employee->role_id);
        
        $bonusRol = round((($config->day_hours * $role->bonus) * $config->semanal_days * 4),2);
        
        $bonusDelivery = round(floatval($data['deliveries']) * floatval($config->extra_delivery), 2);
        
        $base = round((($config->day_hours * $config->default_hour_salary) * $config->semanal_days * 4),2);

        $extraFood = round(floatval($base) * 0.04,2);

        $subtotal = $base + $extraFood + $bonusDelivery + $bonusRol;

        return ['subtotal' => $subtotal, 'extraFood' => $extraFood, 'bonusRol' => $bonusRol, 'bonusDelivery' => $bonusDelivery, 'extraDeliveries' =>$extraDeliveries ,'base' => $base];
    }
    /**
     * @method totalPayroll
     * @author Dante Jaime
     * @description Method to operate with default config to get totalPayroll
     * @param $subtotal float
     * @return Array
     */

     public static function totalPayroll($subtotal) {

        $config =  Config::first();
        $isr = $config->default_isr;
        if ($subtotal > $config->min_salary) {
            $isr += $config->extra_isr;
        }
        $totalISR = (round($subtotal * ($isr/100),2));
        $total = $subtotal - $totalISR;
        return ['total' => $total, 'totalISR' => $totalISR];
    }
}
