<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Hrm') }}</a></li>
                            <li class="breadcrumb-item"><a href="/attendance">{{ __('Attendance') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Report') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#export_excel">{{ __('Export
                to Excel') }}</button>
        </div>

        <!-- Modal for Export -->
        <div class="modal fade" id="export_excel" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportModalLabel">{{ __('Export Attendance Report') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('exportAttendance') }}" method="POST">
                            @csrf
                            <input type="hidden" name="date" value="{{ request('date') }}">
                            <input type="hidden" name="status" value="{{ request('status') }}">

                            <p>{{ __('Are you sure you want to export the attendance report for this date?') }}</p>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel')
                                    }}</button>
                                <button type="submit" class="btn btn-default">{{ __('Export') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Report Attendance') }}</h5>
                <div class="border-top"></div>
                <div class="table-responsive">
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
                </div>

            </div>
        </div>

    </div>

</x-app-layout>