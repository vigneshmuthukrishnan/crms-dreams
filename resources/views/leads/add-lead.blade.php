<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
    <div class="offcanvas-header border-bottom">
        <h5 class="mb-0">Add New Lead</h5>
        <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" enctype="multipart/form-data" id="createLeadForm">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Company Name<span class="text-danger">*</span></label>
                        <input type="hidden" class="form-control" name="company_name" value="" id="company_name_txt">
                        <select class="form-control select2 company_lists" name="company_id" id="company_name_sel" required>
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Lead name <span class="text-danger ms-1">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Lead Name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Customer name <span class="text-danger ms-1">*</span></label>
                        <input type="text" class="form-control" name="customer_name" placeholder="Enter Name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger ms-1">*</span></label>
                        <input type="text" class="form-control" name="email" placeholder="Enter Email" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Phone<span class="text-danger ms-1">*</span></label>
                        <input type="text" class="form-control phone" name="number" placeholder="Enter Phone Number" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="mb-2">
                    <label class="form-label">Product<span class="text-danger">*</span></label>
                        <ul class="radio-activity">
                            @foreach($products as $product)
                                <li class="me-2 mb-2">
                                    <div class="active-type">
                                        <input type="radio" id="product_{{ $product->id }}" name="product" value="{{ $product->id }}" checked>
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
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Packages <span class="text-danger ms-1">*</span></label>
                        <select class="form-control" data-toggle="select2" name="package" id="product_to_packages" required>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Date <span class="text-danger ms-1">*</span></label>
                        <input type="date" class="form-control" name="date" placeholder="Enter Date" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Lead Source <span class="text-danger ms-1">*</span></label>
                        <select class="form-control" data-toggle="select2" name="lead_source" required>
                            <option value="">Select</option>
                            @foreach($lead_sources as $source)
                                <option value="{{ $source }}" >{{ $source }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>                 
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Type <span class="text-danger ms-1">*</span></label>
                        <select class="form-control" data-toggle="select2" name="company_type" required>
                            <option value="" >Select</option>
                            @foreach($company_types as $type)
                                <option value="{{ $type }}" >{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>  
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Next Action Date <span class="text-danger ms-1">*</span></label>
                        <input type="date" class="form-control" name="next_action_date" placeholder="Enter Date">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger ms-1">*</span></label>
                        <select class="form-control" data-toggle="select2" name="status" required>
                            <option value="" >Select</option>
                            @foreach($lead_status as $status)
                                <option value="{{ $status }}" >{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>  
                <div class="col-md-12">
                    <div class="mb-00">
                        <label class="form-label">Description<span class="text-danger ms-1">*</span></label>
                        <textarea class="form-control" rows="3" name="remarks"></textarea>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-end mt-3">
                <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Cancel</button>
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal"  data-bs-target="#create_success">Create New</button>
            </div>
        </form>
    </div>
</div>


