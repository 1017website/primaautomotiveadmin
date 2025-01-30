<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('material-usage.index') }}">{{ __('Material
                                    Usage')
                                    }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('material-usage.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Add Material Usage') }}</h5>
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

                <form class="form-horizontal" action="{{ route('material-usage.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-sm-12">

                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group row">
                                        <label for="date" class="col-sm-2 text-left control-label col-form-label">{{
                                            __('Date') }}</label>
                                        <div class="col-sm-5 input-group">
                                            <input type="text" class="form-control mydatepicker" id="date" name="date"
                                                value="{{ (!empty(old('date'))?old('date'):date('d-m-Y')) }}"
                                                placeholder="dd/mm/yyyy" autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="input-group-text form-control"><i
                                                        class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="id_mechanic"
                                            class="col-sm-2 text-left control-label col-form-label">{{ __('Mechanic')
                                            }}</label>
                                        <div class="col-sm-10">
                                            <select class="select2 form-control custom-select" id="id_mechanic"
                                                name="id_mechanic" style="width: 100%;">
                                                @foreach($mechanic as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="id_product"
                                            class="col-sm-2 text-left control-label col-form-label">{{ __('Product')
                                            }}</label>
                                        <div class="col-sm-10">
                                            <select class="select2 form-control custom-select" id="id_product"
                                                name="id_product" style="width: 100%;">
                                                @foreach($storeProduct as $item)
                                                <option value="{{$item->id}}">{{$item->product->name}} (Stock : {{
                                                    $item->qty }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="qty" class="col-sm-2 text-left control-label col-form-label">{{
                                            __('Quantity')
                                            }}</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="qty" name="qty" placeholder="0"
                                                value="{{ old('qty') }}" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="price" class="col-sm-2 text-left control-label col-form-label">{{
                                            __('Price') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="price" name="price" required=""
                                                readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="total" class="col-sm-2 text-left control-label col-form-label">{{
                                            __('Total') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="total" name="total" required=""
                                                readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="description"
                                            class="col-sm-2 text-left control-label col-form-label">{{ __('Note')
                                            }}</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="description"
                                                name="description">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-top"></div>
                            <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>

    </div>

    </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function ($) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#id_product").trigger("change");
            $("#total").trigger("change");
		});

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

        $('#id_product').on('change', function () {
            $.ajax({
                url: "{{ route('material-usage.price') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    'id_product': this.value
                },
                success: function (res) {
                    $('#price').val(res.price);
                    var price = document.getElementById('price');
                    var formated = formatRupiah($('#price').val(), 'Rp. ');
                    price.value = formated;
                }
            });
        });

        $('#qty, #id_product').on('change', function () {
            let idProduct = $('#id_product').val();
            let quantity = $('#qty').val();

            if (idProduct && quantity) {
                $.ajax({
                    url: "{{ route('material-usage.totalPrice') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id_product': idProduct,
                        'qty': quantity
                    },
                    success: function (res) {
                        console.log('test');
                        $('#total').val(res.total);
                        var total = document.getElementById('total');
                        var formated = formatRupiah($('#total').val(), 'Rp. ');
                        total.value = formated;
                    },
                    error: function (xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            } else {
                console.log('Missing product ID or quantity');
            }
        });
    </script>

</x-app-layout>