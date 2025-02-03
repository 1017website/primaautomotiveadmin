<div class="col-sm-12" data-scroll="overflow-x" data-layout="report">
    <div id="rpt_dtl" class="table-responsive display" cellspacing="0" width="100%">
        @if(!empty($attendanceRecords))
        <table id="attendance" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">{{ __('Employee Name') }}</th>
                    <th rowspan="2">{{ __('Position') }}</th>
                    <th colspan="{{ $daysInMonth }}" class="text-center">
                        {{ \Carbon\Carbon::parse($month)->format('F Y') }}
                    </th>
                    <th rowspan="2">{{ __('Total Attendance') }}</th>
                </tr>
                <tr>
                    @for ($day = 1; $day <= $daysInMonth; $day++) <th>{{ $day }}</th>
                        @endfor
                </tr>
            </thead>
            <tbody>
                @foreach($attendanceRecords as $record)
                <tr>
                    <td>{{ $record['employee']->name }}</td>
                    <td>{{ $record['employee']->position }}</td>
                    @php
                    $totalAttendance = 0;
                    @endphp
                    @for ($day = 1; $day <= $daysInMonth; $day++) <td>
                        {{ $record['attendance'][$day] }}
                        @if($record['attendance'][$day] == '✓')
                        @php $totalAttendance++; @endphp
                        @endif
                        </td>
                        @endfor
                        <td class="text-center">{{ $totalAttendance }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="alert alert-danger" role="alert">
            No Data for this Month
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>
</div>