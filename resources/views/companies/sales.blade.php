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
            <input type="hidden" name="company_id" value="{{ $company->id }}">
            @csrf
            <div class="row">
                <div class="col-md-12 product_lists">
                    <div class="mb-2">
                    <label class="form-label">Product<span class="text-danger">*</span></label>
                        <ul class="radio-activity">
                            @foreach($allproducts as $product)
                                <li class="me-2 mb-2">
                                    <div class="active-type">
                                        <input type="radio" id="product_{{ $product->id }}" name="product" value="{{ $product->id }}">
                                        <label for="product_{{ $product->id }}" class="rounded">
                                            <i class="{{ $icons[$product->name] ?? 'ti ti-box' }} me-2"></i>
                                            {{ $product->name }}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 product_lists">
                    <div class="mb-3">
                        <label class="form-label">Packages <span class="text-danger ms-1">*</span></label>
                        <select class="form-control" data-toggle="select2" name="package" id="product_to_packages">
                        </select>
                    </div>
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
        $('#createLeadSalesForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '{{ route("companies.storeSales") }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    successMsg('Sales created successfully!');
                    location.reload();
                },
                error: function (xhr) {
                    errorMsg(xhr.responseJSON.message || 'An error occurred while creating the Lead Activity.');
                }
            });
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

        // here when entry amount gst total auto calculate
        $('input[name="amount"]').on('input', function() {
            var amount = parseFloat($('input[name="amount"]').val()) || 0;
            var gst = parseFloat($('input[name="gst"]').val()) || 0;
            var total = amount + gst;
            if($('input[name="gst"]').val() == '') {
                $('input[name="gst"]').val(gst.toFixed(2));
            }
            $('input[name="total"]').val(total.toFixed(2));
        });
        
        $('input[name="gst"]').on('input', function() {
            var amount = parseFloat($('input[name="amount"]').val()) || 0;
            var gst = parseFloat($('input[name="gst"]').val()) || 0;
            var total = amount + gst;
            if($('input[name="amount"]').val() == '') {
                $('input[name="amount"]').val(gst.toFixed(2));
            }
            $('input[name="total"]').val(total.toFixed(2));
        });
    });
</script>