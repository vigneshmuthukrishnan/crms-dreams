<div class="card-body">
    <div class="badge badge-soft-info border-0 mb-3"><i class="ti ti-calendar-check me-1"></i>
        {{ date("d/m/Y", strtotime($activity->created_at)) ?? N/A }}
    </div>
    @if($activity->type == 'message')
        <!-- <div class="card border shadow-none mb-3">
            <div class="card-body p-3">
                <div class="d-flex flex-wrap row-gap-2">
                    <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-info">
                        <i class="ti ti-mail-code fs-20"></i>
                    </span>
                    <div>
                        <h6 class="fw-medium fs-14 mb-1">You sent Message to the contact.</h6>
                        <p class="mb-0">{{ date("h:i A", strtotime($activity->time)) ?? N/A }}</p>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="card border shadow-none mb-3">
            <div class="card-body p-3">
                <div class="d-flex flex-lg-nowrap flex-wrap row-gap-2">
                    <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-danger">
                        <i class="ti ti-notes fs-20"></i>
                    </span>
                    <div>
                        <h6 class="fw-medium fs-14 mb-1">Notes</h6>
                        <p class="mb-1">{{ $activity->remark }} </p>
                        <p class="mb-0">{{ date("h:i A", strtotime($activity->time)) ?? N/A }}</p>
                    </div>
                </div>
            </div>
        </div>
    @elseif($activity->type == 'call')
        <!-- <div class="card border shadow-none mb-3">
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
        </div> -->
        <div class="card border shadow-none mb-3">
            <div class="card-body p-3">
                <div class="d-flex flex-lg-nowrap flex-wrap row-gap-2">
                    <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-danger">
                        <i class="ti ti-notes fs-20"></i>
                    </span>
                    <div>
                        <h6 class="fw-medium fs-14 mb-1">Notes</h6>
                        <p class="mb-1">{{ $activity->remark }} </p>
                        <p class="mb-0">{{ date("h:i A", strtotime($activity->time)) ?? N/A }}</p>
                    </div>
                </div>
            </div>
        </div>
    @elseif($activity->type == 'meeting')
        <!-- <div class="card border shadow-none mb-3">
            <div class="card-body p-3">
                <div class="d-flex flex-wrap row-gap-2">
                    <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-warning">
                        <i class="ti ti-user-pin fs-20"></i>
                    </span>
                    <div>
                        <h6 class="fw-medium fs-14 mb-1">You have scheduled a meeting: {{ $activity->name }} </h6>
                        <p class="mb-0">{{ date("h:i A", strtotime($activity->time)) ?? N/A }}</p> 
                    </div>
                </div>
            </div>
        </div> -->
        <div class="card border shadow-none mb-3">
            <div class="card-body p-3">
                <div class="d-flex flex-lg-nowrap flex-wrap row-gap-2">
                    <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-danger">
                        <i class="ti ti-notes fs-20"></i>
                    </span>
                    <div>
                        <h6 class="fw-medium fs-14 mb-1">Notes</h6>
                        <p class="mb-1">{{ $activity->remark }} </p>
                        <p class="mb-0">{{ date("h:i A", strtotime($activity->time)) ?? N/A }}</p>
                    </div>
                </div>
            </div>
        </div>
    @elseif($activity->type == 'mail')
        <!-- <div class="card border shadow-none mb-3">
            <div class="card-body p-3">
                <div class="d-flex flex-wrap row-gap-2">
                    <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-primary">
                        <i class="ti ti-mail fs-20"></i>
                    </span>
                    <div>
                        <h6 class="fw-medium fs-14 mb-1">You sent Email to the contact.</h6>
                        <p class="mb-0">{{ date("h:i A", strtotime($activity->time)) ?? N/A }}</p>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="card border shadow-none mb-3">
            <div class="card-body p-3">
                <div class="d-flex flex-lg-nowrap flex-wrap row-gap-2">
                    <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-danger">
                        <i class="ti ti-notes fs-20"></i>
                    </span>
                    <div>
                        <h6 class="fw-medium fs-14 mb-1">Notes</h6>
                        <p class="mb-1">{{ $activity->remark }} </p>
                        <p class="mb-0">{{ date("h:i A", strtotime($activity->time)) ?? N/A }}</p>
                    </div>
                </div>
            </div>
        </div>
    @elseif($activity->type == 'task')
        <!-- <div class="card border shadow-none mb-3">
            <div class="card-body p-3">
                <div class="d-flex flex-wrap row-gap-2">
                    <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-secondary">
                        <i class="ti ti-check fs-20"></i>
                    </span>
                    <div>
                        <h6 class="fw-medium fs-14 mb-1">You created a task: {{ $activity->name }} </h6>
                        <p class="mb-0">{{ date("h:i A", strtotime($activity->time)) ?? N/A }}</p>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="card border shadow-none mb-3">
            <div class="card-body p-3">
                <div class="d-flex flex-lg-nowrap flex-wrap row-gap-2">
                    <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-danger">
                        <i class="ti ti-notes fs-20"></i>
                    </span>
                    <div>
                        <h6 class="fw-medium fs-14 mb-1">Notes</h6>
                        <p class="mb-1">{{ $activity->remark }} </p>
                        <p class="mb-0">{{ date("h:i A", strtotime($activity->time)) ?? N/A }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>





    <!-- <div class="badge badge-soft-info border-0 mb-3"><i class="ti ti-calendar-check me-1"></i>Upcoming Activity</div>
    <h5 class="fw-semibold mb-0">Upcoming Activity</h5>
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
    </div> -->