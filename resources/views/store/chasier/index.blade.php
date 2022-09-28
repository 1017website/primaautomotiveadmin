<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Store') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Cashier') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('store-chasier.create') }}">{{ __('Add') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Cashier') }}</h5>
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
                    <table id="invoice" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Customer') }}</th>
                                <th>{{ __('Nomer') }}</th>
                                <th>{{ __('Total') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice as $row)
                            <tr>
                                <td>{{ date('d-m-Y H:i:s', strtotime($row->created_at)) }}</td>
                                <td>{{ ucfirst($row->type) }}</td>
                                <td>{{ isset($row->code)?$row->code:'-' }}</td>
                                <td align="right" data-order="{{ $row->total }}">{{ __('Rp. ') }}@price($row->total)</td>
                                <td>{{ $row->description }}</td>
                                <td class="action-button">
                                    <a class="btn btn-info" href="{{ route('store-chasier.show',$row->id) }}"><i class="fas fa-eye"></i></a>
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
        $('#invoice').DataTable();
    </script>


</x-app-layout>