<x-app-layout>
    <div class="content pb-0">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <h6><a href="{{ route('sms-leads.index') }}"><i class="ti ti-arrow-narrow-left me-1"></i>Back to SMS Leads</a></h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body pb-2">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar avatar-xxl avatar-rounded me-3 flex-shrink-0">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="ti ti-message-circle fs-24"></i>
                                </span>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $smsLead->name ?? 'N/A' }}</h5>
                                <p class="mb-1">{{ $smsLead->looking_for ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            @if(!empty($smsLead->phone))
                                <a href="tel:{{ $smsLead->phone }}" class="btn btn-primary">
                                    <i class="ti ti-phone me-1"></i>Call
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body p-3">
                        <h6 class="mb-3 fw-semibold">Basic Information</h6>
                        <div class="border-bottom mb-3 pb-3">
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-phone fs-14"></i>
                                </span>
                                <p class="mb-0">{{ $smsLead->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-search fs-14"></i>
                                </span>
                                <p class="mb-0">{{ $smsLead->looking_for ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-shield-check fs-14"></i>
                                </span>
                                <p class="mb-0">{{ $smsLead->verification ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-calendar-exclamation fs-14"></i>
                                </span>
                                <p class="mb-0">Created on {{ optional($smsLead->created_at)->format('d M Y, h:i A') ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <!-- <h6 class="mb-3 fw-semibold">Status</h6>
                        <form id="updateSmsLeadStatusForm">
                            @csrf
                            <select class="form-control mb-3" name="status" id="sms_lead_status">
                                <option value="open" {{ strtolower($smsLead->status ?? 'open') === 'open' ? 'selected' : '' }}>Open</option>
                                <option value="closed" {{ strtolower($smsLead->status ?? '') === 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>Update Status
                            </button>
                        </form> 

                        <hr>-->
                        @if($smsLead->status == 'open')
                        <h6 class="mb-3 fw-semibold">Assign User</h6>
                        <form id="assignSmsLeadUserForm">
                            @csrf
                            <select class="form-control mb-3" name="user_id" id="sms_lead_user_id">
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}{{ $user->email ? ' - '.$user->email : '' }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-user-check me-1"></i>Assign User
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="fw-semibold mb-0">Lead Details</h5>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li class="row mb-2">
                                <span class="col-4">Name</span>
                                <span class="col-8 text-dark">{{ $smsLead->name ?? 'N/A' }}</span>
                            </li>
                            <li class="row mb-2">
                                <span class="col-4">Phone</span>
                                <span class="col-8 text-dark">{{ $smsLead->phone ?? 'N/A' }}</span>
                            </li>
                            <li class="row mb-2">
                                <span class="col-4">Email</span>
                                <span class="col-8 text-dark">{{ $smsLead->email ?? 'N/A' }}</span>
                            </li>
                            <li class="row mb-2">
                                <span class="col-4">Compnay</span>
                                <span class="col-8 text-dark">{{ $smsLead->company_name ?? 'N/A' }}</span>
                            </li>
                            <li class="row mb-2">
                                <span class="col-4">Looking For</span>
                                <span class="col-8 text-dark">{{ $smsLead->looking_for ?? 'N/A' }}</span>
                            </li>
                            <li class="row mb-2">
                                <span class="col-4">OTP Status</span>
                                <span class="col-8 text-dark">{{ $smsLead->verification ? 'Verification' : 'Not Verification' }}</span>
                            </li>
                            <li class="row">
                                <span class="col-4">Created Data & time</span>
                                <span class="col-8 text-dark">{{ optional($smsLead->created_at)->format('d M Y, h:i A') ?? 'N/A' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function () {
        $('#updateSmsLeadStatusForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('sms-leads.status', $smsLead->id) }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    status: $('#sms_lead_status').val()
                },
                success: function (response) {
                    successMsg(response.message || 'Status updated successfully!');
                },
                error: function (xhr) {
                    errorMsg(xhr.responseJSON.message || 'An error occurred while updating status.');
                }
            });
        });

        $('#assignSmsLeadUserForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('sms-leads.assign', $smsLead->id) }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: $('#sms_lead_user_id').val()
                },
                success: function (response) {
                    successMsg(response.message || 'SMS lead assigned successfully!');
                    window.location.href = "{{ route('sms-leads.index') }}";
                },
                error: function (xhr) {
                    errorMsg(xhr.responseJSON.message || 'An error occurred while assigning user.');
                }
            });
        });
    });
</script>
