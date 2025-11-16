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

        <div class="row" id="company-list">
            
        </div>
        <div class="text-center mt-3 mb-3">
            <button class="btn btn-outline-primary" id="loadMoreBtn">Load More</button>
        </div>
    </div>
</x-app-layout>

@include('companies.add-company')

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
        let page = 1;
        let loading = false;
        function loadCompanies(reset = false) {
            console.log(reset);
            console.log(loading);
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
                    errorMsg('An error occurred while creating the company.');
                }
            });
        });
    });

    $(document).on('click', '.edit-user', function() {
        const userId = $(this).data('id');
        $.ajax({
            url: "{{ url('companies/edit') }}/" + userId,
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

</script>