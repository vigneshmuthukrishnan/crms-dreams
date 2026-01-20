<x-app-layout>
    <div class="content pb-0">

        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <h6><a href="{{ url('/leads') }}"><i class="ti ti-arrow-narrow-left me-1"></i>Back to Leads</a></h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body pb-2">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar avatar-xxl avatar-rounded me-3 flex-shrink-0">
                                <img src="{{ $lead->company->LogoUrl }}" alt="img">
                                <span class="status online"></span>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $lead->company->name}}</h5>
                                <p class="mb-1">{{ $lead->company->owner}}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            @if(!empty($lead->email))
                                <a href="mailto:{{ $lead->email }}" class="btn btn-primary">
                                    <i class="ti ti-mail me-1"></i>Send Email
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body p-3">
                        <h6 class="mb-3 fw-semibold">Basic Information</h6>
                        <div class="border-bottom mb-3 pb-3">
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-mail fs-14"></i>
                                </span>
                                <p class="mb-0"><a href="mailto:{{ $lead->email }}" class="__cf_email__" data-cfemail="d0bebfa6b1a7b1a6b590b7bdb1b9bcfeb3bfbd">{{ $lead->email }}</a></p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-phone fs-14"></i>
                                </span>
                                <p class="mb-0">{{ $lead->number ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-map-pin-pin fs-14"></i>
                                </span>
                                <p class="mb-0">{{ $lead->state ?? 'N/A' }}, {{ $lead->city ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <span
                                    class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-calendar-exclamation fs-14"></i>
                                </span>
                                <p class="mb-0">
                                    Created on {{ $lead->created_at->format('d M Y, h:i A') }}
                                </p>
                            </div>
                        </div>
                        <h6 class="mb-3 fw-semibold">Package Information</h6>
                        <div class="border-bottom mb-3 pb-3">
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-package fs-14"></i>
                                </span>
                                <p class="mb-0">{{ $products->name }}</p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-message fs-14"></i>
                                </span>
                                @if($packages)
                                    <p class="mb-0">{{ $packages->quantity ?? 'N/A' }}</p>
                                @else
                                    <p class="mb-0">N/A</p>
                                @endif
                            </div>
                            <div class="d-flex align-items-center">
                                <span
                                    class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-currency-dollar fs-14"></i>
                                </span>
                                <p class="mb-0">
                                    @if($packages)
                                        Price: {{ number_format($packages->total, 2) ?? 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                    
                                </p>
                            </div>
                        </div>
                        <hr>
                        <h6 class="mb-3 fw-semibold">Other Information</h6>
                        <ul class="border-bottom mb-3 pb-3">
                            <li class="row mb-2"><span class="col-6">
                                Last Modified</span><span class="col-6 text-dark">{{ $lead->updated_at->format('d M Y, h:i A') }}</span>
                            </li>
                            <li class="row">
                                <span class="col-6">Source</span><span class="col-6 text-dark">{{ $lead->lead_source }}</span>
                            </li>
                        </ul>
                        <h6 class="mb-3 fw-semibold">Settings</h6>
                        <div class="mb-0">
                            <a href="javascript:void(0);" class="d-block mb-2"><span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2"><i class="ti ti-share-2"></i></span>Share Contact</a>
                            <a href="javascript:void(0);" class="d-block mb-2"><span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2"><i class="ti ti-star"></i></span>Add to Favourite</a>
                            <a href="javascript:void(0);" class="d-block mb-0" data-bs-toggle="modal" data-bs-target="#delete_contact"><span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2"><i class="ti ti-trash-x"></i></span>Delete Contact</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body pb-0 pt-2">
                        <ul class="nav nav-tabs nav-bordered mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#tab_1" data-bs-toggle="tab" aria-expanded="false" class="nav-link active border-3" aria-selected="true" role="tab">
                                    <span class="d-md-inline-block"><i class="ti ti-alarm-minus me-1"></i>Activities</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content pt-0">

                    <!-- Activities -->
                    <div class="tab-pane active show" id="tab_1">
                        <div class="card">
                            <div
                                class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                <h5 class="fw-semibold mb-0">Activities</h5>
                                <div class="dropdown">
                                    @if($lead->is_next_callback || (!$lead->is_next_callback && !$lead->is_closed && !$lead->is_invalid))
                                        <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add_activity"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add New Activity</a>
                                    @endif
                                </div>
                            </div>
                            @if($lead->activities->isEmpty())
                                <div class="card-body">
                                    <p>No activities found for this lead.</p>
                                </div>
                            @else
                                @foreach($lead->activities as $activity)
                                    @include('leads.partials.activity', ['activity' => $activity, 'lead_status' => $lead_status])
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <!-- /Activities -->
                </div>
            </div>            
        </div>
    </div>
</x-app-layout>

@include('leads.activities', compact('allproducts'))
<!-- @include('leads.sales', compact('lead', 'allproducts', 'sales_types', 'payment_modes')) -->

<script>
    $(document).ready(function () {
        $('#createLeadActivityForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('leads.activities.add', ['leadId' => $lead->id]) }}",
                method: 'POST',
                data: formData,
                processData: false, 
                contentType: false,
                success: function(response) {
                    successMsg('Lead Activity created successfully!');
                    location.reload();
                },
                error: function(xhr) {                   
                     errorMsg(xhr.responseJSON.message || 'An error occurred while creating the Lead Activity.');
                }
            });
        });


        $('input[name="product"]').on('change', function () {
            let productId = $(this).val();
            if(productId == '5') {
                // product_to_packages hide and remove required attribute
                $("#product_to_packages").hide();
                $(".package_lists").hide();
                $("#product_to_packages").attr('required', false);
                return;
            } else {
                $("#product_to_packages").show();
                $(".package_lists").show();
                $("#product_to_packages").attr('required', true);
            }
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

        $('#activity_status').on('change', function() {
            var selectedStatus = $(this).val();
            $('input[name="gst"]').attr('required', false);
            $('input[name="amount"]').attr('required', false);
            $('input[name="total"]').attr('required', false);
            $('select[name="payment_mode"]').attr('required', false);
            $('select[name="sales_type"]').attr('required', false);
            if(selectedStatus === 'Followup') {
                $('.product_lists').show();
                $('#product_to_packages').attr('required', true);
                $('.next_action_date_div').show();
                $('.description_div').show();
                $('.sales_fields').hide();
            } else if(selectedStatus === 'Invalid Number' || selectedStatus === 'Junk') {
                $('.product_lists').hide();
                $('.next_action_date_div').hide();
                $('.description_div').hide();
                $('.sales_fields').hide();
            } else if(selectedStatus === 'Closed'){
                $('.next_action_date_div').hide();
                $('.description_div').hide();
                $('.sales_fields').show();
                $('.product_lists').show();
                $('#product_to_packages').attr('required', true);
                $('input[name="gst"]').attr('required', true);
                $('input[name="amount"]').attr('required', true);
                $('input[name="total"]').attr('required', true);
                $('select[name="payment_mode"]').attr('required', true);
                $('select[name="sales_type"]').attr('required', true);
            } else {
                $('.product_lists').hide();
                $('#product_to_packages').attr('required', false);
                $('.next_action_date_div').show();
                $('.description_div').show();
                $('.sales_fields').hide();
            }
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
