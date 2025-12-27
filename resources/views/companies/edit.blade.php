<form method="POST" enctype="multipart/form-data" id="updateCompanyForm">
    @csrf
    <input type="hidden" name="company_id" id="company_id" value="{{ $company->id }}">
    <div class="accordion accordion-bordered" id="main_accordion">
        <div class="accordion-item rounded mb-3">
            <div class="accordion-header">
                <a href="" class="accordion-button accordion-custom-button rounded" data-bs-toggle="collapse" data-bs-target="#basic">
                    <span class="avatar avatar-md rounded me-1"><i class="ti ti-user-plus"></i></span>
                    Basic Info
                </a>
            </div>
            <div class="accordion-collapse collapse show" id="basic" data-bs-parent="#main_accordion">
                <div class="accordion-body border-top">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-xxl border border-dashed me-3 flex-shrink-0">
                                    <div class="position-relative d-flex align-items-center">
                                        <i class="ti ti-photo text-dark fs-16"></i>
                                    </div>
                                </div>
                                <div class="d-inline-flex flex-column align-items-start">
                                    <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                        <i class="ti ti-file-broken me-1"></i>Upload file
                                        <input type="file" class="form-control image-sign" name="logo" accept="image/*" >
                                    </div>
                                    <span>JPG, GIF or PNG. Max size of 800K</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Company Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ $company->name }}" name="name" placeholder="Enter Company Name" required readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" value="{{ $company->email }}" name="email" placeholder="Enter Email" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone 1 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control phone" value="{{ $company->phone_1 }}" name="phone_1" placeholder="Enter Phone Number" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone 2</label>
                                <input type="text" class="form-control phone" value="{{ $company->phone_2 }}" name="phone_2" placeholder="Enter Phone Number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">GST</label>
                                <input type="text" class="form-control" value="{{ $company->fax }}" name="fax" placeholder="Enter GST">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Website</label>
                                <input type="text" class="form-control" value="{{ $company->website }}" name="website" placeholder="Enter Website URL">
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Customer Name</label>
                                <input type="text" class="form-control"  value="{{ $company->owner }}" name="owner" placeholder="Enter Owner Name">
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tags </label>
                                <input class="input-tags form-control" value="{{ $company->tags }}" name="tags" data-choices data-choices-limit="infinite" data-choices-removeitem type="text" placeholder="Enter value separated by comma" />
                            </div>
                        </div> -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Type <span class="text-danger ms-1">*</span></label>
                                <select class="form-control" data-toggle="select2" name="type" required>
                                    <option value="" >Select</option>
                                    @foreach($company_types as $type)
                                        <option value="{{ $type }}" {{ $company->type == $type ? 'selected' : ''}}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Source <span class="text-danger">*</span></label>
                                <select class="form-control" data-toggle="select2" name="source" required>
                                    <option>Select</option>
                                    @foreach($sources as $source)
                                        <option value="{{ $source }}" {{ $company->source == $source ? 'selected' : '' }}>{{ $source }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Industry <span class="text-danger">*</span></label>
                                <select class="form-control" name="industry" required>
                                    <option>Select</option>
                                    @foreach($industrys as $industry)
                                        <option value="{{ $industry }}" {{ $company->industry == $industry ? 'selected' : '' }}>{{ $industry }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-md-12">
                            <div class="mb-0">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" name="description">{{ $company->description }}</textarea>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion-item border-top rounded mb-3">
            <div class="accordion-header">
                <a href="#" class="accordion-button accordion-custom-button rounded" data-bs-toggle="collapse" data-bs-target="#address">
                    <span class="avatar avatar-md rounded me-1"><i class="ti ti-map-pin-cog"></i></span>
                    Address Info
                </a>
            </div>
            <div class="accordion-collapse collapse" id="address" data-bs-parent="#main_accordion">
                <div class="accordion-body border-top">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Street Address </label>
                                <input type="text" class="form-control" name="address" value="{{ $company->address }}" placeholder="Enter Street Address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Country</label>
                                <select class="form-control" name="country" id="editcountry">
                                    <option value="" >Select</option>
                                    <option value="India" {{ $company->country == 'India' ? 'selected' : '' }}>India</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">State</label>
                                <select class="form-control" name="state" id="editstate"></select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 mb-md-0">
                                <label class="form-label">City </label>
                                <select class="form-control" name="city" id="editcity">
                                    <option>Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-0">
                                <label class="form-label">Zipcode </label>
                                <input type="text" class="form-control" name="zipcode" value="{{ $company->zipcode }}" placeholder="Enter Zipcode">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="accordion-item border-top rounded mb-3">
            <div class="accordion-header">
                <a href="#" class="accordion-button accordion-custom-button rounded" data-bs-toggle="collapse" data-bs-target="#social">
                    <span class="avatar avatar-md rounded me-1"><i class="ti ti-social"></i></span>
                    Social Profile
                </a>
            </div>
            <div class="accordion-collapse collapse" id="social" data-bs-parent="#main_accordion">
                <div class="accordion-body border-top">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Facebook</label>
                                <input type="text" class="form-control" name="facebook_url" value="{{ $company->facebook_url }}" placeholder="Enter Facebook URL">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Linkedin </label>
                                <input type="text" class="form-control" name="linkedin_url" value="{{ $company->linkedin_url }}" placeholder="Enter Linkedin URL">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 mb-md-0">
                                <label class="form-label">Whatsapp</label>
                                <input type="text" class="form-control" name="whatsapp_url" value="{{ $company->whatsapp_url }}" placeholder="Enter Whatsapp URL">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-0">
                                <label class="form-label">Instagram</label>
                                <input type="text" class="form-control" name="instagram_url" value="{{ $company->instagram_url }}" placeholder="Enter Instagram URL">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <div class="d-flex align-items-center justify-content-end">
        <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Cancel</button>
        <button type="submit" class="btn btn-primary" data-bs-toggle="modal"  data-bs-target="#create_success">Update</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        let selectcountry = "{{ $company->country }}";
        let selectedState = "{{ $company->state }}";
        let selectcity = "{{ $company->city }}";

        $('select[name="country"]').val(selectcountry).trigger('change');
    });
    $(document).on('change', '#editcountry', function (e) {
        let country = $(this).val();
        if(country === "India"){
            $.ajax({
                url: "https://countriesnow.space/api/v0.1/countries/states",
                method: "POST",
                data: JSON.stringify({ country: country}),
                contentType: "application/json",
                success: function(response){
                    $("#editstate").empty().append('<option>Select State</option>');
                    let selectedState = "{{ $company->state }}";
                    $.each(response.data.states, function(index, state){
                        if(selectedState == state.name){
                            $("#editstate").append('<option value="'+state.name+'" selected>'+state.name+'</option>');
                        } else {
                            $("#editstate").append('<option value="'+state.name+'">'+state.name+'</option>');
                        }
                    });
                    loadCitiesForEdit();
                }
            });
        }
    });


    function loadCitiesForEdit(){
        let state = $('#editstate').val();
        $.ajax({
            url: "https://countriesnow.space/api/v0.1/countries/state/cities",
            method: "POST",
            data: JSON.stringify({ country: "India", state: state }),
            contentType: "application/json",
            success: function(response){
                $("#editcity").empty().append('<option>Select City</option>');
                let selectcity = "{{ $company->city }}";
                $.each(response.data, function(index, city){
                    if(selectcity == city){
                        $("#editcity").append('<option value="'+city+'" selected >'+city+'</option>');
                    } else {
                        $("#editcity").append('<option value="'+city+'">'+city+'</option>');
                    }
                });
            }
        });
    }    

</script>