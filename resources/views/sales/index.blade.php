<x-app-layout>
    <div class="content pb-0">

        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1">Clients<span class="badge badge-soft-primary ms-2"></span></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Clients</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card border-0 rounded-0">
            <div class="card-body">

                <form method="GET" action="{{ route('clients.index') }}">
                    <div class="row">
                        <!-- <div class="col-md-2 mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Search by Name, Email or Phone" value="{{ request('name') }}">
                        </div> -->

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
                                <th>S.no</th>
                                <th>Company</th>
                                <th>Product</th>
                                <th>Package</th>
                                <th>Paymode</th>
                                <th>Price</th>
                                <th>GST</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $index => $client)
                                <tr>
                                    <td>{{ $clients->firstItem() + $index }}</td>
                                    <td>
                                        @if($client->lead)
                                            {{ $client->company->name }}, {{ $client->lead->customer_name }}
                                        @else
                                            N/A
                                        @endif
                                        </td>
                                    <td>{{ $client->lead->product->name ?? 'N/A' }}</td>
                                    <td>{{ $client->lead->productdetail->quantity ?? 'N/A' }}</td>
                                    <td>{{ $client->payment_mode }}</td>
                                    <td>{{ number_format($client->amount, 2) }}</td>
                                    <td>{{ number_format($client->gst, 2) }}</td>
                                    <td>{{ number_format($client->grand_total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>