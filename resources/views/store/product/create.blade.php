<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Store') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('store-product.index') }}">{{ __('Product') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('store-product.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Create Product') }}</h5>
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

                <form class="form-horizontal" action="{{ route('store-product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">

                            <div class="form-group row">
                                <label for="type_product" class="col-sm-2 text-left control-label col-form-label">{{ __('Type Item') }}</label>
                                <div class="col-sm-10">
                                    <select class="select2 form-control custom-select" id="type_product_id" name="type_product_id" style="width: 100%;">
                                        @foreach($typeProducts as $typeProduct)                                
                                        <option value="{{$typeProduct->id}}">{{$typeProduct->name}}</option>    
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="barcode" class="col-sm-2 text-left control-label col-form-label">{{ __('Barcode') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="barcode" name="barcode" placeholder="" value="{{ time() }}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name Product" value="{{ old('name') }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Image') }}</label>
                                <div class="col-sm-10">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="validatedCustomFile">{{ __('Choose file...') }}</label>
                                        @error('image')
                                        <div class="invalid-feedback">{{ $message }}k</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Document') }}</label>
                                <div class="col-sm-10">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="document" name="document">
                                        <label class="custom-file-label" for="validatedCustomFile">{{ __('Choose file...') }}</label>
                                        @error('document')
                                        <div class="invalid-feedback">{{ $message }}k</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-6">

                            <div class="form-group row">
                                <label for="qty" class="col-sm-2 text-left control-label col-form-label">{{ __('Qty') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="qty" name="qty" placeholder="" value="{{ old('qty') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="hpp" class="col-sm-2 text-left control-label col-form-label">{{ __('HPP') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="hpp" name="hpp" placeholder="" value="{{ old('hpp') }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="margin_profit" class="col-sm-2 text-left control-label col-form-label">{{ __('Margin Profit (%)') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="margin_profit" name="margin_profit" placeholder="" value="{{ old('margin_profit') }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-sm-2 text-left control-label col-form-label">{{ __('') }}</label>
                                <div class="col-sm-10">
                                    <p style="font-style: italic">Price = HPP + (HPP * Margin Profit (%))</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-sm-2 text-left control-label col-form-label">{{ __('Price') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="price" name="price" placeholder="" value="{{ old('price') }}">
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
    <script>
        document.querySelector('#image').addEventListener('change', function (e) {
            var fileName = document.getElementById("image").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        });

        document.querySelector('#document').addEventListener('change', function (e) {
            var fileName = document.getElementById("document").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
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

            $("input[id*='margin_profit']").keydown(function (event) {
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

            $("input[id*='hpp']").keyup(function (event) {
                var hpp = $('#hpp').val();
                var hpp = hpp.replace(/[^\d,-]/g, '');
                var hpp = hpp.replace(',', '.');

                var margin = $('#margin_profit').val();
                var margin = margin.replace(/[^\d,-]/g, '');
                var margin = margin.replace(',', '.');

                if (parseFloat(hpp) > 0 && parseFloat(margin) > 0) {
                    price(parseFloat(hpp), parseFloat(margin));
                }
            });

            $("input[id*='margin_profit']").keyup(function (event) {
                var hpp = $('#hpp').val();
                var hpp = hpp.replace(/[^\d,-]/g, '');
                var hpp = hpp.replace(',', '.');

                var margin = $('#margin_profit').val();
                var margin = margin.replace(/[^\d,-]/g, '');
                var margin = margin.replace(',', '.');

                if (parseFloat(hpp) > 0 && parseFloat(margin) > 0) {
                    price(parseFloat(hpp), parseFloat(margin));
                }
            });

            $("input[id*='price']").keyup(function (event) {
                var hpp = $('#hpp').val();
                var hpp = hpp.replace(/[^\d,-]/g, '');
                var hpp = hpp.replace(',', '.');

                var total = $('#price').val();
                var total = total.replace(/[^\d,-]/g, '');
                var total = total.replace(',', '.');

                if (parseFloat(hpp) > 0 && parseFloat(total) > 0) {
                    margin(parseFloat(hpp), parseFloat(total));
                }
            });
        });

        var harga = document.getElementById('hpp');
        var price_for = document.getElementById('price');
        $(document).ready(function () {
            var formated = formatRupiah($('#hpp').val(), 'Rp. ');
            harga.value = formated;
            var formated2 = formatRupiah($('#price').val(), 'Rp. ');
            price_for.value = formated2;
        });

        harga.addEventListener('keyup', function (e) {
            harga.value = formatRupiah(this.value, 'Rp. ');
        });

        price_for.addEventListener('keyup', function (e) {
            price_for.value = formatRupiah(this.value, 'Rp. ');
        });

        function formatRupiah(angka, prefix) {
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
        function price(hpp, margin) {
            total = hpp + (hpp * margin / 100);
            var harga = document.getElementById('price');
            harga.value = total;
            var formated = formatRupiah($('#price').val(), 'Rp. ');
            harga.value = formated;
        }

        function margin(hpp, total) {
            total_margin = (total - hpp) * 100 / hpp;
            var margin = document.getElementById('margin_profit');
            val = total_margin.toFixed(2);
            margin.value = val.replace('.', ',');
        }


    </script>
</x-app-layout>