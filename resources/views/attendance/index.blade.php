<x-app-layout>
    <div class="content pb-0">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            
            <div>
                <h4 class="mb-1">Attendance</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Attendance</li>
                    </ol>
                </nav>
            </div>

            <div class="gap-2 d-flex align-items-center flex-wrap">
                <!-- <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" data-bs-toggle="dropdown"><i class="ti ti-package-export me-2"></i>Export</a>
                    <div class="dropdown-menu  dropdown-menu-end">
                        <ul>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-pdf me-1"></i>Export as PDF</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-xls me-1"></i>Export as Excel </a>
                            </li>
                        </ul>
                    </div>
                </div> -->
            </div>

        </div>

        <div class="card border-0 rounded-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Search by Name, Email or Phone">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="date" class="form-control" id="fromdate" name="fromdate" placeholder="From Date">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="date" class="form-control" id="todate" name="todate" placeholder="To Date">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="button" class="btn btn-primary" id="searchBtn">Search</button>
                    </div>
                </div>

                <div class="table-responsive custom-table" style="overflow-x: hidden !important;">
                    <table class="table table-nowrap" id="manage-attendance-list">
                        <thead class="table-light">
                            <tr>
                                <th class="no-sort">S.no</th>
                                <th>User Name</th>
                                <th>Date</th>
                                <th>Login Time</th>
                                <th>Logout Time</th>
                                <th>Total Hours</th>
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


<script>
    $(document).ready(function() {
        // here load current date from and to date picker
        let today = new Date().toISOString().split('T')[0];
        $('#fromdate').val(today);
        $('#todate').val(today);
        var table = $('#manage-attendance-list').DataTable({
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
                url: "{{ route('attendances.index') }}",
                data: function (d) {
                    d.name = $('#name').val();
                    d.fromdate = $('#fromdate').val();
                    d.todate = $('#todate').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'user_name', name: 'user_name' },
                { data: 'date', name: 'date' },
                { data: 'login_time', name: 'login_time' },
                { data: 'logout_time', name: 'logout_time' },
                { data: 'total_hours', name: 'total_hours' },
            ],
        });

        $('#searchBtn').on('click', function() {
            table.draw();
        });
    });
</script>