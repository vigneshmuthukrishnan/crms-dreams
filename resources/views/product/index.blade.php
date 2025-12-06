<x-app-layout>
    <div class="content pb-0">

        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1">Manage Product<span class="badge badge-soft-primary ms-2">{{$productCount}}</span></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Product</li>
                    </ol>
                </nav>
            </div>
            <div class="gap-2 d-flex align-items-center flex-wrap">
            </div>
        </div>                

        <div class="card border-0 rounded-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Search by Name, Email or Phone">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="button" class="btn btn-primary" id="searchBtn">Search</button>                         
                        <button type="button" class="btn btn-info" id="resetBtn">Reset</button>                         
                    </div>
                </div>

                <div class="table-responsive custom-table" style="overflow-x: hidden !important;">
                    <table class="table table-nowrap" id="manage-product-list">
                        <thead class="table-light">
                            <tr>
                                <th class="no-sort">S.no</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Cost</th>
                                <th>Amount</th>
                                <th>Gst</th>
                                <th>total</th>
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
$(document).ready(function () {
    let table = $('#manage-product-list').DataTable({
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
            url : "{{ route('product.index') }}",
            data: function (d) {
                d.name = $('#name').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name', orderable: false, searchable: true},
            {data: 'quantity', name: 'quantity', orderable: false, searchable: true},
            {data: 'cost', name: 'cost', orderable: false, searchable: true},
            {data: 'amount', name: 'amount', orderable: false, searchable: true},
            {data: 'gst', name: 'gst', orderable: false, searchable: true},
            {data: 'total', name: 'total', orderable: false, searchable: true},
        ],
    });

    $('#searchBtn').on('click', function() {
        table.ajax.reload();
    });

    $('#resetBtn').on('click', function() {
        $('#name').val('');
        table.ajax.reload();
    });
});

</script>