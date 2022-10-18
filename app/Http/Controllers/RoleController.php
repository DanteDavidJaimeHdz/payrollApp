<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @class RoleController
 * @author Dante Jaime
 * @description Controller to mannage Employees
 */
class RoleController extends Controller
{
    /**
     * @method getList
     * @author Dante Jaime
     * @description Method to get List of roles
     */
    public function getList(){
        $data = Role::select('id', 'name', 'bonus')
                ->get();
        return $data;
    }
    /**
     * @method createEmployee
     * @author Dante Jaime 
     * @description method to create a Role
     */
    public function createRole (Request $request){
        try {
            $id = $request->get("id");
            $name = $request->get("name");
            $bonus = $request->get("bonus");
            if ($id != 'null') {
                DB::select("CALL editRole($id, '$name', $bonus)");
            }
            else {
                DB::select("CALL createRole('$name', '$bonus')");
            }
            /*Role::insert([
            'name' => $name,
            'bonus' => $bonus
            ]);*/
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
     * @method searchData
     * @author Dante Jaime
     * @description method for search data to edit register
     */
    public function searchData(Request $request){
        try {
            $id = $request->get("id", null);
            $data = Role::select('id', 'name', 'bonus')
                    ->where('id', $id)->get();
            return $data;
        }
        catch(Exception $e) {
            return $e->getCode();
        }
        
    }

    public function getRoleForSelect(Request $request) {
        $qry = $request->get('qry', "");
        $data = Role::select('id', 'name');

        if ($qry != '') {
            $data->where('name', 'like', "%$qry%");
        }
        $data = $data->get();
        return $data;
    }
}
