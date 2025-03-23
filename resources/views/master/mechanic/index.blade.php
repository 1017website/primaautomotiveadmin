<x-app-layout>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider2 {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider2:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider2 {
            background-color: #2196F3;
        }

        input:focus+.slider2 {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider2:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider2.round2 {
            border-radius: 34px;
        }

        .slider2.round2:before {
            border-radius: 50%;
        }
    </style>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('HRM') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Employee') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('mechanic.create') }}">{{ __('Create') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Employee') }}</h5>
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
                    <table id="mechanic" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Position') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Address') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Status')}}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mechanic as $row)
                            <tr>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->position }}</td>
                                <td>{{ $row->phone }}</td>
                                <td>{{ $row->address }}</td>
                                <td>{{ isset($row->userCreated) ? $row->userCreated->name : '-' }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" class="toggle-status" data-id="{{ $row->id }}"
                                            data-url="{{ route('mechanic.toggle-status', $row->id) }}" {{ $row->status ?
                                        'checked' : '' }}>
                                        <span class="slider2 round2"></span>
                                    </label>
                                </td>
                                <td class="action-button">
                                    <form action="{{ route('mechanic.destroy',$row->id) }}" method="POST">
                                        <a class="btn btn-info" href="{{ route('mechanic.show',$row->id) }}"><i
                                                class="fas fa-eye"></i></a>
                                        <a class="btn btn-default" href="{{ route('mechanic.edit',$row->id) }}"><i
                                                class="fas fa-pencil-alt"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i
                                                class="fas fa-trash"></i></button>
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

    <div class="modal fade" id="Modal4" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="confirmMessage">Are you sure you want to change this employee's status?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default status">Change Status Employee</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#mechanic').DataTable();
    </script>

    <script>
        $(document).ready(function() {
            var mechanicId, status, toggleElement, requestUrl, statusConfirmed = false;

            $(document).on('change', '.toggle-status', function(e) {
                e.preventDefault();
                
                mechanicId = $(this).data('id');
                requestUrl = $(this).data('url');
                status = $(this).prop('checked') ? 1 : 0;
                toggleElement = $(this);
                statusConfirmed = false;
                
                $('#confirmMessage').text(`Are you sure you want to ${status ? 'activate' : 'deactivate'} this employee?`);
                
                $('#Modal4').modal('show');
            });

            $(document).on('click', '.status', function() {
                statusConfirmed = true; 

                $.ajax({
                    url: requestUrl,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        alert('Failed to update status!');
                        toggleElement.prop('checked', !status);
                    }
                });

                $('#Modal4').modal('hide');
            });

            $('#Modal4').on('hidden.bs.modal', function () {
                if (!statusConfirmed) {
                    toggleElement.prop('checked', !status);
                }
            });
        });
    </script>
</x-app-layout>