<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @class EmployeeController
 * @author Dante Jaime
 * @description Controller to mannage Employees
 */
class EmployeeController extends Controller
{
    /**
     * @method getList
     * @author Dante Jaime
     * @description Method to get List of employees
     */
    public function getList(){
        $data = Employee::select('employees.id', 'employees.name as employee_name', 'employees.lastname','roles.name as role_name')
                ->leftJoin('roles', 'roles.id', '=', 'employees.role_id')
                ->get();
        return $data;
    }
    /**
     * @method createEmployee
     * @author Dante Jaime 
     * @description method to create an Employee
     */
    public function createEmployee (Request $request){
        try {
            $name = $request->get("name");
            $lastname = $request->get("lastname");
            $role_id = $request->get("rol_id");
            Employee::insert([
            'name' => $name,
            'lastname' => $lastname,
            'role_id' => $role_id
            ]);
            //returns an array with message success and status
            $response['message'] = "Success!";
            $response['success'] = true;
            $response['status'] = 200;
            return $response;
        }
        catch (Exception $e) {
            //returns an array with message error
            $response['message'] = "Error!";
            $response['success'] = false;
            $response['exception'] = $e->getMessage();
            $response['status'] = 500;
            return $response;
        }
    }

    /**
     * @method getEmployeeForSelect
     * @author Dante Jaime
     * @description method to consult employees just for select component
     * @return Array
     */


    public function getEmployeeForSelect(Request $request) {
        try {
            // get select filter
            $qry = $request->get("qry");

            $data =  Employee::select('id', DB::raw("ifnull(name, '') as name") , DB::raw("ifnull(lastname,'') as lastname"));

            if ($qry != "") {
                $data->where('name', 'like', "'%$qry%'")->orWhere('lastname', 'like', "'%$qry%'");
            }

            $data = $data->limit(10)->get();
            //returns object with data
            return $data;
        }
        catch (Exception $e) {
            //returns an array with message error
            $response['message'] = "Error!";
            $response['success'] = false;
            $response['exception'] = $e->getMessage();
            $response['status'] = 500;
            return $response;
        }
        
    }

}
