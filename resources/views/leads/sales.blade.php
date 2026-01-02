<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add_sales">
    <div class="offcanvas-header border-bottom">
        <h5 class="mb-0">Add New Sales </h5>
        <button type="button"
            class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
            data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ti ti-x"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" enctype="multipart/form-data" id="createLeadSalesForm">
            @csrf
            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
            <input type="hidden" name="company_id" value="{{ $lead->company_id }}">
            <div class="row">

                <div class="col-md-6">
                    <label class="form-label requirded">Company</label>
                    <p>{{ $lead->company->name }}</p>
                    <p>{{ $lead->company->owner }}</p>
                </div>

                <div class="col-md-6">
                    <label class="form-label requirded">Email & Phone</label>
                    <p>{{ $lead->email }}</p>
                    <p>{{ $lead->number }}</p>
                </div>

                <div class="col-md-6">
                    <label class="form-label requirded">Lead Source</label>
                    <p>{{ $lead->lead_source }}</p>
                </div>

                <div class="col-md-6">
                    <label class="form-label requirded">Product Detials</label>
                    @if(!$lead->productdetail)
                        <p>N/A</p>
                    @else
                        <p>{{ $lead->productdetail->product->name }} - {{ $lead->productdetail->quantity }}</p>
                    @endif
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label requirded">Amount <span class="text-danger">*</span></label>
                    <input type="number" name="amount" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label requirded">GST <span class="text-danger">*</span></label>
                    <input type="number" name="gst" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label requirded">Total <span class="text-danger">*</span></label>
                    <input type="number" name="total" class="form-control" required>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label requirded">Type <span class="text-danger">*</span></label>
                        <select name="sales_type" class="form-select">
                            <option value="">Select Type</option>
                            @foreach($sales_types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label requirded">Paymode <span class="text-danger">*</span></label>
                        <select name="payment_mode" class="form-select">
                            <option value="">Select Paymode</option>
                            @foreach($payment_modes as $mode)
                                <option value="{{ $mode }}">{{ $mode }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="mb-00">
                        <label class="form-label">Transaction Details<span class="text-danger ms-1">*</span></label>
                        <textarea class="form-control" rows="3" name="transaction_details"></textarea>
                    </div>
                </div>

            </div>
            <div class="d-flex align-items-center justify-content-end mt-3">
                <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        
    });
</script>