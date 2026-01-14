<x-app-layout>
    <div class="content pb-0">

        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1">Calendar<span class="badge badge-soft-primary ms-2"></span></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Calendar</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="card border-0 rounded-0">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>    
    </div>
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="modalTitle" style="color: white;"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Date:</strong> <span id="modalDate"></span></p>
                    <p><strong>Phone:</strong> <span id="modalPhone"></span></p>
                    <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                    <p><strong>Created By:</strong> <span id="modalUser"></span></p>
                    <p class="mt-2"><strong>Remarks:</strong></p>
                    <p id="modalRemarks"></p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>



<script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
<script>
    var data = @json($data ?? []);
    console.log(data);
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        if (!calendarEl) return;
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: data,
            editable: true,
            selectable: true,
            eventClick: function(info) {
                let event = info.event;
                let props = event.extendedProps;

                document.getElementById('modalTitle').innerText = event.title;
                document.getElementById('modalDate').innerText  = props.follow_date;
                document.getElementById('modalPhone').innerText  = props.phone;
                document.getElementById('modalEmail').innerText  = props.email;
                document.getElementById('modalUser').innerText  = props.created_by;
                document.getElementById('modalRemarks').innerText =
                    props.remark || 'No remarks';

                new bootstrap.Modal(document.getElementById('eventModal')).show();
            }
        });
        calendar.render();
    });
</script>
