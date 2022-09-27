<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Invoice') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default hidden" href="{{ route('invoice.create') }}">{{ __('Add') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Invoice') }}</h5>
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
                                <th>{{ __('Customer') }}</th>
                                <th>{{ __('Car') }}</th>
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Order') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Total') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Status Payment') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice as $row)
                            <tr>
                                <td>{{ $row->order->cust_name .' - '. $row->order->cust_phone }}</td>
                                <td>{{ $row->order->car->name .' - '. $row->order->vehicle_plate }}</td>
                                <td>{{ $row->code }}</td>
                                <td>{{ $row->order->code }}</td>          
                                <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                <td>{{ __('Rp. ') }}@price($row->total)</td>
                                <td>{{ $row->getStatus() }}</td>
                                <td>{{ $row->getStatusPayment() }}</td>
                                <td class="action-button">
                                    <a class="btn btn-info" href="{{ route('invoice.show',$row->id) }}"><i class="fas fa-eye"></i></a>
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