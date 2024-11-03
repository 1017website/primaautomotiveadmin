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
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_import">{{ __('Get Data') }}</button>
            <a class="btn btn-default hidden" href="{{ route('attendance.import') }}">{{ __('Import Excel') }}</a>
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
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendance as $row)
                            <tr>
                                <td>{{ isset($row->employee) ? $row->employee->name : '-' }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                <td>{{ $row->time }}</td>
                                <td>{{ ucfirst($row->status) }}</td>
                                <td>{{ ucfirst($row->type) }}</td>
                                <td class="action-button">
                                    <form action="{{ route('attendance.destroy',$row->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_import" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Get Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="date" class="col-sm-3 text-left control-label col-form-label">{{ __('Date') }}</label>
                        <div class="col-sm-9 input-group">
                            <input type="text" class="form-control mydatepicker" id="date" name="date" value="{{ !empty(old('date'))?old('date'):date('d-m-Y') }}" placeholder="dd/mm/yyyy" autocomplete="off" required>
                            <div class="input-group-append">
                                <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default add" id="import_data">Import</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <script>
        $('#attendance').DataTable();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#import_data').on('click', function() {
            if ($('#date').val() == '') {
                popup('Date cannot empty', 'error');
            } else {
                $.ajax({
                    url: "{{ route('importAttendance') }}",
                    type: 'POST',
                    data: {
                        'date': $('#date').val(),
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            location.reload();
                        } else {
                            popup(res.message, 'error');
                        }
                    }
                });
            }
        });
    </script>


</x-app-layout>