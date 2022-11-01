<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Hrm') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Credit') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('employee-credit.create') }}">{{ __('Add') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Credit') }}</h5>
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
                    <table id="credit" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Tenor') }}</th>
                                <th>{{ __('Total') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($credit as $row)
                            <tr>
                                <td>{{ isset($row->employee) ? $row->employee->name : '-' }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                <td>{{ $row->description }}</td>
                                <td align="center" >{{ $row->tenor }}x</td>
                                <td align="right" data-order="{{ $row->total }}">{{ __('Rp. ') }}@price($row->total)</td>
                                <td>{{ ucfirst($row->status) }}</td>
                                <td class="action-button">
                                    <form action="{{ route('employee-credit.destroy',$row->id) }}" method="POST">
                                        <a class="btn btn-info" href="{{ route('employee-credit.show',$row->id) }}"><i class="fas fa-eye"></i></a>
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

    <script>
        $('#credit').DataTable();
    </script>


</x-app-layout>