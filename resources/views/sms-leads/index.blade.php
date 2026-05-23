<x-app-layout>
    <div class="content pb-0">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1">SMS Leads<span class="badge badge-soft-primary ms-2">{{ $leadcount }}</span></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">SMS Leads</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="Search Name, Phone, Looking For">
            </div>
            <div class="col-md-2 mb-3">
                <select class="form-control" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <input type="date" class="form-control" id="fromdate" name="fromdate">
            </div>
            <div class="col-md-2 mb-3">
                <input type="date" class="form-control" id="todate" name="todate">
            </div>
            <div class="col-md-2 mb-3">
                <button type="button" class="btn btn-primary" id="searchBtn">Search</button>
                <button type="button" class="btn btn-info" id="resetBtn">Reset</button>
            </div>
        </div>

        @include('sms-leads.list')
    </div>
</x-app-layout>

<script>
    $(document).ready(function () {
        let table = $('#manage-sms-lead-list').DataTable({
            bFilter: false,
            bInfo: false,
            serverSide: true,
            processing: true,
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
            initComplete: () => {
                $('.dataTables_paginate').appendTo('.datatable-paginate');
                $('.dataTables_length').appendTo('.datatable-length');
            },
            ajax: {
                url: "{{ route('sms-leads.index') }}",
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
                {data: 'looking_for', name: 'looking_for', orderable: false, searchable: true},
                {data: 'verification', name: 'verification', orderable: false, searchable: false},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        });

        $('#searchBtn').on('click', function () {
            table.ajax.reload();
        });

        $('#resetBtn').on('click', function () {
            $('#name').val('');
            $('#status').val('');
            $('#fromdate').val('');
            $('#todate').val('');
            table.ajax.reload();
        });

        $(document).on('click', '.update-sms-lead-status', function () {
            $.ajax({
                url: "{{ url('/sms-leads/status') }}/" + $(this).data('id'),
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    status: $(this).data('status')
                },
                success: function (response) {
                    successMsg(response.message || 'Status updated successfully!');
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    errorMsg(xhr.responseJSON.message || 'An error occurred while updating status.');
                }
            });
        });
    });
</script>
