<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('order.index') }}">{{ __('Order') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <form action="{{ route('order.destroy',$order->id) }}" method="POST">
                @csrf
                @method('DELETE')
                @if($order->status == '1')
                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                @endif
                <a class="btn btn-default" href="{{ route('order.index') }}">{{ __('Back') }}</a>
            </form>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Detail Order') }}</h5>
                <div class="border-top"></div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="row p-3">
                            <div class="col-sm-2">
                                <strong>{{ __('Order') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ $order->code }}
                            </div>
                        </div>
                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-2">
                                <strong>{{ __('Date') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ date('d-m-Y', strtotime($order->date)) }}
                            </div>
                        </div>
                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-2">
                                <strong>{{ __('Note') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ $order->description }}
                            </div>
                        </div>
                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-2">
                                <strong>{{ __('Status') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ $order->getStatus() }}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="border-top"></div>
                <div class="row pt-3">
                    <div class="col-sm-12">
                        <h5 class="card-title">{{ __('Customer') }}</h5>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="row p-3">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Name') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ $order->cust_name }}
                                    </div>
                                </div>

                                <div class="row p-3">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Phone') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ $order->cust_phone }}
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-6">

                                <div class="row p-3">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Id Card') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ $order->cust_id_card }}
                                    </div>
                                </div>

                                <div class="row p-3">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Address') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ $order->cust_address }}
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row pt-3">
                    <div class="col-sm-12">
                        <h5 class="card-title">{{ __('Car') }}</h5>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="row p-3">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Name') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ $order->vehicle_name }}
                                    </div>
                                </div>

                                <div class="row p-3">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Type') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ $order->vehicle_type }}
                                    </div>
                                </div>

                                <div class="row p-3">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Brand') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ $order->vehicle_brand }}
                                    </div>
                                </div>

                                <div class="row p-3">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Document') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        @if((!empty($order->vehicle_document)))
                                        <a href="{{ asset('storage/'.$order->vehicle_document) }}" class="btn btn-default" target="_blank">Download</a>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-6">

                                <div class="row p-3">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Year') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ $order->vehicle_year }}
                                    </div>
                                </div>

                                <div class="row p-3">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Color') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ $order->vehicle_color }}
                                    </div>
                                </div>

                                <div class="row p-3">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Plate') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ $order->vehicle_plate }}
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row pt-3">
                    <div class="col-sm-12">
                        <h5 class="card-title">{{ __('List Service') }}</h5>
                        <div class="border-top"></div>
                        <div class="detail">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Service</th>
                                            <th scope="col">Est Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody class="customtable">
                                        @if (count($order->detail) > 0)
                                        @foreach ($order->detail as $row)
                                        <tr>
                                            <td align='center'>{{ $row->service_name }}</td>
                                            <td align='center'>{{ __('Rp. ') }}@price($row->service_price)</td>
                                        </tr>
                                        @endforeach
                                        @else
                                    <td colspan="7" class="text-muted text-center">Service is empty</td>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>




            </div>
        </div>

    </div>

</x-app-layout>