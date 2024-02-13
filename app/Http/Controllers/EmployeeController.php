<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Gender;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\New_;

class EmployeeController extends Controller
{
    public function index() {
        $EmployeeList = Employee::orderBy("id","DESC")->paginate(5);
        $GenderList = Gender::all();
        $CompanyList = Company::all();
        $PositionList = Position::all();
        $superVisor = [];
        foreach ($EmployeeList as $employee) {
            $supervisor = Employee::where('id', $employee->super_visor_id)->first();

            $SuperVisor[$employee->id] = $supervisor;
        }
        
        return view("employee", compact(
                    "EmployeeList",
                    'GenderList', 
                    'CompanyList',
                    'PositionList', 
                    'SuperVisor'
                ));
    }

    public function create(Request $request) { 
        DB::beginTransaction();
        try {
            $employee = new Employee;
            $employee->full_name = $request->full_name;
            $employee->email = $request->email;
            $employee->country = $request->country;
            $employee->city = $request->city;
            $employee->address = $request->address;
            $employee->gender_id = $request->gender_id;
            $employee->user_id = 1;
            $employee->company_id = $request->company_id;
            $employee->position_id = $request->position_id;
            $employee->super_visor_id = $request->super_visor_id;
            $employee->save();

            DB::commit();

            return redirect()->back()->with('success', 'Employee added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add employee.');
        }
    }


    public function destroy($id) {
        try {
            Employee::find($id)->delete();
            return response()->json(['success' => 'Employee deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete employee.'], 500);
        }
    }    
}
