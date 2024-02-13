<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Laravel</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <!-- css style -->
        <link rel="stylesheet" href="../assets/style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>

    <body>
        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Laravel <b>Employees</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                                <i class="material-icons">&#xE147;</i> <span>Add New Employee</span>
                            </a>
                            <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal">
                                <i class="material-icons">&#xE15C;</i> <span>Delete</span>
                            </a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="selectAll" />
                                    <label for="selectAll"></label>
                                </span>
                            </th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody class="table_tbody">
                        @foreach ($EmployeeList as $item)
                            <tr>
                                <td class="custom-checkbox">
                                    <input type="checkbox" id="selectAll" />
                                    <label for="selectAll"></label>
                                </td>
                                <td>{{$item->full_name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->country}}</td>
                                <td>{{$item->city}}</td>
                                <td>{{$item->address}}</td>
                                <td>
                                    <a href="#editEmployeeModal" class="edit" data-toggle="modal">
                                        <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
                                    </a>
                                    <a href="#deleteEmployeeModal" class="delete" data-toggle="modal" data-id="{{ $item->id }}">
                                        <i class='material-icons' data-toggle='tooltip' title='Delete'>&#xE872;</i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text">Showing <b>{{$EmployeeList->count()}}</b> out of <b>{{$EmployeeList->total()}}</b> entries</div>
                    <ul class="pagination">
                        <li class="page-item {{ $EmployeeList->previousPageUrl() ? '' : 'disabled' }}">
                            <a href="{{ $EmployeeList->previousPageUrl() ?? '#' }}" class="page-link">Previous</a>
                        </li>
                        @for ($i = max(1, $EmployeeList->currentPage() - 2); $i <= min($EmployeeList->lastPage(), $EmployeeList->currentPage() + 3); $i++)
                            <li class="page-item {{ $i == $EmployeeList->currentPage() ? 'active' : '' }}">
                                <a href="{{ $EmployeeList->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ $EmployeeList->nextPageUrl() ? '' : 'disabled' }}">
                            <a href="{{ $EmployeeList->nextPageUrl() ?? '#' }}" class="page-link">Next</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Add Modal -->
        <div id="addEmployeeModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{route('employee_create')}}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">Add Employee</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="full_name" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required />
                            </div>
                            <div class="form-group select-box">
                                <div class="box_select">
                                    <label>Country</label>
                                    <select class="form-select" name="country">
                                        <option value="Mustard">Mustard</option>
                                        <option value="Ketchup">Ketchup</option>
                                        <option value="Relish">Relish</option>
                                    </select>  
                                </div>
                                <div class="box_select">
                                    <label>City</label>
                                    <select class="form-select" name="city">
                                        <option value="Vashington">Vashington</option>
                                        <option value="Glendel">Glendel</option>
                                        <option value="Relish">Relish</option>
                                    </select>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" name="address" required></textarea>
                            </div>
                            <div class="form-group select-box">
                                <div class="box_select">
                                    <label>Gender</label>
                                    <select class="form-select" style="text-transform: capitalize;" name="gender_id">
                                        @foreach ($GenderList as $item) 
                                            <option value="{{$item->id}}">{{$item->gender}}</option>
                                        @endforeach
                                    </select>  
                                </div>
                                <div class="box_select">
                                    <label>Company</label>
                                    <select class="form-select" style="text-transform: capitalize;" name="company_id">
                                        @foreach ($CompanyList as $item) 
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>  
                                </div>
                            </div>
                            <div class="form-group select-box">
                                <div class="box_select">
                                    <label>Director</label>
                                    <select class="form-select" style="text-transform: capitalize;" name="super_visor_id">
                                        @foreach ($SuperVisor as $item) 
                                            <option value="{{$item->id}}">{{$item->full_name ?? 'N/A'}}</option>
                                        @endforeach
                                    </select>  
                                </div>
                                <div class="box_select">
                                    <label>Position</label>
                                    <select class="form-select" style="text-transform: capitalize;" name="position_id">
                                        @foreach ($PositionList as $item) 
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>  
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="text-align: center;">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                            <input type="submit" class="btn btn-success" value="Add" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editEmployeeModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Employee</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" required />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                            <input type="submit" class="btn btn-info" value="Save" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div id="deleteEmployeeModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    {{-- <form> --}}
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Employee</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body" style="text-align: center;">
                            <p>Are you sure you want to delete these Records?</p>
                            <p class="text-warning" style="text-align: center;"><small>This action cannot be undone.</small></p>
                        </div>
                        <div class="modal-footer" style="text-align: center;">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                            <input type="submit" class="btn btn-danger delete-employee" value="Delete" />
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                // Activate tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // Select/Deselect checkboxes
                var checkbox = $('table tbody input[type="checkbox"]');
                $("#selectAll").click(function () {
                    if (this.checked) {
                        checkbox.each(function () {
                            this.checked = true;
                        });
                    } else {
                        checkbox.each(function () {
                            this.checked = false;
                        });
                    }
                });
                checkbox.click(function () {
                    if (!this.checked) {
                        $("#selectAll").prop("checked", false);
                    }
                });

                $(document).on('click', '.delete-employee', function() {
                    var token = $("meta[name='csrf-token']").attr("content");
                    var id = $('.delete').data('id');
                    var trObj = $('.delete');

                    console.log(id);
                        $.ajax({
                            url: 'employee/' + id,
                            type: 'DELETE',
                            data: {
                                "id": id,
                                "_token": token,
                            },
                            dataType: 'json',
                            success: function(data) {
                                alert(data.success);
                                // trObj.parents("tr").remove();
                            }
                        });
                });

            });
        </script>

    </body>
</html>
