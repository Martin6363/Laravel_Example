import './bootstrap';


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
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/delete/' + id,
            type: 'DELETE',
            dataType: 'json',
            success: function(data) {
                $('tr[data-id="' + id + '"]').remove();
                $('#deleteEmployeeModal').modal('hide');
            }
        });
    })


    // Edit data
    $(document).on('click', '.edit', function () {
        let id = $(this).data('id');
        
        $.ajax({
            url: '/edit/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('tr[data-id="' + data.id + '"]')
                $('#full_name').val(data.full_name);
                $('#email').val(data.email);
                $('#country').val(data.country);
                $('#city').val(data.city);
                $('#address').val(data.address);
                $('#company').val(data.company_id); 
                $('#director').val(data.super_visor_id);
                $('#position').val(data.position_id);
                $('#salary_amount').val(data.salary.amount); 
                $('#gender').val(data.gender_id);

            }
        })
    })
    
    // Search data
    function performSearch() {
        var value = $('#search').val();
        
        $.ajax({
            type: 'GET',
            url: '{{ route('search_employee') }}',
            data: {'search': value},
            success:function(data) {
                $('.table_tbody').html(data);
            }
        });
    }


    $('#searchBtn').click(function() {
        if($('#search').val() != '') {
            performSearch();
        } else {
            $('#search').focus()
        }
    });


    $('#search').keypress(function(event) {
        if (event.which == 13) {
            performSearch();
        }
    });
});