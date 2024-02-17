<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Gender;
use App\Models\Position;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\New_;
use Illuminate\Support\Facades\Log;

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
            $employee->super_visor_id = $request->super_visor;
           
            $salary = new Salary;
            $salary->amount = $request->salary;
            $salary->emp_id = $employee->id;
            $employee->save();
            $salary->save();

            DB::commit();

            return redirect()->back()->with('success', 'Employee added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add employee.');
        }
    }


    public function edit($id) {
        $employee = Employee::find($id);
        // $gender = Gender::where('id', $employee->gender_id)->first();
        // $employee->gender_id = $gender->gender;
        return response()->json($employee);
    }

    public function delete($id) {
        try {
            $employee = Employee::find($id);;
            if (!$employee) {
                return response()->json(['error' => 'Employee not found.'], 404);
            }
            $employee->delete();
            return response()->json(['success' => 'Employee deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Error deleting employee: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete employee.'], 500);
        }
    }  


    public function search(Request $request) {
            $output = '';
            $SearchData = Employee::where('id','LIKE','%'. $request->search .'%')
            ->orWhere('full_name', 'LIKE', '%'. $request->search .'%')
            ->orWhere('email', 'LIKE', '%'. $request->search .'%')->get();

            foreach ($SearchData as $value) {
                $output .= '
                <tr data-id="'.$value->id.'">
                    <td>
                        <span class="custom-checkbox">
                            <input type="checkbox" id="selectAll" />
                            <label for="selectAll"></label>
                        </span>
                    </td>
                    <td>'.$value->id.'</td>
                    <td>'.$value->full_name.'</td>
                    <td>'.$value->email.'</td>
                    <td>'.$value->country.'</td>
                    <td>'.$value->city.'</td>
                    <td>'.$value->address.'</td>
                    <td>'.$value->created_at.'</td>
                    <td>
                        <a class="edit" data-bs-toggle="modal" data-bs-target="#editEmployeeModal">
                            <i class="fa-solid fa-pen" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i>
                        </a>
                        <a class="delete" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal" data-id="'.$value->id.'">
                            <i class="fa-solid fa-trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i>
                        </a>
                    </td>
                </tr>
            ';

            }
            return response()->json($output);
    }
}
