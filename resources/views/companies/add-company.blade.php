<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
    <div class="offcanvas-header border-bottom">
        <h5 class="mb-0">Add New Company</h5>
        <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" enctype="multipart/form-data" id="createCompanyForm">
            @csrf
            <div class="accordion accordion-bordered" id="main_accordion">
                <div class="accordion-item rounded mb-3">
                    <div class="accordion-header">
                        <a href="#" class="accordion-button accordion-custom-button rounded" data-bs-toggle="collapse" data-bs-target="#basic">
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
                                        <input type="text" class="form-control" name="name" placeholder="Enter Company Name" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email <span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" name="email" placeholder="Enter Email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone 1 <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control phone" name="phone_1" placeholder="Enter Phone Number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone 2</label>
                                        <input type="text" class="form-control phone" name="phone_2" placeholder="Enter Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">GST</label>
                                        <input type="text" class="form-control" name="fax" placeholder="Enter GST">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Website</label>
                                        <input type="text" class="form-control" name="website" placeholder="Enter Website URL">
                                    </div>
                                </div>  
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Owner</label>
                                        <input type="text" class="form-control" name="owner" placeholder="Enter Owner Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tags </label>
                                        <input class="input-tags form-control" name="tags" data-choices data-choices-limit="infinite" data-choices-removeitem type="text" placeholder="Enter value separated by comma" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Source <span class="text-danger">*</span></label>
                                        <select class="form-control" data-toggle="select2" name="source" required>
                                            <option>Select</option>
                                            @foreach($sources as $source)
                                                <option value="{{ $source }}">{{ $source }}</option>
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
                                                <option value="{{ $industry }}">{{ $industry }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" name="description"></textarea>
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
                                        <input type="text" class="form-control" name="address" placeholder="Enter Street Address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Country</label>
                                        <select class="form-control" name="country" id="country">
                                            <option value="" >Select</option>
                                            <option value="India">India</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">State</label>
                                        <select class="form-control" name="state" id="state">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 mb-md-0">
                                        <label class="form-label">City </label>
                                        <select class="form-control" name="city" id="city">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-0">
                                        <label class="form-label">Zipcode </label>
                                        <input type="text" class="form-control" name="zipcode" placeholder="Enter Zipcode">
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
                                        <input type="text" class="form-control" name="facebook_url" placeholder="Enter Facebook URL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Linkedin </label>
                                        <input type="text" class="form-control" name="linkedin_url" placeholder="Enter Linkedin URL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 mb-md-0">
                                        <label class="form-label">Whatsapp</label>
                                        <input type="text" class="form-control" name="whatsapp_url" placeholder="Enter Whatsapp URL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-0">
                                        <label class="form-label">Instagram</label>
                                        <input type="text" class="form-control" name="instagram_url" placeholder="Enter Instagram URL">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="d-flex align-items-center justify-content-end">
                <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Cancel</button>
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal"  data-bs-target="#create_success">Create New</button>
            </div>
        </form>
    </div>
</div>