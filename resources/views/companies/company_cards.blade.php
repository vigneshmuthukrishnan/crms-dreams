@foreach($companies as $company)
    <div class="col-xxl-3 col-xl-4 col-md-6">
        <div class="card border shadow">
            <div class="card-body">

                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                    <div class="d-flex align-items-center">
                        <a href="{{ url('/companies/'.$company->id) }}" class="avatar border rounded-circle flex-shrink-0 me-2">
                            <img src="{{ $company->LogoUrl }}" class="w-auto h-auto" alt="img" style="max-width: 40px; max-height: 40px;">
                        </a>
                        <div>
                            <h6 class="fs-14">
                                <a href="{{ url('/companies/'.$company->id) }}" class="fw-medium">
                                    {{ Str::limit($company->name, 15) }}
                                </a>
                            </h6>
                            <div class="set-star text-default"> 
                                <a href="{{ url('/companies/'.$company->id) }}">
                                    {{ Str::limit($company->owner, 15) }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown table-action">
                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item edit-company" data-id="{{ $company->id }}" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                <i class="ti ti-edit text-blue"></i> Edit
                            </a>
                            <a class="dropdown-item delete-company" href="#" data-bs-toggle="modal" data-id="{{ $company->id }}" data-bs-target="#delete_contact">
                                <i class="ti ti-trash"></i> Delete
                            </a>
                            <a class="dropdown-item" href="{{ url('/companies/'.$company->id) }}">
                                <i class="ti ti-eye text-blue-light"></i> Preview
                            </a>
                        </div>
                    </div>
                </div>

                <div class="d-block">
                    <div class="d-flex flex-column mb-0">
                        <p class="text-default d-inline-flex align-items-center mb-2">
                            <i class="ti ti-mail text-dark me-1"></i>{{ $company->email }}
                        </p>
                        <p class="text-default d-inline-flex align-items-center mb-2">
                            <i class="ti ti-phone text-dark me-1"></i>{{ $company->phone_1 ?? 'N/A' }}
                        </p>
                        <p class="text-default d-inline-flex align-items-center">
                            <i class="ti ti-map-pin-pin text-dark me-1"></i>{{ $company->address ?? 'N/A' }}
                        </p>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                    <div class="d-flex align-items-center grid-social-links">
                        @if(!empty($company->email))
                            <a href="mailto:{{ $company->email }}" 
                            class="avatar avatar-xs text-dark rounded-circle me-1" 
                            title="Email {{ $company->name }}">
                                <i class="ti ti-mail fs-14"></i>
                            </a>
                        @endif
                        @if(!empty($company->phone_1))
                            <a href="tel:{{ $company->phone_1 }}" 
                            class="avatar avatar-xs text-dark rounded-circle me-1" 
                            title="Call {{ $company->name }}">
                                <i class="ti ti-phone-check fs-14"></i>
                            </a>
                        @endif

                        @if(!empty($company->phone_1))
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $company->phone_1) }}" 
                            target="_blank"
                            class="avatar avatar-xs text-dark rounded-circle me-1" 
                            title="WhatsApp {{ $company->name }}">
                                <i class="ti ti-message-circle-share fs-14"></i>
                            </a>
                        @endif

                        @if(!empty($company->facebook))
                            <a href="{{ $company->facebook }}" 
                            target="_blank"
                            class="avatar avatar-xs text-dark rounded-circle" 
                            title="Facebook">
                                <i class="ti ti-brand-facebook fs-14"></i>
                            </a>
                        @endif
                    </div>

                    <div>
                        <span class="avatar avatar-xs border-0">
                            <img src="{{ user_avatar($company->creator->name) }}"
                                class="rounded-circle" alt="{{ $company->name }}">
                        </span>
                    </div>                                    
                </div>


            </div>
        </div>
    </div>
@endforeach
