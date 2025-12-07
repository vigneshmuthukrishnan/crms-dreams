<x-app-layout>
    <div class="content pb-0">

        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1">Companies<span class="badge badge-soft-primary ms-2">{{$companycount}}</span></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">companies</li>
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
                                <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-xls me-1"></i>Export as Excel</a>
                            </li>
                        </ul>
                    </div>
                </div> -->
                <div class="d-flex align-items-center shadow p-1 rounded border view-icons bg-white">
                    <a href="{{ route('companies.index', ['pagetype' => 'list']) }}" class="btn btn-sm p-1 border-0 fs-14 {{ request('pagetype') == 'list' ? 'active' : '' }}"><i class="ti ti-list-tree"></i></a>
                    <a href="{{ route('companies.index', ['pagetype' => 'grid']) }}" class="flex-shrink-0 btn btn-sm p-1 border-0 ms-1 fs-14 {{ request('pagetype') != 'list' ? 'active' : '' }}"><i class="ti ti-grid-dots"></i></a>
                </div>
                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add Company</a>
            </div>
        </div>  

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
                <button type="button" class="btn btn-info" id="resetBtn">Reset</button>                         
            </div>
        </div>

        @if(request('pagetype') === 'list')
            @include('companies.company_lists')
        @else
            <div class="row" id="company-list"></div>
            <div class="text-center mt-3 mb-3">
                <button class="btn btn-outline-primary" id="loadMoreBtn">Load More</button>
            </div>
        @endif
    </div>
</x-app-layout>

@include('companies.add-company', compact('industrys', 'sources'))

<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_edit">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">Edit Company</h5>
        <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas"></button> 
    </div>
    <div class="offcanvas-body">
    </div>
</div>

@if(request('pagetype') === 'list')

@endif
<script>
    $(document).ready(function () {
        var type = "{{ request('pagetype') ?? 'grid' }}";
        if(type === 'list') {
            let table = $('#manage-company-list').DataTable({
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
                    url : "{{ route('companies.index', ['pagetype' => 'list']) }}",
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
                    {data: 'address', name: 'address', orderable: false, searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
            });

            $('#searchBtn').on('click', function() {
                table.ajax.reload();
            });

            $('#resetBtn').on('click', function() {
                $('#name').val('');
                $('#fromdate').val('');
                $('#todate').val('');
                $('#searchBtn').click();
                table.ajax.reload();
            });
        } else { 
            let page = 1;
            let loading = false;
            function loadCompanies(reset = false) {
                if (loading) return;
                loading = true;

                if (reset) {
                    page = 1;
                    $('#company-list').html('');
                }

                let name = $('#name').val();
                let status = $('#status').val();
                let fromdate = $('#fromdate').val();
                let todate = $('#todate').val();

                $.ajax({
                    url: "{{ route('companies.index') }}",
                    type: "GET",
                    data: {name, status, fromdate, todate, page },
                    success: function (response) {
                        if (reset) {
                            $('#company-list').html(response.html);
                        } else {
                            $('#company-list').append(response.html);
                        }

                        if (response.hasMore) {
                            $('#loadMoreBtn').show();
                        } else {
                            $('#loadMoreBtn').hide();
                        }

                        loading = false;
                    },
                    error: function () {
                        errorMsg('Something went wrong.');
                        loading = false;
                    }
                });
            }

            loadCompanies();
            
            $('#searchBtn').on('click', function () {
                loadCompanies(true);
            });

            $('#loadMoreBtn').on('click', function () {
                page++;
                loadCompanies();
            });

            $('#resetBtn').on('click', function () {
                $('#name').val('');
                $('#fromdate').val('');
                $('#todate').val('');
                $('#searchBtn').click();
            });
        } 

        $('#createCompanyForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('companies.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    successMsg('Company created successfully!');
                    location.reload();
                },
                error: function (xhr) {
                    errorMsg(xhr.responseJSON.message || 'An error occurred while creating the company.');
                }
            });
        });
    });

    $(document).on('click', '.edit-company', function() {
        const userId = $(this).data('id');
        $.ajax({
            url: "{{ url('companies/edit') }}/" + userId,
            type: 'GET',
            success: function(response) {
                $('#offcanvas_edit').offcanvas('show');
                $('#offcanvas_edit .offcanvas-body').html(response);
            },
            error: function(xhr) {
                errorMsg(xhr.responseJSON.message || 'Failed to load edit form.');
            }
        });
    });

    $(document).on('submit', '#updateCompanyForm', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        var companyId = $('#company_id').val(); // Read ID correctly

        $.ajax({
            type: 'POST',
            url: "{{ url('/companies/update') }}/" + companyId, // Correct dynamic route
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                successMsg('Company updated successfully!');
                location.reload();
            },
            error: function (xhr) {
                errorMsg(xhr.responseJSON.message || 'An error occurred while updating the company.');
            }
        });
    });

    // delete company
    $(document).on('click', '.delete-company', function() {
        var companyId = $(this).data('id');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('companies/delete') }}/" + companyId,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        successMsg('Company deleted successfully!');
                        location.reload();
                    },
                    error: function(xhr) {
                        errorMsg(xhr.responseJSON.message || 'An error occurred while deleting the user.');
                    }
                });
            }
        });
    });

    
    $(document).on('change', '#country', function (e) {
        let country = $(this).val();
        if(country === "India"){
            $.ajax({
                url: "https://countriesnow.space/api/v0.1/countries/states",
                method: "POST",
                data: JSON.stringify({ country: "India"}),
                contentType: "application/json",
                success: function(response){
                    $("#state").empty().append('<option>Select State</option>');
                    $.each(response.data.states, function(index, state){
                        $("#state").append('<option value="'+state.name+'">'+state.name+'</option>');
                    });
                }
            });
        }
    });

    $(document).on('change', '#state', function (e) {
        let state = $(this).val();
        $.ajax({
            url: "https://countriesnow.space/api/v0.1/countries/state/cities",
            method: "POST",
            data: JSON.stringify({ country: "India", state: state}),
            contentType: "application/json",
            success: function(response){
                $("#city").empty().append('<option>Select City</option>');
                $.each(response.data, function(index, city){
                    $("#city").append('<option value="'+city+'">'+city+'</option>');
                });
            }
        });
    });
</script>