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
                            <input type="date" class="form-control" id="fromdate" name="fromdate" placeholder="From Date"  value="{{ $fromdate }}">
                        </div>
                        <!-- <div class="col-md-2 mb-3">
                            <input type="date" class="form-control" id="todate" name="todate" placeholder="To Date" value="{{ $todate }}">
                        </div> -->
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
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Product</th>
                                <th>Status</th>
                                <th>Next Action Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($Leadactivitys as $Leadactivity)
                                <tr>
                                    <td>{{ $Leadactivity->company->name }}, {{ $Leadactivity->lead->customer_name }}</td>
                                    <td>{{ $Leadactivity->lead->number }}</td>
                                    <td>{{ $Leadactivity->lead->email }}</td>
                                    <td>{{ $Leadactivity->product->name ?? '-' }} / {{ $Leadactivity->productdetail->quantity ?? '-' }}</td>
                                    <td>{{ ucfirst($Leadactivity->status) }}</td>
                                    <td>{{ $Leadactivity->next_action_date ? date('d-m-Y', strtotime($Leadactivity->next_action_date)) : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger">No records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $Leadactivitys->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>