<x-app-layout>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Wash Sales') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('wash-sale.create') }}">{{ __('Add') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Wash Sales') }}</h5>
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
                    <table id="order" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Customer Name') }}</th>
                                <th>{{ __('Customer Phone') }}</th>
                                <th>{{ __('Car') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order as $row)
                            <tr>
                                <td>{{ $row->code }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                <td>{{ $row->cust_name }}</td>
                                <td>{{ $row->cust_phone }}</td>
                                <td>{{ $row->vehicle_brand }} - {{ $row->vehicle_name }}</td>
                                <td>{{ isset($row->userCreated) ? $row->userCreated->name : '-' }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td>{{ $row->getStatus() }}</td>
                                <td class="action-button">
                                    <a class="btn btn-info" href="{{ route('wash-sale.show',$row->id) }}"><i
                                            class="fas fa-eye"></i></a>
                                    <?php if (!in_array($row->status, [0, 4])) { ?>
                                    <button class="btn btn-warning btn-edit" data-id="{{ $row->id }}"><i
                                            class="fas fa-pencil-alt"></i></button>
                                    <?php } ?>
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
    <div class="modal fade" id="Modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <fieldset class="border p-2">
                        <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('Product') }}</legend>
                        <div class="form-group row">
                            <label for="service_id" class="col-sm-1 text-left control-label col-form-label">{{
                                __('Service') }}</label>
                            <div class="col-sm-5">
                                <select class="select2 form-control custom-select" id="service_id" name="service_id"
                                    style="width: 100%;">
                                    @foreach($service as $row)
                                    <option data-price='<?= $row->cost ?>' value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="price" class="col-sm-1 text-left control-label col-form-label">{{ __('Price')
                                }}</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="price" name="price" required="" readonly="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="service_qty" class="col-sm-1 text-left control-label col-form-label">{{
                                __('Qty') }}</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="service_qty" name="service_qty"
                                    required="true" value="1">
                            </div>
                            <label for="disc_persen" class="col-sm-1 text-left control-label col-form-label">{{
                                __('Disc') }}</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="disc_persen" name="disc_persen"
                                    placeholder="">
                            </div>
                            <div class="col-sm-1" style="line-height: 35px;"><span class="align-middle">%</span></div>
                        </div>
                        <button type="button" class="btn btn-default btn-service mt-2 mb-2">{{ __('Add Service')
                            }}</button>
                        <div class="detail">

                        </div>
                    </fieldset>
                    <fieldset class="border p-2">
                        <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('Product') }}</legend>
                        <div class="form-group row">
                            <label for="product_id" class="col-sm-1 text-left control-label col-form-label">{{
                                __('Product') }}</label>
                            <div class="col-sm-5">
                                <select class="select2 form-control custom-select" id="product_id" name="product_id"
                                    style="width: 100%;">
                                    @foreach($product as $row)
                                    <option data-price='<?= $row->selling_price ?>' value="{{$row->id}}">{{$row->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="price_product" class="col-sm-1 text-left control-label col-form-label">{{
                                __('Price') }}</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="price_product" name="price_product"
                                    required="" readonly="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_qty" class="col-sm-1 text-left control-label col-form-label">{{
                                __('Qty') }}</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="product_qty" name="product_qty"
                                    required="true" value="1">
                            </div>
                            <label for="disc_persen_product" class="col-sm-1 text-left control-label col-form-label">{{
                                __('Disc') }}</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="disc_persen_product"
                                    name="disc_persen_product" placeholder="">
                            </div>
                            <div class="col-sm-1" style="line-height: 35px;"><span class="align-middle">%</span></div>
                        </div>
                        <button type="button" class="btn btn-default btn-product mt-2 mb-2">{{ __('Add Product')
                            }}</button>
                        <div class="detail_product">

                        </div>
                    </fieldset>
                    <fieldset class="border p-2">
                        <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('Total') }}</legend>

                        <div class="form-group row">
                            <div class="col-sm-4"></div>
                            <label for="disc_persen_header" class="col-sm-2 text-left control-label col-form-label">{{
                                __('Disc') }}</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="disc_persen_header"
                                    name="disc_persen_header" value="{{ old('disc_persen_header') }}"
                                    style="align:right" placeholder="%">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="disc_header" readonly name="disc_header"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4"></div>
                            <label for="disc_persen_header" class="col-sm-2 text-left control-label col-form-label">{{
                                __('PPn') }}</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="ppn_persen_header" name="ppn_persen_header"
                                    value="{{ old('ppn_persen_header') }}" style="align:right" placeholder="%">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="ppn_header" readonly name="ppn_header"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4"></div>
                            <label for="grand_total" class="col-sm-2 text-left control-label col-form-label">{{
                                __('Grand Total') }}</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="grand_total" readonly name="grand_total"
                                    placeholder="">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default" id="updateOrder">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <script>
        var editId = 0;
        $(".btn-edit").click(function () {
            editId = $(this).data('id')
            $('#Modal').modal('show');
        });


        $(document).ready(function ($) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#service_id").trigger("change");

            $("#product_id").trigger("change");
        });

        $("#disc_persen_header").keyup(function () {
            get_total()
        });
        $("#service_disc").keyup(function () {
            get_total()
        });
        $("#ppn_persen_header").keyup(function () {
            get_total()
        });


        $(".btn-product").click(function () {
            $.ajax({
                url: "{{ route('wash-sale.addOrderProduct') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    'product_id': $('#product_id').val(),
                    'product_qty': $('#product_qty').val(),
                    'disc_persen_product': $('#disc_persen_product').val()
                },
                success: function (res) {
                    if (res.success) {
                        get_product();
                        $('#disc_persen_product').val('');
                    } else {
                        popup(res.message, 'error');
                    }
                }
            });
        });

        $(".btn-service").click(function () {
            $.ajax({
                url: "{{ route('wash-sale.addOrder') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    'service_id': $('#service_id').val(),
                    'service_qty': $('#service_qty').val(),
                    'service_disc': $('#service_disc').val(),
                    'disc_persen': $('#disc_persen').val()
                },
                success: function (res) {
                    if (res.success) {
                        get_detail();
                        $('#disc_persen').val('');
                    } else {
                        popup(res.message, 'error');
                    }
                }
            });
        });

        $('#order').DataTable({
            order: [[0, 'desc']],
        });

        function get_insert() {
            $.ajax({
                url: "{{ route('wash-sale.allDetail') }}",
                type: 'GET',
                data: {
                    'id': editId
                },
                dataType: 'JSON',
                success: function (res) {
                    $('#disc_persen_header').val(res.disc);
                    $('#ppn_persen_header').val(res.ppn);
                    get_detail()
                    get_product()
                }
            });
        }

        $("#updateOrder").click(function () {

            $(this).prop('disabled', true);
            $.ajax({
                url: "{{ route('wash-sale.updateOrder') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    'id': editId,
                    'disc_persen_header': $('#disc_persen_header').val(),
                    'ppn_persen_header': $('#ppn_persen_header').val()
                },
                success: function (res) {
                    if (res.success) {
                        $("#updateOrder").prop('disabled', false);
                        $('#Modal').modal('hide');
                        editId = 0;
                    } else {
                        $("#updateOrder").prop('disabled', false);
                        alert(res.message)
                    }
                }
            });
        });

        function update(e) {
            $.ajax({
                url: "{{ route('wash-sale.updateOrder') }}",
                type: 'POST',
                data: {
                    'id': editId
                },
                dataType: 'text',
                success: function (res) {
                    get_detail()
                    get_product()
                }
            });
        }

        function get_detail() {
            $.ajax({
                url: "{{ route('wash-sale.detailOrder') }}",
                type: 'GET',
                dataType: 'html',
                success: function (res) {
                    $('.detail').html(res);
                    setTimeout(function () {
                        get_total()
                    }, 3000);
                }
            });
        }

        function get_product() {
            $.ajax({
                url: "{{ route('wash-sale.detailProduct') }}",
                type: 'GET',
                dataType: 'html',
                success: function (res) {
                    $('.detail_product').html(res);
                    setTimeout(function () {
                        get_total()
                    }, 3000);
                }
            });
        }

        function deleteTempProduct(id) {
            $.ajax({
            url: "{{ route('wash-sale.deleteOrderProduct') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                    'id': id
                    },
                    success: function (res) {
                    get_product();
                    }
            });
            }

        $('#Modal').on('shown.bs.modal', function () {
            get_insert()
        });

        function get_total() {
            sub = $('.sub').data('total') + $('.sub_product').data('total')
            disc = Math.round(sub * (($('#disc_persen_header').val()).replace(",", ".")) / 100);
            total = Math.round(sub - disc);
            ppn = Math.round(total * (($('#ppn_persen_header').val()).replace(",", ".")) / 100);
            console.log(total)
            $('#disc_header').val(disc)
            var formated = formatRupiah($('#disc_header').val(), 'Rp. ');
            $('#disc_header').val(formated)

            $('#ppn_header').val(ppn)
            var formated = formatRupiah($('#ppn_header').val(), 'Rp. ');
            $('#ppn_header').val(formated)

            total = total + ppn;
            $('#grand_total').val(total);
            var formated = formatRupiah($('#grand_total').val(), 'Rp. ');
            grand_total.value = formated;
        }

        function header() {
            var harga = document.getElementById('service_disc');
            var grand_total = document.getElementById('grand_total');
            var formated = formatRupiah($('#service_disc').val(), 'Rp. ');
            harga.value = formated;
            harga.addEventListener('keyup', function (e) {
                harga.value = formatRupiah(this.value, 'Rp. ');
            });

            $(document).ready(function () {
                var formated = formatRupiah($('#disc_header').val(), 'Rp. ');
                $('#disc_header').val(formated)
            });


            $(document).ready(function () {
                var formated = formatRupiah($('#ppn_header').val(), 'Rp. ');
                $('#ppn_header').val(formated)
                get_total()
            });
        }

        $('#product_id').on('change', function () {
            console.log($(this).find(':selected').data('price'))
            $('#price_product').val($(this).find(':selected').data('price'));
            var price = document.getElementById('price_product');
            var formated = formatRupiah($('#price_product').val(), 'Rp. ');
            $('#price_product').val(formated)
        });

        $('#service_id').on('change', function () {
            console.log($(this).find(':selected').data('price'))
            $('#price').val($(this).find(':selected').data('price'));
            var price = document.getElementById('price');
            var formated = formatRupiah($('#price').val(), 'Rp. ');
            $('#price').val(formated)
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

        $(function () {
            $("input[id*='service_qty']").keydown(function (event) {
                if (event.shiftKey == true) {
                    event.preventDefault();
                }
                if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                        (event.keyCode >= 96 && event.keyCode <= 105) ||
                        event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                        event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 188) {
                } else {
                    event.preventDefault();
                }
                if ($(this).val().indexOf(',') !== -1 && event.keyCode == 188)
                    event.preventDefault();
                //if a decimal has been added, disable the "."-button
            });

            $("input[id*='product_qty']").keydown(function (event) {
                if (event.shiftKey == true) {
                    event.preventDefault();
                }
                if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                        (event.keyCode >= 96 && event.keyCode <= 105) ||
                        event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                        event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 188) {
                } else {
                    event.preventDefault();
                }
                if ($(this).val().indexOf(',') !== -1 && event.keyCode == 188)
                    event.preventDefault();
                //if a decimal has been added, disable the "."-button
            });

        });
    </script>


</x-app-layout>