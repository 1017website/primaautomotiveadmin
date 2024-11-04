<div class="col-sm-12" data-scroll="overflow-x" data-layout="report">
    <div id="rpt_dtl" class="table-responsive display" cellspacing="0" width="100%">
        @if($attendanceData->isNotEmpty())
        <table id="attendance" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>{{ __('Employee Name') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Time') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Type') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendanceData as $attendance)
                <tr>
                    <td>{{ $attendance->employee->name }}</td>
                    <td>{{ $attendance->date }}</td>
                    <td>{{ $attendance->time }}</td>
                    <td>{{ $attendance->status }}</td>
                    <td>{{ $attendance->type }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="alert alert-danger" role="alert">
            No Data in this Date
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>
</div>