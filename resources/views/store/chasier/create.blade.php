<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Store') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('store-chasier.index') }}">{{ __('Cashier') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('store-chasier.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Chasier') }}</h5>
                <div class="border-top"></div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>{{ __('Whoops! ') }}</strong>{{ __('There were some problems with your input.') }}<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form class="form-horizontal" action="{{ route('store-chasier.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-sm-12">

                            <div class ="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-2 text-left control-label col-form-label">{{ __('Date') }}</label>
                                        <div class="col-sm-5 input-group">
                                            <input type="text" class="form-control mydatepicker" id="date" name="date" value="{{ !empty(old('date'))?old('date'):date('d-m-Y') }}" placeholder="dd/mm/yyyy" autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="type" class="col-sm-2 text-left control-label col-form-label">{{ __('Type') }}</label>
                                        <div class="col-sm-10">
                                            <select class="select2 form-control custom-select" id="type" name="type" style="width: 100%;">                              
                                                <option value="eksternal">Eksternal</option>
                                                <option value="internal">Internal</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="description" class="col-sm-2 text-left control-label col-form-label">{{ __('Note') }}</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <fieldset class="border p-2 fieldset-customer">
                                <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('Customer') }}</legend>
                                <div class ="row">
                                    <div class="col-sm-6">

                                        <div class="form-group row">
                                            <label for="cust_name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control name" id="cust_name" name="cust_name" value="{{ old('cust_name') }}" required="true">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="cust_phone" class="col-sm-2 text-left control-label col-form-label">{{ __('Phone') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control phone" id="cust_phone" name="cust_phone" value="{{ old('cust_phone') }}" required="true">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group row" style="display:none;">
                                            <label for="cust_id_card" class="col-sm-2 text-left control-label col-form-label">{{ __('Id Card') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="cust_id_card" name="cust_id_card" value="{{ old('cust_id_card') }}" placeholder="Ktp/Sim">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="cust_address" class="col-sm-2 text-left control-label col-form-label">{{ __('Address') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="cust_address" name="cust_address" value="{{ old('cust_address') }}">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </fieldset>

                            <fieldset class="border p-2">
                                <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('List Product') }}</legend>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="barcode" name="barcode" value="" placeholder="Barcode..." style="width:15rem;" autocomplete="off">
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-default btn-action mt-2 mb-2" data-toggle="modal" data-target="#Modal2">{{ __('Add Product') }}</button>
                                    </div>
                                </div>
                                <div class="detail">

                                </div>
								<div class="form-group row">
									<div class="col-sm-8"></div>
									<label for="disc_persen_header" class="col-sm-1 text-left control-label col-form-label">{{ __('Disc') }}</label>
									<div class="col-sm-1">
										<input type="text" class="form-control" id="disc_persen_header" name="disc_persen_header" value="{{ old('disc_persen_header') }}" style="align:right" placeholder="%">
									</div>
									<div class="col-sm-2">
										<input type="text" class="form-control" id="disc_header" readonly name="disc_header" placeholder="">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-8"></div>
									<label for="disc_persen_header" class="col-sm-1 text-left control-label col-form-label">{{ __('PPn') }}</label>
									<div class="col-sm-1">
										<input type="text" class="form-control" id="ppn_persen_header" name="ppn_persen_header" value="{{ old('ppn_persen_header') }}" style="align:right" placeholder="%">
									</div>
									<div class="col-sm-2">
										<input type="text" class="form-control" id="ppn_header" readonly name="ppn_header" placeholder="" >
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-8"></div>
									<label for="grand_total" class="col-sm-1 text-left control-label col-form-label">{{ __('Grand Total') }}</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="grand_total" readonly name="grand_total" placeholder="">
									</div>
								</div>
                                <div class="form-group row">
                                    <div class="col-sm-8"></div>
                                    <label for="pay" class="col-sm-1 text-left control-label col-form-label">Payment</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="dp" name="dp" required="" value="{{ old('dp') }}">
                                    </div>
                                </div>
                            </fieldset>

                            <div class="border-top"></div>
                            <button type="submit" class="btn btn-default btn-action">Save</button>
                            </form>

                        </div>
                    </div>

            </div>

        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="Modal2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="product_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Product') }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="product_id" name="product_id" style="width: 100%;">                              
                                @foreach($product as $item)                                
                                <option value="{{$item->id}}">{{$item->product->name}} (Stock : {{ $item->qty }})</option>    
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="qty" class="col-sm-2 text-left control-label col-form-label">{{ __('Qty') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="qty" name="qty" required="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="qty" class="col-sm-2 text-left control-label col-form-label">{{ __('Price') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="price" name="price" required="" readonly="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="disc_persen" class="col-sm-2 text-left control-label col-form-label">{{ __('Disc') }}</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="disc_persen" name="disc_persen" placeholder="">
                        </div><div class="col-sm-1" style="line-height: 35px;"><span class="align-middle">%</span></div>
                    </div>
					
                    <div class="form-group row" style="display:none">
                        <label for="disc" class="col-sm-2 text-left control-label col-form-label">{{ __('Disc') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="disc" name="disc" placeholder="">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default" id="addItem">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <script type="text/javascript">
        $(document).ready(function () {
            $("#barcode").focus();
        });

        $(document).ready(function ($) {
            get_detail();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#product_id").trigger("change");
            $("#cust_id").trigger("change");
            function get_detail() {
                $.ajax({
                    url: "{{ route('store-chasier.detail') }}",
                    type: 'GET',
                    dataType: 'HTML',
                    success: function (res) {
                        $('.detail').html(res);
						get_total()
                    }
                });
            }

            $("#addItem").click(function () {
                $.ajax({
                    url: "{{ route('store-chasier.add') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'stock_id': $('#product_id').val(),
                        'qty': $('#qty').val(),
                        'price': $('#price').val(),
                        'disc': $('#disc').val(),
						'disc_persen': $('#disc_persen').val(),
                    },
                    success: function (res) {
                        if (res.success) {
                            $('#Modal2').modal('toggle');
                            get_detail();
                        } else {
                            Command: toastr["error"](res.message)
                        }
                    }
                });
            });
        });

		function get_total(){
			$('.sub').data('total')
			disc = Math.round($('.sub').data('total') * (($('#disc_persen_header').val()).replace(",", ".")) / 100);
			total = Math.round($('.sub').data('total') - disc);
			ppn = Math.round(total * (($('#ppn_persen_header').val()).replace(",", ".")) / 100);
			
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
		
        $(function () {
            $("input[id*='qty']").keydown(function (event) {
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

        $('#product_id').on('change', function () {
            $.ajax({
                url: "{{ route('store-chasier.price') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    'product_id': this.value
                },
                success: function (res) {
                    $('#price').val(res.price);
                    var price = document.getElementById('price');
                    var formated = formatRupiah($('#price').val(), 'Rp. ');
                    price.value = formated;
                }
            });
        });

        $('#cust_id').on('change', function () {
            $.ajax({
                url: "{{ route('store-chasier.customer') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    'cust_id': this.value
                },
                success: function (res) {
                    $('#cust_id_card').val(res.card);
                    $('#cust_phone').val(res.phone);
                    $('#cust_address').val(res.address);

                }
            });
        });

        $("#cust_name").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('store-chasier.customer') }}",
                    dataType: "JSON",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                $("#cust_name").val(ui.item.label);
                $("#cust_phone").val(ui.item.phone);
                $("#cust_address").val(ui.item.address);
                $("#cust_id_card").val(ui.item.id_card);

                return false;
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                    .append("<div>" + "<span style='font-size:12px'>" + item.label + "</span>&nbsp;- <span style='font-size:12px'>Phone : " + item.phone + "</span></div>")
                    .appendTo(ul);
        };

        var harga = document.getElementById('dp');
		var grand_total = document.getElementById('grand_total');
        $(document).ready(function () {
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

        $('#type').on('change', function () {
            if ($(this).val() == 'internal') {
                $('.fieldset-customer').hide(1000);
                $('#cust_name').removeAttr('required');
                $('#cust_phone').removeAttr('required');
            } else {
                $('.fieldset-customer').show(1000);
                $('#cust_name').attr('required', 'true');
                $('#cust_phone').attr('required', 'true');
            }
        });

        $("#barcode").on("keypress change", function (e) {
            if (e.which == 13) {
                $.ajax({
                    url: "{{ route('store-chasier.barcode') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'barcode': $(this).val()
                    },
                    success: function (res) {
                        get_detail();
                    }
                });

                $('#barcode').val('');
                $('#barcode').focus();
            }
        })

        var harga = document.getElementById('disc');
        $(document).ready(function () {
            var formated = formatRupiah($('#disc').val(), 'Rp. ');
            harga.value = formated;
        });
        harga.addEventListener('keyup', function (e) {
            harga.value = formatRupiah(this.value, 'Rp. ');
        });

		$( "#disc_persen_header" ).keyup(function() {
			get_total()
		});
        $(document).ready(function () {
            var formated = formatRupiah($('#disc_header').val(), 'Rp. ');
			$('#disc_header').val(formated)
        });

		$( "#ppn_persen_header" ).keyup(function() {
			get_total()
		});
        $(document).ready(function () {
            var formated = formatRupiah($('#ppn_header').val(), 'Rp. ');
			$('#ppn_header').val(formated)
        });
		
        var harga2 = document.getElementById('dp');
        $(document).ready(function () {
            var formated = formatRupiah($('#dp').val(), 'Rp. ');
            harga2.value = formated;
			get_total()
        });
        harga2.addEventListener('keyup', function (e) {
            harga2.value = formatRupiah(this.value, 'Rp. ');
        });
    </script>

</x-app-layout>