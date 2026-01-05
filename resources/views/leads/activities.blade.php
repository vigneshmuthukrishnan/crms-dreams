    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add_activity">
        <div class="offcanvas-header border-bottom">
            <h5 class="mb-0">Add New Activity </h5>
            <button type="button"
                class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
                data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form method="POST" enctype="multipart/form-data" id="createLeadActivityForm">
                @csrf
                <div>
                    <div class="row">
                        <!-- <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div> -->
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label class="form-label">Activity Type<span
                                        class="text-danger">*</span></label>
                                <ul class="radio-activity">
                                    <li class="me-2 mb-2">
                                        <div class="active-type">
                                            <input type="radio" id="call" name="activity_type" value="call" checked="">
                                            <label for="call" class="rounded"><i class="ti ti-phone me-2"></i>Calls</label>
                                        </div>
                                    </li>
                                    <li class="me-2 mb-2">
                                        <div class="active-type">
                                            <input type="radio" id="message" name="activity_type" value="message">
                                            <label for="message" class="rounded"><i class="ti ti-message me-2"></i>Messages</label>
                                        </div>
                                    </li>
                                    <li class="me-2 mb-2">
                                        <div class="active-type">
                                            <input type="radio" id="mail" name="activity_type" value="email">
                                            <label for="mail" class="rounded"><i class="ti ti-mail me-2"></i>Email</label>
                                        </div>
                                    </li>
                                    <li class="me-2 mb-2">
                                        <div class="active-type">
                                            <input type="radio" id="task" name="activity_type" value="task">
                                            <label for="task" class="rounded"><i class="ti ti-subtask me-2"></i>Task</label>
                                        </div>
                                    </li>
                                    <li class="me-2 mb-2">
                                        <div class="active-type">
                                            <input type="radio" id="meeting" name="activity_type" value="meeting">
                                            <label for="meeting" class="rounded"><i class="ti ti-user-share me-2"></i>Meeting</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <div class="input-group w-auto input-group-flat">
                                    <input type="date" name="date" class="form-control" data-provider="flatpickr" placeholder="dd/mm/yyyy">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Time <span class="text-danger">*</span></label>
                                <div class="input-icon-end position-relative">
                                    <input type="time" name="time" class="form-control form-control" name="time" data-provider="timepickr" data-time-basic="true" placeholder="-- : -- : --">
                                </div>
                            </div>
                        </div> -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" data-toggle="select2" name="status" required id="activity_status">
                                    <option value="" >Select</option>
                                    @foreach($lead_status as $status)
                                        <option value="{{ $status }}" >{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 next_action_date_div">
                            <div class="mb-3">
                                <label class="form-label">Next Action Date <span class="text-danger">*</span></label>
                                <div class="input-group w-auto input-group-flat">
                                    <input type="date" name="next_action_date" class="form-control" placeholder="dd/mm/yyyy">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 product_lists" style="display:none;">
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
                        <div class="col-md-6 product_lists" style="display:none;">
                            <div class="mb-3">
                                <label class="form-label">Packages <span class="text-danger ms-1">*</span></label>
                                <select class="form-control" data-toggle="select2" name="package" id="product_to_packages">
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 description_div">
                            <div class="mb-00">
                                <label class="form-label">Description<span class="text-danger ms-1">*</span></label>
                                <textarea class="form-control" rows="3" name="remarks"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row sales_fields mb-3" style="display:none;"> 
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                        <input type="hidden" name="company_id" value="{{ $lead->company_id }}">                      
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Type <span class="text-danger">*</span></label>
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
                                <label class="form-label">Paymode <span class="text-danger">*</span></label>
                                <select name="payment_mode" class="form-select">
                                    <option value="">Select Paymode</option>
                                    @foreach($payment_modes as $mode)
                                        <option value="{{ $mode }}">{{ $mode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">GST <span class="text-danger">*</span></label>
                            <input type="number" name="gst" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total <span class="text-danger">*</span></label>
                            <input type="number" name="total" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="d-flex align-items-center justify-content-end mt-3">
                    <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create New</button>
                </div>
            </form>
        </div>
    </div>