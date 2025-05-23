<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Store') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('store-product.index') }}">{{ __('Product')
                                    }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
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
                <h5 class="card-title">{{ __('Edit Product') }}</h5>
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

                <form class="form-horizontal" action="{{ route('store-product.update', $storeProduct->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-sm-6">

                            <div class="form-group row">
                                <label for="type_product" class="col-sm-2 text-left control-label col-form-label">{{
                                    __('Type Item') }}</label>
                                <div class="col-sm-10">
                                    <select class="select2 form-control custom-select" id="type_product_id"
                                        name="type_product_id" style="width: 100%;">
                                        @foreach($typeProducts as $typeProduct)
                                        <option value="{{$typeProduct->id}}">{{$typeProduct->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="barcode" class="col-sm-2 text-left control-label col-form-label">{{
                                    __('Barcode') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="barcode" name="barcode" placeholder=""
                                        value="{{ $storeProduct->barcode }}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name')
                                    }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Name Product" value="{{ $storeProduct->name }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Image')
                                    }}</label>
                                <div class="col-sm-10">
                                    @if(!empty($storeProduct->image))
                                    <img src="{{ asset($storeProduct->image_url) }}" class="mb-2 img-fluid img-view">
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="validatedCustomFile">{{ __('Choose
                                            file...') }}</label>
                                        @error('image')
                                        <div class="invalid-feedback">{{ $message }}k</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 text-left control-label col-form-label">{{
                                    __('Document') }}</label>
                                <div class="col-sm-10">
                                    @if(!empty($storeProduct->document))
                                    <a href="{{ asset($storeProduct->document_url) }}" target="_blank"><b><i>Download
                                                Current File</i></b></a>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="document" name="document">
                                        <label class="custom-file-label" for="validatedCustomFile">{{ __('Choose
                                            file...') }}</label>
                                        @error('document')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-6">

                            <div class="form-group row">
                                <label for="um" class="col-sm-2 text-left control-label col-form-label">{{ __('Unit')
                                    }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="um" name="um" placeholder="Unit"
                                        value="{{ $storeProduct->um }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="density" class="col-sm-2 text-left control-label col-form-label">{{
                                    __('Density') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="density" name="density"
                                        placeholder="Density" value="{{ $storeProduct->density}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="hpp" class="col-sm-2 text-left control-label col-form-label">{{ __('HPP')
                                    }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="hpp" name="hpp" placeholder=""
                                        value="{{ $storeProduct->hpp }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="margin_profit" class="col-sm-2 text-left control-label col-form-label">{{
                                    __('Margin Profit (%)') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="margin_profit" name="margin_profit"
                                        placeholder="" value="{{ $storeProduct->margin_profit }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-sm-2 text-left control-label col-form-label">{{ __('')
                                    }}</label>
                                <div class="col-sm-10">
                                    <button type="button" id="calculate" class="btn btn-default">Calculate</button>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-sm-2 text-left control-label col-form-label">{{
                                    __('Price') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="price" name="price" placeholder=""
                                        value="{{ $storeProduct->price }}">
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
        $('#type_product_id').val('{{ $storeProduct->type_product_id}}').change();

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
        });

        var harga = document.getElementById('hpp');
        var harga2 = document.getElementById('price');

        $(document).ready(function () {
            var formated = formatRupiah($('#hpp').val(), 'Rp. ');
            harga.value = formated;

            var formated = formatRupiah($('#price').val(), 'Rp. ');
            harga2.value = formated;
        });

        harga.addEventListener('keyup', function (e) {
            harga.value = formatRupiah(this.value, 'Rp. ');
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
        if ($(this).val().indexOf(',') !== - 1 && event.keyCode == 188)
                event.preventDefault();
        //if a decimal has been added, disable the "."-button
        });
        
        $("#calculate").click(function () {
            var hpp = $('#hpp').val();
            hpp = hpp.replace(/[^\d,-]/g, ''); 
            hpp = hpp.replace(',', '.');

            var margin = $('#margin_profit').val();
            if (margin.indexOf(',') !== -1 && margin.indexOf('.') === -1) {
                margin = margin.replace(',', '.');
            }

            var hppNumber = parseFloat(hpp);
            var marginNumber = parseFloat(margin);

            if (hppNumber > 0 && marginNumber > 0) {
                price(hppNumber, marginNumber);
            }
        });

        function price(hpp, margin) {
            var total = hpp + (hpp * margin / 100);
            $('#price').val(formatRupiah(total.toFixed(0), 'Rp. '));
        }

    </script>
</x-app-layout>