<x-app-layout>
    <div class="content pb-0">

        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1">Leads<span class="badge badge-soft-primary ms-2">{{$leadcount}}</span></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Leads</li>
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
                    <a href="{{ route('leads.index', ['pagetype' => 'list']) }}" class="btn btn-sm p-1 border-0 fs-14 {{ request('pagetype') == 'list' ? 'active' : '' }}"><i class="ti ti-list-tree"></i></a>
                    <a href="{{ route('leads.index', ['pagetype' => 'grid']) }}" class="flex-shrink-0 btn btn-sm p-1 border-0 ms-1 fs-14 {{ request('pagetype') != 'list' ? 'active' : '' }}"><i class="ti ti-grid-dots"></i></a>
                </div>
                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add Lead</a>
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
            @include('leads.list')
        @else
            <div class="row" id="company-list"></div>
            <div class="text-center mt-3 mb-3">
                <button class="btn btn-outline-primary" id="loadMoreBtn">Load More</button>
            </div>
        @endif
    </div>
</x-app-layout>

@include('leads.add-lead', compact('companies', 'company_types', 'lead_sources', 'lead_status', 'products', 'icons', 'users'))

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
        var type = "{{ request('pagetype') ?? 'grid' }}";
        if(type === 'list') {
            let table = $('#manage-lead-list').DataTable({
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
                    url : "{{ route('leads.index', ['pagetype' => 'list']) }}",
                    data: function (d) {
                        d.name = $('#name').val();
                        d.status = $('#status').val();
                        d.fromdate = $('#fromdate').val();
                        d.todate = $('#todate').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'company_name', name: 'company_name', orderable: false, searchable: true},
                    {data: 'user', name: 'user', orderable: false, searchable: true},
                    {data: 'number', name: 'number', orderable: false, searchable: true},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
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
                    url: "{{ route('leads.index') }}",
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

        $('#createLeadForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('leads.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    successMsg('Lead created successfully!');
                    location.reload();
                },
                error: function (xhr) {
                    errorMsg('An error occurred while creating the company.');
                }
            });
        });

        $(".company_listss").select2({
            width: 'resolve'
        });

        $('input[name="product"]').on('change', function () {
            let productId = $(this).val();
            $.ajax({
                url: "{{ url('/packages-by-product') }}/" + productId,
                method: "GET",
                success: function (response) {
                    $("#product_to_packages").html('<option value="">Select Package</option>');
                    $.each(response, function (key, package) {
                        $("#product_to_packages").append(
                            '<option value="' + package.id + '">' + package.quantity + '</option>'
                        );
                    });
                }
            });
        });
    });

    $(document).on('click', '.edit-lead', function() {
        const id = $(this).data('id');
        $.ajax({
            url: "{{ url('leads/edit') }}/" + id,
            type: 'GET',
            success: function(response) {
                $('#offcanvas_edit .offcanvas-body').html(response);
                $('#offcanvas_edit').offcanvas('show');
            },
            error: function() {
                errorMsg('Failed to load edit form.');
            }
        });
    });

    $(document).on('submit', '#updateLeadForm', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        var leadId = $('#lead_id').val(); // Read ID correctly

        $.ajax({
            type: 'POST',
            url: "{{ url('/leads/update') }}/" + leadId, // Correct dynamic route
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                successMsg('Lead updated successfully!');
                location.reload();
            },
            error: function (xhr) {
                errorMsg(xhr.responseJSON.message || 'An error occurred while updating the lead.');
            }
        });
    });

    $(document).on('click', '.delete-lead', function() {
        var leadId = $(this).data('id');
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
                    url: "{{ url('leads/delete') }}/" + leadId,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        successMsg('Lead deleted successfully!');
                        location.reload();
                    },
                    error: function(xhr) {
                        errorMsg(xhr.responseJSON.message || 'An error occurred while deleting the user.');
                    }
                });
            }
        });
    });
</script>