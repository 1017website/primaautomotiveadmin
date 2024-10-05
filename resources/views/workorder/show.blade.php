<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('workorder.index') }}">{{ __('Work Order') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="div-top">
            @if($workorder->status == 1)
            <a class="btn btn-success" href="{{ route('workorder.edit',$workorder->id) }}">{{ __('Done') }}</a>
            @endif
            <a class="btn btn-default" href="{{ route('workorder.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Detail Work Order') }}</h5>
                <div class="border-top"></div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="row p-3">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Work Order') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ $workorder->code }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Date') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ date('d-m-Y', strtotime($workorder->date)) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Order') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        @if($workorder->order)
                                        <a target="_blank" href="{{ route('order.show',$workorder->order_id) }}">{{ $workorder->order->code }}</a>
                                        @elseif($workorder->washSale)
                                        <a target="_blank" href="{{ route('order.show',$workorder->order_id) }}">{{ $workorder->washSale->code }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Invoice') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        <a target="_blank" href="{{ route('invoice.show',$workorder->invoice_id) }}">{{ $workorder->invoice->code }}</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Mechanic') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ $workorder->mechanic->name }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Date Done') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ ((!empty($workorder->date_done)) ?  date('d-m-Y', strtotime($workorder->date_done)) : '') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Noted') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        {{ $workorder->description }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <strong>{{ __('Document') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        @if((!empty($workorder->document)))
                                        <a href="{{ asset('storage/'.$workorder->document) }}" class="btn btn-default" target="_blank">Download</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row pt-3">
                            <div class="col-sm-12">
                                <h5 class="card-title">{{ __('List Work Order') }}</h5>
                                <div class="border-top"></div>
                                <div class="detail">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Item</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Price</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $grandQty = 0;
                                            $grandTotal = 0;
                                            ?>
                                            <tbody class="customtable">
                                                @if (count($workorder->detail) > 0)
                                                @foreach ($workorder->detail as $row)
                                                <tr>
                                                    <td align='center'>{{ $row->product_name }}</td>
                                                    <td align='center'>{{ number_format($row->qty, 2, ',', '.') }}</td>
                                                    <td align='center'>{{ __('Rp. ') }}@price($row->product_price)</td>
                                                    <?php
                                                    $grandQty += $row->qty;
                                                    $grandTotal += $row->product_price;
                                                    ?>
                                                </tr>
                                                @endforeach
                                                @else
                                            <td colspan="3" class="text-muted text-center">List empty</td>
                                            @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td align='center'><b>Grand Total</b></td>
                                                    <td align='center'>{{ number_format($grandQty, 2, ',', '.') }}</td>
                                                    <td align='center'>{{ __('Rp. ') }}@price($grandTotal)</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>

    </script>

</x-app-layout>