<x-app-layout>
    <style>
        /*Invoice*/
        .invoice .top-left {
            font-size:65px;
            color:#3ba0ff;
        }

        .invoice .top-right {
            text-align:right;
            padding-right: 10px;
            padding-top: 40px;
        }

        .invoice .table-row {
            margin-left:-15px;
            margin-right:-15px;
            margin-top:25px;
        }

        .invoice .payment-info {
            font-weight:500;
        }

        .invoice .table-row .table>thead {
            border-top:1px solid #ddd;
        }

        .invoice .table-row .table>thead>tr>th {
            border-bottom:none;
        }

        .invoice .table>tbody>tr>td {
            padding:8px 20px;
        }

        .invoice .invoice-total {
            margin-right:-10px;
            font-size:16px;
        }

        .invoice .last-row {
            border-bottom:1px solid #ddd;
        }

        .invoice-ribbon {
            width:85px;
            height:88px;
            overflow:hidden;
            position:absolute;
            top:-1px;
            right:11px;
        }

        .ribbon-inner {
            text-align:center;
            -webkit-transform:rotate(45deg);
            -moz-transform:rotate(45deg);
            -ms-transform:rotate(45deg);
            -o-transform:rotate(45deg);
            position:relative;
            padding:7px 0;
            left:-5px;
            top:11px;
            width:120px;
            font-size:15px;
            color:#fff;
        }

        .ribbon-inner:before,.ribbon-inner:after {
            content:"";
            position:absolute;
        }

        .ribbon-inner:before {
            left:0;
        }

        .ribbon-inner:after {
            right:0;
        }

        @media(max-width:575px) {
            .invoice .top-left,.invoice .top-right,.invoice .payment-details {
                text-align:center;
            }

            .invoice .from,.invoice .to,.invoice .payment-details {
                float:none;
                width:100%;
                text-align:center;
                margin-bottom:25px;
            }

            .invoice p.lead,.invoice .from p.lead,.invoice .to p.lead,.invoice .payment-details p.lead {
                font-size:22px;
            }

            .invoice .btn {
                margin-top:10px;
            }
        }

        @media print {
            .invoice {
                width:900px;
                height:800px;
            }
        }

    </style>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('payroll.index') }}">{{ __('Payroll') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Detail Payroll') }}</h5>
                <div class="border-top"></div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default invoice" id="invoice">
                            <div class="panel-body">
                                <div class="invoice-ribbon">
                                    <div class="ribbon-inner {{ $invoice->getColorPayment() }}">
                                        {{ strtoupper($invoice->getStatusPayment()) }}
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-6 top-left">
                                        <img src="{{asset('plugins/images/logo-inv.png')}}" class="img-fluid">
                                    </div>

                                </div>
                                <hr>
                                <div class="row">

                                    <div class="col-sm-12 from">
                                        <p class="lead marginbottom">{{ __('Nama') }} : {{ $mechanic->name }}</p>
                                        <p class="lead marginbottom">{{ __('Position') }} : {{ $mechanic->position }}</p>
                                        <p class="lead marginbottom">{{ __('Phone') }} : {{ $mechanic->phone }}</p>
                                        <p class="lead marginbottom">{{ __('Address') }} : {{ $mechanic->address }}</p>

                                    </div>

                                </div>

                                <div class="row table-row">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="3" class="text-left" style="width:50%">PENERIMAAN</th>
                                                <th colspan="3" class="text-left" style="width:50%">POTONGAN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Kehadiran</td>
                                                <td>:</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Gaji Pokok</td>
                                                <td>:</td>
                                                <td></td>
                                            </tr>
                                            <?php if ($payroll->positional_allowance > 0) { ?>
                                                <tr>
                                                    <td>Tunjangan Jabatan</td>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                </div>

                                <div class="row">
                                    <div class="col-sm-6 margintop">
                                        <p>{{ __('Noted') }} : {{ $invoice->order->description }}</p>

                                        <a class="btn btn-primary" href="{{ route('invoice.print', $invoice->id) }}" target="_blank"><i class="fa fa-print"></i>{{ __('Print') }}</a>
                                        <a class="btn btn-primary" href="{{ route('invoice.download', $invoice->id) }}" target="_blank"><i class="fa fa-download"></i>{{ __('Download PDF') }}</a>

                                    </div>
                                    <div class="col-sm-6 text-right pull-right invoice-total">

                                        <p>{{ __('Subtotal') }} : {{ __('Rp. ') }}@price($invoice->total)</p>

                                        <p>{{ __('Payment') }} : {{ __('Rp. ') }}@price($invoice->dp)</p>                                      

                                        <p>{{ __('Remaining Pay') }} : {{ __('Rp. ') }}@price($invoice->total - $invoice->dp)</p>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Modal -->
            <div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pay</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="date" class="col-sm-2 text-left control-label col-form-label">{{ __('Date') }}</label>
                                <div class="col-sm-10 input-group">
                                    <input type="text" class="form-control mydatepicker" id="date" name="date" value="{{ $date }}" placeholder="dd/mm/yyyy" autocomplete="off" required="true">
                                    <div class="input-group-append">
                                        <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="total" class="col-sm-2 text-left control-label col-form-label">{{ __('Payment') }}</label>
                                <div class="col-sm-10">
                                    <input value="{{ $sisa }}" type="text" class="form-control" id="dp" name="dp" required="true">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-default" id="payInvoice">Pay</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

            <!-- Modal -->
            <div class="modal fade" id="Modal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Work Order</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="date" class="col-sm-2 text-left control-label col-form-label">{{ __('Date') }}</label>
                                <div class="col-sm-10 input-group">
                                    <input type="text" class="form-control mydatepicker" id="date_work" name="date_work" value="{{ $date }}" placeholder="dd/mm/yyyy" autocomplete="off" required="true">
                                    <div class="input-group-append">
                                        <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mechanic_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Mechanic') }}</label>
                                <div class="col-sm-10">
                                    <select class="select2 form-control custom-select" id="mechanic_id" name="mechanic_id" style="width: 100%;">                              
                                        @foreach($mechanic as $row)                                
                                        <option value="{{$row->id}}">{{$row->name}}</option>    
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-default" id="addWork">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

            <!-- Modal -->
            <div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Void Invoice</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="date" class="col-sm-3 text-left control-label col-form-label">{{ __('Password') }}</label>
                                <div class="col-sm-9 input-group">
                                    <input type="password" class="form-control" id="password" name="date_work" value="" required="true">
                                    <div class="input-group-append">
                                        <span class="input-group-text form-control"><i class="fa fa-key"></i></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="voidInvoice">Void</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

        </div>

    </div>

    <script type="text/javascript">
        var harga = document.getElementById('dp');

        $(document).ready(function () {
            console.log(harga.value);
            var formated = formatRupiah($('#dp').val(), 'Rp. ');
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

        $("#payInvoice").click(function () {
            if ($('#dp').val() != '' && $('#dp').val() != null) {
                $.ajax({
                    url: "{{ route('payInvoice') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'invoice_id': <?= $invoice->id ?>,
                        'date': $('#date').val(),
                        'dp': $('#dp').val()
                    },
                    success: function (res) {
                        if (res.success) {
                            location.reload();
                        } else {
                            popup(res.message, 'error');
                        }
                    }
                });
            }
        });

        $("#addWork").click(function () {
            if ($('#dp').val() != '' && $('#dp').val() != null) {
                $.ajax({
                    url: "{{ route('workOrder') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'invoice_id': <?= $invoice->id ?>,
                        'date': $('#date_work').val(),
                        'mechanic_id': $('#mechanic_id').val()
                    },
                    success: function (res) {
                        if (res.success) {
                            window.location.href = "/workorder/" + res.message;
                        } else {
                            popup(res.message, 'error');
                        }
                    }
                });
            }
        });

        $("#voidInvoice").click(function () {
            if ($('#password').val() != '' && $('#password').val() != null) {
                $.ajax({
                    url: "{{ route('voidInvoice') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'invoice_id': <?= $invoice->id ?>,
                        'password': $('#password').val(),
                    },
                    success: function (res) {
                        if (res.success) {
                            window.location.href = "/invoice";
                            popup('Void Invoice Success', 'success');
                        } else {
                            popup(res.message, 'error');
                        }
                    }
                });
            } else {
                popup('Password Required !', 'error');
            }
        });
    </script>

</x-app-layout>