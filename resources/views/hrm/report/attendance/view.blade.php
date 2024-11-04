<div class="col-sm-12" data-scroll="overflow-x" data-layout="report">
    <div id="rpt_dtl" class="table-responsive display" cellspacing="0" width="100%">
        @if(!empty($attendanceRecords))
        <table id="attendance" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>{{ __('Employee Name') }}</th>
                    <th>{{ __('Position') }}</th>
                    <th>{{ __('Check In') }}</th>
                    <th>{{ __('Check Out') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendanceRecords as $record)
                <tr>
                    <td>{{ $record['employee']->name }}</td>
                    <td>{{ $record['employee']->position }}</td>
                    <td>{{ $record['check_in'] }}</td>
                    <td>{{ $record['check_out'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="alert alert-danger" role="alert">
            No Data for this Date
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>
</div>