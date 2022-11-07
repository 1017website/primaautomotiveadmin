<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Hrm') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Payroll') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('payroll.create') }}">{{ __('Add') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Payroll') }}</h5>
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
                    <table id="payroll" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Month') }}</th>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Attendance') }}</th>
                                <th>{{ __('Total') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payroll as $row)
                            <tr>
                                <td>{{ $row->month }}</td>
                                <td>{{ isset($row->employee) ? $row->employee->name : '-' }}</td>
                                <td>{{ $row->attendance . ' Days' }}</td>
                                <td align="right" data-order="{{ $row->total }}">{{ __('Rp. ') }}@price($row->total_salary)</td>
                                <td>{{ ucfirst($row->status) }}</td>
                                <td class="action-button">
                                    <a class="btn btn-info" href="{{ route('payroll.show',$row->id) }}"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <script>
        $('#payroll').DataTable();
    </script>


</x-app-layout>