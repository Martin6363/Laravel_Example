<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!-- css style -->
        <link rel="stylesheet" href="../assets/style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </head>

    <body>
        <header>
            <nav class="navbar navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">Laravel</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                          <a class="nav-link active" aria-current="page" href="#">Home</a>
                          <a class="nav-link" href="#">Features</a>
                          <a class="nav-link" href="#">Pricing</a>
                          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                        </div>
                      </div>
                    </div>
                  </div>
            </nav>
        </header>
        <div class="container">
            <div class="table-wrapper">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Laravel <b>Employees</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                                <i class="material-icons">&#xE147;</i> <span>Add New Employee</span>
                            </button>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal">
                                <i class="material-icons">&#xE15C;</i> <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card col d-flex p-2" style="flex-direction: row; justify-content: space-between">
                    <div class="form-group d-flex align-items-center gap-2" style="width: 150px">
                        <label>Show:</label>
                        <select id="paginationSelect" class="form-select form-select-sm">
                            <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        </select>
                        <span>entries</span>
                    </div>
                    <div class="form-group float-end">
                        <form class="d-flex w-100" action="{{route('search_employee')}}" method="GET">
                            <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-sm btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="selectAll" />
                                        <label for="selectAll"></label>
                                    </span>
                                </th>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Aded at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table_tbody">
                            @foreach ($EmployeeList as $item)
                                <tr>
                                    <td>
                                        <span class="custom-checkbox">
                                            <input type="checkbox" id="selectAll" />
                                            <label for="selectAll"></label>
                                        </span>
                                    </td>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->full_name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->country}}</td>
                                    <td>{{$item->city}}</td>
                                    <td>{{$item->address}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <a class="edit" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#editEmployeeModal">
                                            <i class="fa-solid fa-pen" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i>
                                        </a>
                                        <a class="delete" data-bs-toggle="modal" data-id="{{ $item->id }}">
                                            <i class='fa-solid fa-trash' data-bs-toggle='tooltip' data-bs-placement="top" title='Delete'></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <thead>
                            <tr style="background: rgba(0,0,0,0.5); color: #fff">
                                <th>
                                    {{-- Checkbox content... --}}
                                </th>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Aded at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
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
        <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{route('employee_create')}}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">Add Employee</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <div class="box_select mt-2">
                                    <label>Country</label>
                                    <select class="form-select form-select-sm" name="country">
                                        <option value="Mustard">Mustard</option>
                                        <option value="Ketchup">Ketchup</option>
                                        <option value="Relish">Relish</option>
                                    </select>  
                                </div>
                                <div class="box_select mt-2">
                                    <label>City</label>
                                    <select class="form-select form-select-sm" name="city">
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
                                <div class="box_select mt-2">
                                    <label>Gender</label>
                                    <select class="form-select form-select-sm" style="text-transform: capitalize;" name="gender_id">
                                        @foreach ($GenderList as $item) 
                                            <option value="{{$item->id}}">{{$item->gender}}</option>
                                        @endforeach
                                    </select>  
                                </div>
                                <div class="box_select">
                                    <label>Company</label>
                                    <select class="form-select form-select-sm" style="text-transform: capitalize;" name="company_id">
                                        @foreach ($CompanyList as $item) 
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>  
                                </div>
                            </div>
                            <div class="form-group select-box">
                                <div class="box_select mt-2">
                                    <label>Director</label>
                                    <select class="form-select form-select-sm" style="text-transform: capitalize;" name="super_visor_id">
                                        @foreach ($SuperVisor as $item) 
                                            <option value="{{$item->id}}">{{$item->full_name ?? 'N/A'}}</option>
                                        @endforeach
                                    </select>  
                                </div>
                                <div class="box_select mt-2">
                                    <label>Position</label>
                                    <select class="form-select form-select-sm" style="text-transform: capitalize;" name="position_id">
                                        @foreach ($PositionList as $item) 
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>  
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="text-align: center;">
                            <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel" />
                            <input type="submit" class="btn btn-success" value="Add" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Add Modal -->

        <!-- Edit Modal -->
        <div id="editEmployeeModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Employee</h4>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-hidden="true"></button>
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
        <!-- End Edit Modal -->

        <!-- Delete Modal -->
        <div id="deleteEmployeeModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Employee</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body" style="text-align: center;">
                        <p>Are you sure you want to delete these Records?</p>
                        <p class="text-warning" style="text-align: center;"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel" />
                        <button type="button" id="delete_member" class="btn btn-danger delete-employee">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Delete Modal -->


            <script type="text/javascript">
                $(document).ready(function () {
                
                    // Show PerPage column
                    $('#paginationSelect').change(function() {
                        window.location.href = "{{ route('employees') }}?Page=" + $(this).val();
                    });
                    
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
                    

                    // Generate delte ID in MODAL
                    $(document).on('click', '.delete', function(e) {
                        e.preventDefault();
                        var id = $(this).data('id');
                        $('#deleteEmployeeModal').modal('show');
                        $('#delete_member').val(id);
                    });

                    // Delete data
                    $('#delete_member').click(function() {
                        var id = $(this).val();
                        console.log(id);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '/delete/' + id,
                            type: 'DELETE',
                            dataType: 'json',
                            success: function(data) {
                                $('.delete').parent().remove();
                                $('#deleteEmployeeModal').modal('hide');
                            }
                        });
                    })


            });
        </script>

    </body>
</html>
