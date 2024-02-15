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
    public function index(Request $request) {
        $perPage = $request->input('Page', 5);

        $EmployeeList = Employee::orderBy("id","DESC")->paginate($perPage);
        $GenderList = Gender::all();
        $CompanyList = Company::all();
        $PositionList = Position::all();
        $SuperVisor = $this->getSupervisors($EmployeeList);
        return view("employee", compact(
                    "EmployeeList",
                    'GenderList', 
                    'CompanyList',
                    'PositionList', 
                    'SuperVisor',
                    'perPage',
                ));
    } 


    private function getSupervisors($employees) {
        $superVisor = [];

        foreach ($employees as $employee) {
            $supervisor = Employee::where('id', $employee->super_visor_id)->first();
            $superVisor[$employee->id] = $supervisor;
        }

        return $superVisor;
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


    public function delete($id) {
        try {
            Employee::find($id)->delete();
            return response()->json(['success' => 'Employee deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete employee.'], 500);
        }
    }  


    public function search(Request $request) {
            $SearchData = Employee::where('id','LIKE','%'. $request->search .'%')
            ->orWhere('full_name', 'LIKE', '%'. $request->search .'%')
            ->orWhere('email', 'LIKE', '%'. $request->search .'%');
        return $SearchData;
    }
}
