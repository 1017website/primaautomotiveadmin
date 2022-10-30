<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Hrm') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Attendance') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('attendance.create') }}">{{ __('Manual') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Attendance') }}</h5>
                <div class="border-top"></div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {!! $message !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="table-responsive">
                    <table id="attendance" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Time') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Type') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendance as $row)
                            <tr>
                                <td>{{ isset($row->employee) ? $row->employee->name : '-' }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                <td>{{ $row->time }}</td>
                                <td>{{ $row->status }}</td>
                                <td>{{ $row->type }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <script>
        $('#attendance').DataTable();
    </script>


</x-app-layout>