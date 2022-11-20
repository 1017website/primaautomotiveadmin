<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('order.index') }}">{{ __('Order') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('order.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Add Order') }}</h5>
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

                <form class="form-horizontal" action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
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
                                        <label for="description" class="col-sm-2 text-left control-label col-form-label">{{ __('Note') }}</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <fieldset class="border p-2">
                                <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('Customer') }}</legend>
                                <div class ="row">
                                    <div class="col-sm-6">

                                        <div class="form-group row">
                                            <label for="cust_name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="cust_name" name="cust_name" value="{{ old('cust_name') }}" required="true">
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
                                        <div class="form-group row hidden">
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
                                <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('Car') }}</legend>
                                <div class ="row">
                                    <div class="col-sm-6">

                                        <div class="form-group row">
                                            <label for="cars_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                                            <div class="col-sm-10">
                                                <select class="select2 form-control custom-select" id="cars_id" name="cars_id" style="width: 100%;">                              
                                                    @foreach($car as $row)                                
                                                    <option value="{{$row->id}}">{{ $row->type->name }} - {{ $row->brand->name }} - {{$row->name}}</option>    
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="vehicle_plate" class="col-sm-2 text-left control-label col-form-label">{{ __('Plate') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="vehicle_plate" name="vehicle_plate" value="{{ old('vehicle_plate') }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="vehicle_document" class="col-sm-2 text-left control-label col-form-label">{{ __('Checklist') }}</label>
                                            <div class="col-sm-10">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="vehicle_document" name="vehicle_document">
                                                    <label class="custom-file-label" for="validatedCustomFile">{{ __('Choose file...') }}</label>
                                                    @error('image')
                                                    <div class="invalid-feedback">{{ $message }}k</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="vehicle_year" class="col-sm-2 text-left control-label col-form-label">{{ __('Year') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="vehicle_year" name="vehicle_year" value="{{ old('vehicle_year') }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="vehicle_color" class="col-sm-2 text-left control-label col-form-label">{{ __('Color') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="vehicle_color" name="vehicle_color" value="{{ old('vehicle_color') }}"">
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </fieldset>

                            <fieldset class="border p-2">
                                <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('List Service') }}</legend>
                                <button type="button" class="btn btn-default btn-action mt-2 mb-2" data-toggle="modal" data-target="#Modal2">{{ __('Add Service') }}</button>
                                <div class="detail">

                                </div>
                            </fieldset>

                            <div class="border-top"></div>
                            <button type="submit" class="btn btn-default btn-action">Save</button>
                            </form>

                        </div>
                    </div>

            </div>

            <!-- Modal -->
            <div class="modal fade" id="Modal2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="service_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Service') }}</label>
                                <div class="col-sm-10">
                                    <select class="select2 form-control custom-select" id="service_id" name="service_id" style="width: 100%;">                              
                                        @foreach($service as $row)                                
                                        <option value="{{$row->id}}">{{$row->name}}</option>    
                                        @endforeach
                                    </select>
                                </div>                                
                            </div>

                            <div class="form-group row">
                                <label for="service_qty" class="col-sm-2 text-left control-label col-form-label">{{ __('Qty') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="service_qty" name="service_qty" required="true" value="1">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="qty" class="col-sm-2 text-left control-label col-form-label">{{ __('Price') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="price" name="price" required="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="service_disc" class="col-sm-2 text-left control-label col-form-label">{{ __('Disc') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="service_disc" name="service_disc" placeholder="">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-default" id="addService">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function ($) {

            get_detail();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function get_detail() {
                $.ajax({
                    url: "{{ route('detailOrder') }}",
                    type: 'GET',
                    dataType: 'html',
                    success: function (res) {
                        $('.detail').html(res);
                    }
                });
            }

            $("#addService").click(function () {
                $.ajax({
                    url: "{{ route('addOrder') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'service_id': $('#service_id').val(),
                        'service_qty': $('#service_qty').val(),
                        'service_disc': $('#service_disc').val()
                    },
                    success: function (res) {
                        if (res.success) {
                            $('#Modal2').modal('toggle');
                            get_detail();
                            $('#service_disc').val('');
                        } else {
                            popup(res.message, 'error');
                        }
                    }
                });
            });

            $("#service_id").trigger("change");

        });

        document.querySelector('.custom-file-input').addEventListener('change', function (e) {
            var fileName = document.getElementById("vehicle_document").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        });

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
        });

        $('#cars_id').val("{{ old('cars_id') }}").change();

        $('#service_id').on('change', function () {
            $.ajax({
                url: "{{ route('order.price') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    'service_id': this.value
                },
                success: function (res) {
                    $('#price').val(res.price);
                    var price = document.getElementById('price');
                    var formated = formatRupiah($('#price').val(), 'Rp. ');
                    price.value = formated;
                }
            });
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

        var harga = document.getElementById('service_disc');
        $(document).ready(function () {
            console.log(harga.value);
            var formated = formatRupiah($('#service_disc').val(), 'Rp. ');
            harga.value = formated;
        });
        harga.addEventListener('keyup', function (e) {
            harga.value = formatRupiah(this.value, 'Rp. ');
        });
    </script>

</x-app-layout>