@foreach($leads as $lead)
    <div class="col-xxl-3 col-xl-4 col-md-6">
        <div class="card border shadow">
            <div class="card-body">

                <!-- <div class="card-topbar mb-3 pt-1 bg-info"></div>
                <div class="card-topbar mb-3 pt-1 bg-secondary"></div> -->
                <div class="card-topbar mb-3 pt-1 bg-success"></div>
                <!-- <div class="card-topbar mb-3 pt-1 bg-danger"></div> -->

                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                    <div class="d-flex align-items-center">
                        <a href="{{ url('/leads/'.$lead->id) }}" class="avatar border rounded-circle flex-shrink-0 me-2">
                            <img src="{{ $lead->company->LogoUrl }}" class="w-auto h-auto" alt="img" style="max-width: 40px; max-height: 40px;">
                        </a>
                        <div>
                            <h6 class="fs-14">
                                <a href="{{ url('/leads/'.$lead->id) }}" class="fw-medium">
                                    {{ Str::limit($lead->name, 15) }}
                                </a>
                            </h6>
                            <div class="set-star text-default"> 
                                {{ Str::limit($lead->company->name, 15) }}
                            </div>
                        </div>
                    </div>
                    <div class="dropdown table-action">
                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item edit-user" data-id="{{ $lead->id }}" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                <i class="ti ti-edit text-blue"></i> Edit
                            </a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-id="{{ $lead->id }}" data-bs-target="#delete_contact">
                                <i class="ti ti-trash"></i> Delete
                            </a>
                            <a class="dropdown-item" href="{{ url('/leads/'.$lead->id) }}">
                                <i class="ti ti-eye text-blue-light"></i> Preview
                            </a>
                        </div>
                    </div>
                </div>

                <div class="d-block">
                    <div class="d-flex flex-column mb-0">
                        <p class="text-default d-inline-flex align-items-center mb-2">
                            <i class="ti ti-mail text-dark me-1"></i>{{ $lead->email }}
                        </p>
                        <p class="text-default d-inline-flex align-items-center mb-2">
                            <i class="ti ti-phone text-dark me-1"></i>{{ $lead->number ?? 'N/A' }}
                        </p>
                        <p class="text-default d-inline-flex align-items-center">
                            <i class="ti ti-map-pin-pin text-dark me-1"></i>{{ $lead->address ?? 'N/A' }}
                        </p>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                    <div class="d-flex align-items-center grid-social-links">
                        @if(!empty($lead->email))
                            <a href="mailto:{{ $lead->email }}" 
                            class="avatar avatar-xs text-dark rounded-circle me-1" 
                            title="Email {{ $lead->name }}">
                                <i class="ti ti-mail fs-14"></i>
                            </a>
                        @endif
                        @if(!empty($lead->number))
                            <a href="tel:{{ $lead->number }}" 
                            class="avatar avatar-xs text-dark rounded-circle me-1" 
                            title="Call {{ $lead->name }}">
                                <i class="ti ti-phone-check fs-14"></i>
                            </a>
                        @endif
                    </div>
                    <div> {{$lead->user->name}} </div>
                    <div>
                        <span class="avatar avatar-xs border-0">
                            <img src="{{ user_avatar($lead->user->name) }}"
                                class="rounded-circle" alt="{{ $lead->user->name }}">
                        </span>
                    </div>                                    
                </div>


            </div>
        </div>
    </div>
@endforeach
