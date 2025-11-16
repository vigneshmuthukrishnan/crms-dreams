<x-app-layout>
    <div class="content pb-0">

        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1">Manage Users<span class="badge badge-soft-primary ms-2">{{$usercount}}</span></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Users</li>
                    </ol>
                </nav>
            </div>
            <div class="gap-2 d-flex align-items-center flex-wrap">
                <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" data-bs-toggle="dropdown"><i class="ti ti-package-export me-2"></i>Export</a>
                    <div class="dropdown-menu  dropdown-menu-end">
                        <ul>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-pdf me-1"></i>Export as
                                    PDF</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-xls me-1"></i>Export as
                                    Excel </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add User</a>
            </div>
        </div>                

        <div class="card border-0 rounded-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Search by Name, Email or Phone">
                    </div>
                    <div class="col-md-2 mb-3">
                        <select class="form-select" id="status" name="status">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="date" class="form-control" id="fromdate" name="fromdate" placeholder="From Date">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="date" class="form-control" id="todate" name="todate" placeholder="To Date">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="button" class="btn btn-primary" id="searchBtn">Search</button>                         
                        <button type="button" class="btn btn-info" id="resetBtn">Reset</button>                         
                    </div>
                </div>

                <div class="table-responsive custom-table">
                    <table class="table table-nowrap" id="manage-users-list">
                        <thead class="table-light">
                            <tr>
                                <th class="no-sort">S.no</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Created</th>
                                <th>Last Activity</th>
                                <th>Status</th>
                                <th class="text-end no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="datatable-length"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="datatable-paginate"></div>
                    </div>
                </div>
                    
            </div>
        </div>
    </div>
</x-app-layout>

@include('users.add-user')
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_edit">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">Edit User</h5>
        <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
    </div>
</div>

<script>
$(document).ready(function () {
    let table = $('#manage-users-list').DataTable({
        "bFilter": false, 
        "bInfo": false,
        "serverSide": true,
        "processing": true,
        language: {
            search: ' ',
            sLengthMenu: '_MENU_',
            searchPlaceholder: "Search",
            info: "_START_ - _END_ of _TOTAL_ items",
            lengthMenu: "Show _MENU_ entries",
            paginate: {
                next: '<i class="ti ti-chevron-right"></i> ',
                previous: '<i class="ti ti-chevron-left"></i> '
            },
        },
        initComplete: (settings, json)=>{
            $('.dataTables_paginate').appendTo('.datatable-paginate');
            $('.dataTables_length').appendTo('.datatable-length');
        },
        ajax: {
            url : "{{ route('users.index') }}",
            data: function (d) {
                d.name = $('#name').val();
                d.status = $('#status').val();
                d.fromdate = $('#fromdate').val();
                d.todate = $('#todate').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name', orderable: false, searchable: true},
            {data: 'phone', name: 'phone', orderable: false, searchable: true},
            {data: 'email', name: 'email', orderable: false, searchable: true},
            {data: 'created', name: 'created', orderable: false, searchable: true},
            {data: 'last_activity', name: 'last_activity', orderable: false, searchable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
    });

    $('#searchBtn').on('click', function() {
        table.ajax.reload();
    });

    $('#resetBtn').on('click', function() {
        $('#name').val('');
        $('#status').val('');
        $('#fromdate').val('');
        $('#todate').val('');
        table.ajax.reload();
    });
});

$(document).on('click', '.edit-user', function() {
    const userId = $(this).data('id');
    $.ajax({
        url: "{{ url('users/edit') }}/" + userId,
        type: 'GET',
        success: function(response) {
            $('#offcanvas_edit .offcanvas-body').html(response);
            const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('offcanvas_edit'));
            offcanvasEdit.show();
        },
        error: function() {
            errorMsg('Failed to load edit form.');
        }
    });
});

$(document).on('submit', '#editUserForm', function(e) {
    e.preventDefault();
    const formData = $(this).serialize();
    const userId = $('#editUserId').val();
    console.log(formData);
    $.ajax({
        url: "{{ url('users/update') }}/" + userId,
        type: 'PUT',
        data: formData,
        success: function(response) {
            if(response.success) {
                successMsg('User updated successfully!');
                $('#offcanvas_edit').offcanvas('hide');
                $('#manage-users-list').DataTable().ajax.reload();
            } else {
                errorMsg('Failed to update user.');
            }
        },
        error: function(err) {
            console.log(err);
            errorMsg('An error occurred while updating the user.');
        }
    });
});

$(document).on('click', '.delete-user', function(){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        var userId = $(this).data('id');
        $.ajax({
            url: '/users/' + userId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (result.isConfirmed) {
                    successMsg("Your file has been deleted.");
                }
                $('#manage-users-list').DataTable().ajax.reload();
            },
            error: function(xhr) {
                errorMsg('An error occurred while deleting the user.')
            }
        });
    });
});

</script>