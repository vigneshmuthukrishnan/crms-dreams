<x-app-layout>
    <div class="content pb-0">

        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1">Leads Report<span class="badge badge-soft-primary ms-2"></span></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Leads Report</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card border-0 rounded-0">
            <div class="card-body">

                <form method="GET" action="{{ route('report.leads') }}">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Search by Name, Email or Phone" value="{{ request('name') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <select class="form-select" id="status" name="status">
                                <option value="">Select Status</option>
                                @foreach($lead_status as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <input type="date" class="form-control" id="fromdate" name="fromdate" placeholder="From Date"  value="{{ request('fromdate') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <input type="date" class="form-control" id="todate" name="todate" placeholder="To Date" value="{{ request('todate') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <button type="submit" class="btn btn-primary" id="searchBtn">Search</button>                         
                            <a href="{{ route('report.leads') }}" class="btn btn-info">Reset</a>                      
                        </div>
                    </div>
                </form>

                <div class="table-responsive custom-table" style="overflow-x: hidden !important;">
                    <table class="table table-nowrap" id="manage-users-list">
                        <thead class="table-light">
                            <tr>
                                <th class="no-sort">S.no</th>
                                <th>Lead Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Created</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leads as $lead)
                                <tr>
                                    <td>{{ $lead->id }}</td>
                                    <td>{{ $lead->name }}</td>
                                    <td>{{ $lead->number }}</td>
                                    <td>{{ $lead->email }}</td>
                                    <td>{{ $lead->company_name }}</td>
                                    <td>{{ $lead->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $lead->product->name ?? '-' }} / {{ $lead->productdetail->quantity ?? '-' }}</td>
                                    <td>{{ $lead->productdetail->total ?? '0' }}</td>
                                    <td>{{ ucfirst($lead->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger">No records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $leads->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>