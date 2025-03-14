<x-app-layout>
    <?php
$disc = false;
$discP = false;
$sub = 0;
$grandTotal = 0;
foreach ($order->detail as $index => $value){
	if(!empty($value->service_disc)){
		$disc = true;
	}
}
foreach ($order->product as $index => $value){
	if(!empty($value->disc)){
		$disc = true;
	}
}
?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('wash-sale.index') }}">{{ __('Wash Sales')
                                    }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <form action="{{ route('wash-sale.destroy',$order->id) }}" method="POST">
                @csrf
                @method('DELETE')
                @if($order->status == '1')
                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                @endif
                <a class="btn btn-default" href="{{ route('wash-sale.index') }}">{{ __('Back') }}</a>
            </form>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Detail Wash Sales') }}</h5>
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
                                        <strong>{{ __('Checklist') }}</strong>
                                    </div>
                                    <div class="col-sm-10">
                                        @if((!empty($order->vehicle_document)))
                                        <a href="{{ asset('storage/'.$order->vehicle_document) }}"
                                            class="btn btn-default" target="_blank">Download</a>
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
                                            <th scope="col">Qty</th>
                                            <th scope="col">Cost Service</th>
                                            <?php if($disc){ ?>
                                            <th scope="col" colspan=2>Disc</th>
                                            <?php } ?>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="customtable">
                                        @if (count($order->detail) > 0)
                                        @foreach ($order->detail as $row)
                                        <tr>
                                            <td align='center'>{{ $row->service_name }}</td>
                                            <td align='center'>{{ number_format($row->service_qty, 0, ',', '.') }}</td>
                                            <td align='center'>{{ __('Rp. ') }}@price($row->service_price)</td>
                                            <?php if($disc){ ?>
                                            <td class="text-left">{{ number_format($row->disc_persen,2).' %' }}</td>
                                            <td class="text-left">{{ __('Rp. ') }}@price($row->service_disc)</td>
                                            <?php } ?>
                                            <td align='center'>{{ __('Rp. ') }}@price($row->service_total)</td>
                                            <?php 
                                                $grandTotal += $row->service_total;
                                            ?>
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

                <div class="border-top"></div>
                <div class="row pt-3">
                    <div class="col-sm-12">
                        <h5 class="card-title">{{ __('List Product') }}</h5>
                        <div class="border-top"></div>
                        <div class="detail">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Product</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Price</th>
                                            <?php if($discP){ ?>
                                            <th scope="col" colspan=2>Disc</th>
                                            <?php } ?>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="customtable">
                                        @if (count($order->product) > 0)
                                        @foreach ($order->product as $row)
                                        <tr>
                                            <td align='center'>{{ $row->product_name }}</td>
                                            <td align='center'>{{ number_format($row->product_qty, 0, ',', '.') }}</td>
                                            <td align='center'>{{ __('Rp. ') }}@price($row->product_price)</td>
                                            <?php if($discP){ ?>
                                            <td class="text-left">{{ number_format($row->disc_persen,2).' %' }}</td>
                                            <td class="text-left">{{ __('Rp. ') }}@price($row->disc)</td>
                                            <?php } ?>
                                            <td align='center'>{{ __('Rp. ') }}@price($row->total)</td>
                                            <?php 
                                                $grandTotal += $row->total;
                                            ?>
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

                <div class="row">
                    <div class="col-sm-6 margintop"></div>
                    <div class="col-sm-6 text-right pull-right invoice-total">

                        <p>{{ __('Subtotal') }} : {{ __('Rp. ') }}@price($grandTotal)</p>
                        <?php if(!empty($order->disc_persen_header)){ ?>
                        <p>{{ __('Disc ') }} {{ number_format($order->disc_persen_header,2) . ' %'}} : {{ __('Rp. ')
                            }}@price($order->disc_header)</p>
                        <?php } ?>
                        <?php if(!empty($order->ppn_persen_header)){ ?>
                        <p>{{ __('PPn ') }} {{ number_format($order->ppn_persen_header,2) . ' %'}} : {{ __('Rp. ')
                            }}@price($order->ppn_header)</p>
                        <?php } ?>

                        <p>{{ __('Grand Total') }} : {{ __('Rp. ') }}@price($grandTotal - $order->disc_header +
                            $order->ppn_header)</p>
                    </div>
                </div>

                <div class="border-top"></div>
                @if($order->status == '1')
                <div class="div-top">
                    <button type="button" class="btn btn-default btn-action mt-2 mb-2" data-toggle="modal"
                        data-target="#Modal2"><i class="mdi mdi-receipt"></i>{{ __('Invoice') }}</button>
                </div>
                @endif

            </div>

            <!-- Modal -->
            <div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="date" class="col-sm-2 text-left control-label col-form-label">{{ __('Date')
                                    }}</label>
                                <div class="col-sm-10 input-group">
                                    <input type="text" class="form-control mydatepicker" id="date" name="date"
                                        value="{{ date('d-m-Y') }}" placeholder="dd/mm/yyyy" autocomplete="off"
                                        required="true">
                                    <div class="input-group-append">
                                        <span class="input-group-text form-control"><i
                                                class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="total" class="col-sm-2 text-left control-label col-form-label">{{
                                    __('Total') }}</label>
                                <div class="col-sm-10">
                                    <input value="{{ $total - $order->disc_header }}" type="text" class="form-control"
                                        id="total" name="total" required="true" readonly="">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-default" id="addInvoice">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

        </div>

    </div>

    <script>
        var harga = document.getElementById('total');

        $(document).ready(function () {
            console.log(harga.value);
            var formated = formatRupiah($('#total').val(), 'Rp. ');
            harga.value = formated;
        });

        harga.addEventListener('keyup', function (e) {
            harga.value = formatRupiah(this.value, 'Rp. ');
        });

        function formatRupiah(angka, prefix)
        {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#addInvoice").click(function () {
            if ($('#date').val() != '' && $('#date').val() != null) {
                $.ajax({
                    url: "{{ route('wash-sale.addInvoice') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'order_id': <?= $order->id ?>,
                        'date': $('#date').val(),
                        'total': $('#total').val()
                    },
                    success: function (res) {
                        if (res.success) {
                            window.location.href = "/invoice/" + res.message;
                        } else {
                            popup(res.message, 'error');
                        }
                    }
                });
            }
        });
    </script>

</x-app-layout>