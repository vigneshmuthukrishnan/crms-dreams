<x-app-layout>
    <div class="content pb-0">

        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1">Package Management</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Package Management</li>
                    </ol>
                </nav>
            </div>
            <div class="gap-2 d-flex align-items-center flex-wrap">
                <div class="dropdown">
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add Package</a>
                </div>
            </div>
        </div>                

        <div class="card border-0 rounded-0">
            <div class="card-body">
                <div class="table-responsive custom-table" style="overflow-x: hidden !important;">
                    <table class="table table-nowrap" id="manage-users-list">
                        <thead class="table-light">
                            <tr>
                                <th>Package</th>
                                <th>Quantity</th>
                                <th>SMS Cost</th>
                                <th>Offer Amount</th>
                                <th>GST</th>
                                <th>Total</th>
                                <th class="text-end no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packages as $package)
                                <tr>
                                    <td>{{ $package->package_name }}</td>
                                    <td>{{ $package->quantity }}</td>
                                    <td>{{ $package->sms_cost }}</td>
                                    <td>{{ $package->offer_amount }}</td>
                                    <td>{{ $package->gst }}</td>
                                    <td>{{ $package->total }}</td>
                                    <td class="text-end">
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item edit-user" href="javascript:void(0);" data-id="{{ $package->id }}" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                    <i class="ti ti-edit text-blue"></i> Edit
                                                </a>
                                                <a class="dropdown-item delete-user d-none" href="#" data-id="{{ $package->id }}" data-bs-toggle="modal" data-bs-target="#delete_contact">
                                                    <i class="ti ti-trash"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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