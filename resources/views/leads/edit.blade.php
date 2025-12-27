<form method="POST" enctype="multipart/form-data" id="updateLeadForm">
    @csrf
    <input type="hidden" name="lead_id" id="lead_id" value="{{ $lead->id }}">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">Company Name<span class="text-danger">*</span></label>
                <input type="hidden" class="form-control" name="company_name" value="" id="company_name_txt" value="{{ $lead->company_name }}">
                <select class="form-control select2 company_lists" name="company_id" id="company_name_sel" required readonly>
                    <option value="">Select Company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ $company->name == $lead->company_name ? 'selected' : ''}}>{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Lead name <span class="text-danger ms-1">*</span></label>
                <input type="text" class="form-control" name="name" value="{{$lead->name}}" placeholder="Enter Lead Name"  required readonly>
            </div>
        </div> -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Date <span class="text-danger ms-1">*</span></label>
                <input type="date" class="form-control" name="date" placeholder="Enter Date" value="{{ date('Y-m-d', strtotime($lead->date)) }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Customer name <span class="text-danger ms-1">*</span></label>
                <input type="text" class="form-control" name="customer_name" value="{{$lead->customer_name}}" placeholder="Enter Name" required readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger ms-1">*</span></label>
                <input type="text" class="form-control" name="email" value="{{$lead->email}}" placeholder="Enter Email" required readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Phone<span class="text-danger ms-1">*</span></label>
                <input type="text" class="form-control phone" name="number" value="{{$lead->number}}" placeholder="Enter Phone Number" required>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-2">
            <label class="form-label">Product<span class="text-danger">*</span></label>
                <ul class="radio-activity">
                    @foreach($products as $product)
                        <li class="me-2 mb-2">
                            <div class="active-type">
                                <input type="radio" id="product_{{ $product->id }}" name="product" {{$product->id == $lead->plan ? 'checked' : ''}} value="{{ $product->id }}">
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
        <!-- <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Packages <span class="text-danger ms-1">*</span></label>
                <select class="form-control" data-toggle="select2" name="package" id="edit_product_to_packages" required>
                </select>
            </div>
        </div> -->

        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Lead Source <span class="text-danger ms-1">*</span></label>
                <select class="form-control" data-toggle="select2" name="lead_source" required>
                    <option value="">Select</option>
                    @foreach($lead_sources as $source)
                        <option value="{{ $source }}" {{ $lead->lead_source == $source ? 'selected' : ''}}>{{ $source }}</option>
                    @endforeach
                </select>
            </div>
        </div>                 
        <!-- <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Type <span class="text-danger ms-1">*</span></label>
                <select class="form-control" data-toggle="select2" name="company_type" required>
                    <option value="" >Select</option>
                    @foreach($company_types as $type)
                        <option value="{{ $type }}" {{ $lead->company_type == $type ? 'selected' : ''}}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div> -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Status <span class="text-danger ms-1">*</span></label>
                <select class="form-control" data-toggle="select2" name="status" required>
                    <option value="" >Select</option>
                    @foreach($lead_status as $status)
                        <option value="{{ $status }}" {{ $lead->status == $status ? 'selected' : ''}}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!--<div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">State</label>
                <select class="form-control" name="state" id="editstate"></select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3 mb-md-0">
                <label class="form-label">City </label>
                <select class="form-control" name="city" id="editcity"></select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">Description<span class="text-danger ms-1">*</span></label>
                <textarea class="form-control" rows="3" name="remarks">{{ $lead->remarks }}</textarea>
            </div>
        </div> -->
    </div>
    <div class="d-flex align-items-center justify-content-end mt-3">
        <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Cancel</button>
        <button type="submit" class="btn btn-primary" data-bs-toggle="modal"  data-bs-target="#create_success">Update</button>
    </div>
</form>


<script>
    $(document).ready(function(){
        let productId = $('input[name="product"]:checked').val();
        getPackage(productId);
    });
    function getPackage(productId)
    {
        setTimeout(() => {
            $.ajax({
                url: "{{ url('/packages-by-product') }}/" + productId,
                method: "GET",
                success: function (response) {
                    $("#edit_product_to_packages").html('<option value="">Select Package</option>');
                    const packageId = "{{$lead->package}}";
                    $.each(response, function (key, package) {
                        if(package.id == packageId){
                            $("#edit_product_to_packages").append('<option value="' + package.id + '" selected>' + package.quantity + '</option>');
                        } else {
                            $("#edit_product_to_packages").append('<option value="' + package.id + '">' + package.quantity + '</option>');
                        }
                    });
                }
            });
            // $.ajax({
            //     url: "https://countriesnow.space/api/v0.1/countries/states",
            //     method: "POST",
            //     data: JSON.stringify({ country: 'India'}),
            //     contentType: "application/json",
            //     success: function(response){
            //         $("#editstate").empty().append('<option value="">Select State</option>');
            //         let selectedState = "{{ $lead->state }}";
            //         $.each(response.data.states, function(index, state){
            //             if(selectedState == state.name){
            //                 $("#editstate").append('<option value="'+state.name+'" selected>'+state.name+'</option>');
            //             } else {
            //                 $("#editstate").append('<option value="'+state.name+'">'+state.name+'</option>');
            //             }
            //         });
            //         loadCitiesForEdit();
            //     }
            // });
        }, 500);
    }
    // $(document).on('change', '#editstate', function (e) {
    //     loadCitiesForEdit();
    // });
    function loadCitiesForEdit(){
        let state = $('#editstate').val();
        $.ajax({
            url: "https://countriesnow.space/api/v0.1/countries/state/cities",
            method: "POST",
            data: JSON.stringify({ country: "India", state: state }),
            contentType: "application/json",
            success: function(response){
                $("#editcity").empty().append('<option>Select City</option>');
                let selectcity = "{{ $lead->city }}";
                if(selectcity){
                    $.each(response.data, function(index, city){
                        if(selectcity == city){
                            $("#editcity").append('<option value="'+city+'" selected >'+city+'</option>');
                        } else {
                            $("#editcity").append('<option value="'+city+'">'+city+'</option>');
                        }
                    });
                } else {
                    $.each(response.data, function(index, city){
                        $("#editcity").append('<option value="'+city+'">'+city+'</option>');
                    });
                }
            }
        });
    }
</script>