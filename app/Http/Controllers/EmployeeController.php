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
        $supervisors = [];
    
        foreach ($employees as $employee) {
            $supervisorId = $employee->super_visor_id;
            
            $supervisor = Employee::where('id', $supervisorId)->distinct()->first();
            if ($supervisor) {
                $supervisors[$supervisorId] = $supervisor;
            }
        }
    
        return $supervisors;
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
            
            $employee->save();


            $salary = new Salary;
            $salary->amount = $request->salary;
            $salary->emp_id = $employee->id;
            $salary->save();

            DB::commit();

            return redirect()->back()->with('success', 'Employee added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add employee.');
        }
    }


    public function edit($id) {
        $employee = Employee::findOrFail($id);
        $position = Position::where('id', $employee->position_id)->first();
        $salary = Salary::where('emp_id', $employee->id)->first();
        
        $salaryAmount = $salary ? $salary->amount : null;

        $employee->position = $position->name;
        $employee->salary = $salaryAmount;

        $employee->salary = $salary ? [
            'amount' => $salary->amount,
            'bonus' => $salary->bonus,
        ] : null;

        unset($employee->position_id);
        return response()->json($employee);
    }

    public function update(Request $request, $id) {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        try {
            $employee = Employee::findOrFail($id);
            $employee->update($request->all());
    
            $salary = Salary::where('emp_id', $id)->firstOrFail();
            $salary->update(['amount' => $request->salary]);

            // $employee->update(['gender_id'=> $request->gender_id]);
            return redirect()->back()->with(['success' => 'Employee updated successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Failed to update employee']);
        }
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
                    <td id="sort_by">'.$value->id.'</td>
                    <td id="sort_by">'.$value->full_name.'</td>
                    <td id="sort_by">'.$value->email.'</td>
                    <td id="sort_by">'.$value->country.'</td>
                    <td id="sort_by">'.$value->city.'</td>
                    <td id="sort_by">'.$value->address.'</td>
                    <td id="sort_by">'.$value->created_at.'</td>
                    <td>
                        <a class="edit" data-bs-toggle="modal" data-bs-target="#editEmployeeModal" data-id="'.$value->id.'">
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
