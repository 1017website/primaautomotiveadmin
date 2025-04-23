<x-app-layout>
    <style>
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background-color: #dee2e6;
        }

        .day-header,
        .day-cell {
            background: #fff;
            padding: .75rem .5rem;
            text-align: center;
            min-height: 80px;
            font-size: .9rem;
        }

        .day-header {
            background-color: #f1f3f5;
            font-weight: 600;
        }

        .day-cell.empty {
            background-color: #e9ecef;
        }

        .modal.right .modal-dialog {
            position: fixed;
            margin: auto;
            width: 500px;
            height: 100%;
            top: 0;
            right: 0;
            transform: translate3d(0, 0, 0);
        }

        .modal.right .modal-content {
            height: 100%;
            border: none;
            border-radius: 0;
        }

        .modal.right.fade .modal-dialog {
            right: -300px;
            transition: all 0.3s ease-out;
        }

        .modal.right.fade.show .modal-dialog {
            right: 0;
        }
    </style>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Hrm') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Calendar Events') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <button type="button" class="btn btn-sm btn-default note-btn" data-toggle="modal" data-target="#noteModal">
                +
            </button>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Calendar Events') }}</h5>
                <div class="border-top"></div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {!! $message !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if($message = Session::get('error'))
                <div class="alert alert-warning" role="alert">
                    {!! $message !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @php
                $year = request('year', \Carbon\Carbon::now()->year);
                $month = request('month', \Carbon\Carbon::now()->month);
                $current = \Carbon\Carbon::create($year, $month, 1);

                $dayNames = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
                $startDay = $current->dayOfWeek;
                $daysInMonth = $current->daysInMonth;

                $prev = $current->copy()->subMonth();
                $next = $current->copy()->addMonth();
                @endphp

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="?year={{ $prev->year }}&month={{ $prev->month }}" class="btn btn-sm btn-default">
                        &laquo; {{ $prev->format('M Y') }}
                    </a>

                    <h5 class="mb-0">{{ $current->format('F Y') }}</h5>

                    <a href="?year={{ $next->year }}&month={{ $next->month }}" class="btn btn-sm btn-default">
                        {{ $next->format('M Y') }} &raquo;
                    </a>
                </div>

                <div class="calendar-grid mb-4">
                    @foreach($dayNames as $dn)
                    <div class="day-header">{{ $dn }}</div>
                    @endforeach

                    @for($i = 0; $i < $startDay; $i++) <div class="day-cell empty">
                </div>
                @endfor

                @for($d = 1; $d <= $daysInMonth; $d++) @php $dateString=$current->format('Y-m-') . str_pad($d, 2, '0',
                    STR_PAD_LEFT);
                    $dayEvents = $notes->get($dateString, collect());
                    @endphp

                    <div class="day-cell" data-date="{{ $dateString }}">
                        <div class="date-number">{{ $d }}</div>

                        @foreach($dayEvents as $event)
                        @php
                        $colorMap = [
                        'blue' => '#039BE5','red' => '#D50000','green' => '#33B679',
                        'yellow' => '#F6BF26','purple' => '#7986CB','orange' => '#F4511E',
                        'gray' => '#616161',
                        ];
                        $hex = $colorMap[$event->color] ?? '#1f2937';
                        @endphp

                        <div class="event-title px-2 py-1 my-1 w-100 text-truncate"
                            style="background: {{ $hex }}; color: #fff; font-weight:600; cursor:pointer; border-radius:5px"
                            data-id="{{ $event->id }}" data-date="{{ $dateString }}" data-title="{{ e($event->title) }}"
                            data-description="{{ e($event->description) }}" data-color="{{ $event->color }}">
                            {{ $event->title }}
                        </div>
                        @endforeach
                    </div>
                    @endfor
            </div>
        </div>
    </div>
    </div>

    <div class="modal right fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('calendar.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="noteModalLabel">Add Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="date" id="note-date">
                    <div class="form-group">
                        <label for="note-title">Title</label>
                        <input type="text" name="title" id="note-title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="note-date">Date</label>
                        <input type="date" name="date" id="note-date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="note-description">Description</label>
                        <textarea name="description" id="note-description" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="color">Color</label>
                        @php
                        $circleMap = [
                        'blue' => '🔵',
                        'red' => '🔴',
                        'green' => '🟢',
                        'yellow' => '🟡',
                        'purple' => '🟣',
                        'orange' => '🟠',
                        'gray' => '⚫',
                        'none' => '◯',
                        ];
                        @endphp

                        <select class="form-control" name="color">
                            @foreach($circleMap as $key => $emoji)
                            <option value="{{ $key }}">
                                {{ $emoji }} {{ ucfirst($key) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-default">Save Note</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal right fade" id="eventModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="eventForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Event Detail</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="eventId">

                    <div class="form-group">
                        <label for="eventTitleInput">Title</label>
                        <input type="text" class="form-control" id="eventTitleInput" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="eventDateInput">Date</label>
                        <input type="date" class="form-control" id="eventDateInput" name="date" required>
                    </div>

                    <div class="form-group">
                        <label for="eventDescriptionInput">Description</label>
                        <textarea class="form-control" id="eventDescriptionInput" name="description"
                            rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="eventColorInput">Color</label>
                        @php
                        $circleMap = [
                        'blue' => '🔵',
                        'red' => '🔴',
                        'green' => '🟢',
                        'yellow' => '🟡',
                        'purple' => '🟣',
                        'orange' => '🟠',
                        'gray' => '⚫',
                        'none' => '◯',
                        ];
                        @endphp

                        <select class="form-control" id="eventColorInput" name="color">
                            @foreach($circleMap as $key => $emoji)
                            <option value="{{ $key }}">
                                {{ $emoji }} {{ ucfirst($key) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="deleteEventBtn">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this note?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script>
        const colorMap = {
            blue:   '#039BE5', red:    '#D50000', green:  '#33B679',
            yellow: '#F6BF26', purple: '#7986CB', orange: '#F4511E',
            gray:   '#616161', none:   '#1f2937'
        };

        $(function(){
            $('.event-title').on('click', function(){
            const $b = $(this);
            const id    = $b.data('id');
            const date  = $b.data('date');

            function htmlDecode(input) {
                const e = document.createElement('textarea');
                e.innerHTML = input;
                return e.value;
            }

            const title = htmlDecode($b.data('title'));
            const desc  = htmlDecode($b.data('description'));
            const color = $b.data('color');

            $('#eventId').val(id);
            $('#eventDateInput').val(date);
            $('#eventTitleInput').val(title);
            $('#eventDescriptionInput').val(desc);
            $('#eventColorInput').val(color);

            $('.modal.right .modal-header')
                .css('border-left','6px solid '+ (colorMap[color]||'#333') );

            $('#eventModal').modal('show');
            });

            $('#eventForm').on('submit', function(e){
            e.preventDefault();
            let data = $(this).serialize();
            const id = $('#eventId').val();
            const url  = `/calendar/events/${id}`;

            $.ajax({
                url: url,  
                method: 'PUT',
                data,
                success(resp){
                    if(resp.reload){
                        location.reload();
                    }
                },
                error(err){
                alert('Failed to save.'); console.error(err);
                }
            });
            });
        });
    </script>
    <script>
        $(function(){
            let deletingId = null;

            $('#deleteEventBtn').on('click', function () {
                deletingId = $('#eventId').val();
                $('#deleteConfirmModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function(e){
                console.log('you here dude?');
                e.preventDefault();
                let data = $(this).serialize();
                const id = deletingId;
                const url  = `/calendar/events`;

                $.ajax({
                    url: url,  
                    method: 'DELETE',
                    data: {
                        'id': id,
                    },
                    success(resp){
                        if(resp.reload){
                            location.reload();
                        }
                    },
                    error(err){
                    alert('Failed to save.'); console.error(err);
                    }
                });
            });
        });
    </script>

</x-app-layout>