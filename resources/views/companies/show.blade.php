<x-app-layout>
    <div class="content pb-0">

        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <a href="{{ url('/companies') }}"><i class="ti ti-arrow-narrow-left me-1"></i>Back to Companies</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body pb-2">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar avatar-xxl avatar-rounded me-3 flex-shrink-0">
                                <img src="{{ $company->LogoUrl }}" alt="img">
                                <span class="status online"></span>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $company->name}}</h5>
                                <p class="mb-2"><i class="ti ti-map-pin-pin me-1"></i>{{ $company->address}}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            @if(!empty($company->email))
                                <a href="mailto:{{ $company->email }}" class="btn btn-primary">
                                    <i class="ti ti-mail me-1"></i>Send Email
                                </a>
                            @endif
                            <!-- <div class="act-dropdown">
                                <a href="#" data-bs-toggle="dropdown" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_contact"><i class="ti ti-edit-circle me-1"></i>Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash me-1"></i>Delete</a>
                                </div>
                            </div> -->
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
                                <p class="mb-0"><a href="mailto:{{ $company->email }}" class="__cf_email__" data-cfemail="d0bebfa6b1a7b1a6b590b7bdb1b9bcfeb3bfbd">{{ $company->email }}</a></p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-phone fs-14"></i>
                                </span>
                                <p class="mb-0">{{ $company->phone_1 ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-map-pin-pin fs-14"></i>
                                </span>
                                <p class="mb-0">{{ $company->address ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <span
                                    class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-calendar-exclamation fs-14"></i>
                                </span>
                                <p class="mb-0">
                                    Created on {{ $company->created_at->format('d M Y, h:i A') }}
                                </p>
                            </div>
                        </div>
                        <h6 class="mb-3 fw-semibold">Other Information</h6>
                        <ul class="border-bottom mb-3 pb-3">
                            <li class="row mb-2"><span class="col-6">
                                Last Modified</span><span class="col-6 text-dark">{{ $company->updated_at->format('d M Y, h:i A') }}</span>
                            </li>
                            <li class="row">
                                <span class="col-6">Source</span><span class="col-6 text-dark">{{ $company->source }}</span>
                            </li>
                            <li class="row">
                                <span class="col-6">Industry</span><span class="col-6 text-dark">{{ $company->industry }}</span>
                            </li>
                        </ul>
                        <h6 class="mb-3 fw-semibold">Tags</h6>
                        <div class="border-bottom mb-3 pb-3">
                            @php
                                $tags = explode(',', $company->tags);
                                $badgeColors = ['success', 'info', 'warning', 'danger', 'secondary'];
                            @endphp

                            @if(!empty($tags))
                                @foreach($tags as $tag)
                                    @php
                                        $randomColor = $badgeColors[array_rand($badgeColors)];
                                    @endphp
                                    <a href="javascript:void(0);" class="badge badge-soft-{{$randomColor}} fw-medium me-2">
                                        {{ trim($tag) }}
                                    </a>
                                @endforeach
                            @else
                                <span class="badge badge-tag badge-soft-secondary">No Tags</span>
                            @endif
                        </div>

                        <h6 class="mb-3 fw-semibold">Social Profile</h6>
                        <ul class="d-flex align-items-center">
                            <li>
                                <a href="javascript:void(0);" class="avatar avatar-sm rounded-circle fs-14 text-dark"><i class="ti ti-brand-youtube"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="avatar avatar-sm rounded-circle fs-14 text-dark"><i class="ti ti-brand-facebook"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="avatar avatar-sm rounded-circle fs-14 text-dark"><i class="ti ti-brand-instagram"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="avatar avatar-sm rounded-circle fs-14 text-dark"><i class="ti ti-brand-whatsapp"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="avatar avatar-sm rounded-circle fs-14 text-dark"><i class="ti ti-brand-pinterest"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="avatar avatar-sm rounded-circle fs-14 text-dark"><i class="ti ti-brand-linkedin"></i></a>
                            </li>
                        </ul>
                        <hr>
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
                                    <span class="d-md-inline-block"><i class="ti ti-chart-arcs me-1"></i>Leads</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content pt-0">

                    <!-- Leads -->
                    <div class="tab-pane active show" id="tab_1">
                        <div class="card">
                            <div
                                class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                <h5 class="fw-semibold mb-0">Leads</h5>
                            </div>
                            <div class="card-body">
                                @foreach($company->leads as $lead)

                                    <div class="card border shadow-none mb-3">
                                        <div class="card-body p-3">
                                            <div class="d-flex flex-wrap row-gap-2">
                                                <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-info">
                                                    <i class="ti ti-chart-arcs fs-20"></i>
                                                </span>
                                                <div>
                                                    <h6 class="fw-medium fs-14 mb-1">{{ $lead->name }}</h6>
                                                    <p class="mb-0">{{ $lead->created_at->format('d M Y, h:i A') }}</p>
                                                    <p class="mb-0"><strong>Status:</strong> {{ $lead->status }}
                                                    <p class="mb-0"><strong>Plan:</strong> {{ $lead->assigned_to }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /Tab Content -->

            </div>
            
        </div>

    </div>
</x-app-layout> 