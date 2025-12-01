<x-app-layout>
    <div class="content pb-0">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1">Leads<span class="badge badge-soft-primary ms-2">{{$leadCount}}</span></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Leads</li>
                    </ol>
                </nav>
            </div>
            <div class="gap-2 d-flex align-items-center flex-wrap">
            </div>
        </div>  

        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <a href="{{ url('/leads') }}"><i class="ti ti-arrow-narrow-left me-1"></i>Back to Companies</a>
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
                                <h5 class="mb-1">{{ $lead->name}}</h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <a href="#" class="avatar avatar-sm border shadow text-dark"><i class="ti ti-star-filled fs-16 text-warning"></i></a>
                            @if(!empty($lead->email))
                                <a href="mailto:{{ $lead->email }}" class="btn btn-primary">
                                    <i class="ti ti-mail me-1"></i>Send Email
                                </a>
                            @endif
                            <a href="" class="action-icon btn btn-icon btn-sm btn-outline-light shadow">
                                <i class="ti ti-brand-hipchat"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit-circle"></i></a>
                            <div class="act-dropdown">
                                <a href="#" data-bs-toggle="dropdown" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash me-1"></i>Delete</a>
                                </div>
                            </div>
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
                                <p class="mb-0">{{ $lead->state ?? 'N/A' }}</p>
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
                                <p class="mb-0">{{ $lead->bulkSmsPackage->package_name }}</p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-message fs-14"></i>
                                </span>
                                <p class="mb-0">{{ $lead->bulkSmsPackage->sms_count }} SMS</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <span
                                    class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-currency-dollar fs-14"></i>
                                </span>
                                <p class="mb-0">
                                    {{ number_format($lead->bulkSmsPackage->price, 2) }}
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
                            <!-- <li class="nav-item" role="presentation">
                                <a href="#tab_2" data-bs-toggle="tab" aria-expanded="true" class="nav-link border-3" aria-selected="false" role="tab" tabindex="-1">
                                    <span class="d-md-inline-block"><i class="ti ti-notes me-1"></i>Notes</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tab_3" data-bs-toggle="tab" aria-expanded="false" class="nav-link border-3" aria-selected="false" tabindex="-1" role="tab">
                                    <span class="d-md-inline-block"><i class="ti ti-phone me-1"></i>Calls</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tab_4" data-bs-toggle="tab" aria-expanded="false" class="nav-link border-3" aria-selected="false" tabindex="-1" role="tab">
                                    <span class="d-md-inline-block"><i class="ti ti-file me-1"></i>Files</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tab_5" data-bs-toggle="tab" aria-expanded="false" class="nav-link border-3" aria-selected="false" tabindex="-1" role="tab">
                                    <span class="d-md-inline-block"><i class="ti ti-mail-check me-1"></i>Email</span>
                                </a>
                            </li> -->
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
                                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add_activity"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add New Activity</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="badge badge-soft-info border-0 mb-3"><i class="ti ti-calendar-check me-1"></i>28 May 2025</div>
                                <div class="card border shadow-none mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex flex-wrap row-gap-2">
                                            <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-info">
                                                <i class="ti ti-mail-code fs-20"></i>
                                            </span>
                                            <div>
                                                <h6 class="fw-medium fs-14 mb-1">You sent 1 Message to the contact.</h6>
                                                <p class="mb-0">10:25 pm</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border shadow-none mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex flex-wrap row-gap-2">
                                            <span
                                                class="avatar avatar-md flex-shrink-0 rounded me-2 bg-success">
                                                <i class="ti ti-phone fs-20"></i>
                                            </span>
                                            <div>
                                                <h6 class="fw-medium fs-14 mb-1">Denwar responded to your appointment schedule question by call at 09:30pm.</h6>
                                                <p class="mb-0">09:25 pm</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border shadow-none mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex flex-lg-nowrap flex-wrap row-gap-2">
                                            <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-danger">
                                                <i class="ti ti-notes fs-20"></i>
                                            </span>
                                            <div>
                                                <h6 class="fw-medium fs-14 mb-1">Notes added by Antony</h6>
                                                <p class="mb-1">Please accept my apologies for the inconvenience
                                                    caused. It would be much appreciated if it's possible to
                                                    reschedule to 6:00 PM, or any other day that week.
                                                </p>
                                                <p class="mb-0">10.00 pm</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="badge badge-soft-info border-0 mb-3"><i class="ti ti-calendar-check me-1"></i>27 May 2025</div>
                                <div class="card border shadow-none mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex flex-wrap row-gap-2">
                                            <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-warning">
                                                <i class="ti ti-user-pin fs-20"></i>
                                            </span>
                                            <div>
                                                <h6 class="fw-medium mb-1 d-inline-flex align-items-center fs-14 flex-wrap">Meeting With <span class="avatar avatar-xs rounded mx-2"><img src="assets/img/profiles/avatar-19.jpg" alt="img"></span> Abraham</h6>
                                                <p class="mb-0">Schedueled on 05:00 pm</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border shadow-none mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex flex-wrap row-gap-2">
                                            <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-teal">
                                                <i class="ti ti-notes fs-20"></i>
                                            </span>
                                            <div>
                                                <h6 class="fw-medium fs-14 mb-1">Drain responded to your appointment schedule question.</h6>
                                                <p class="mb-0">09:25 pm</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="badge badge-soft-info border-0 mb-3"><i class="ti ti-calendar-check me-1"></i>Upcoming Activity</div>
                                <div class="card border shadow-none mb-0">
                                    <div class="card-body p-3">
                                        <div class="d-flex flex-lg-nowrap flex-wrap row-gap-2">
                                            <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-warning">
                                                <i class="ti ti-user-pin fs-20"></i>
                                            </span>
                                            <div>
                                                <h6 class="fw-medium fs-14 mb-1">Product Meeting</h6>
                                                <p class="mb-1">A product team meeting is a gathering of the
                                                    cross-functional product team — ideally including team
                                                    members from product, engineering, marketing, and customer
                                                    support.</p>
                                                <p>25 Jul 2023, 05:00 pm</p>
                                                <div class="card mb-0">
                                                    <div class="card-body">
                                                        <div class="row gy-3">
                                                            <div class="col-md-4">
                                                                <div>
                                                                    <label class="form-label">Reminder <span class="text-danger">*</span></label>
                                                                    <select class="select">
                                                                        <option>Select</option>
                                                                        <option selected>1 hr</option>
                                                                        <option>Remainder</option>
                                                                        <option>10hr</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div>
                                                                    <label class="form-label">Task Priority <span class="text-danger">*</span></label>
                                                                    <select class="select">
                                                                        <option>Select</option>
                                                                        <option selected>High</option>
                                                                        <option>Low</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div>
                                                                    <label class="form-label">Assigned To <span class="text-danger">*</span></label>
                                                                    <select class="select">
                                                                        <option>Select</option>
                                                                        <option selected>Jerald Sen</option>
                                                                        <option>Jackson Daniel</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Activities -->
                </div>
            </div>            
        </div>
    </div>
</x-app-layout>

@include('leads.activities')