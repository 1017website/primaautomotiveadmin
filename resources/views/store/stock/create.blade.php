<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Store') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('store-stock.index') }}">{{ __('Adjusting Stock') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('store-stock.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Add Adjusting Stock') }}</h5>
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

                <form class="form-horizontal" action="{{ route('store-stock.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">

                            <div class="form-group row">
                                <label for="date" class="col-sm-2 text-left control-label col-form-label">{{ __('Date') }}</label>
                                <div class="col-sm-5 input-group">
                                    <input type="text" class="form-control mydatepicker" id="date" name="date" value="{{ old('date') }}"  placeholder="dd/mm/yyyy">
                                    <div class="input-group-append">
                                        <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-2 text-left control-label col-form-label">{{ __('Description') }}</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="address" name="description" placeholder="Description">{{ old('description') }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="card-title">{{ __('List Item') }}</h5>
                            <button type="button" id="add_item" class="btn btn-default btn-action mt-2 mb-2" data-toggle="modal" data-target="#Modal2">Add Item</button>
                            <div class="border-top"></div>

                            <div class="detail">

                            </div>

                        </div>
                    </div>

                    <div class="border-top"></div>
                    <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="type" class="col-sm-2 text-left control-label col-form-label">{{ __('Type') }}</label>
                        <div class="col-sm-5">
                            <select class="select2 form-control custom-select" id="type" name="type" style="width: 100%;">                              
                                <option value="in">In</option>    
                                <option value="out">Out</option>    
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="product_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Product') }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="product_id" name="product_id" style="width: 100%;">                              
                                @foreach($product as $item)                                
                                <option value="{{$item->id}}">{{$item->name}}</option>    
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
        $(document).ready(function ($) {
            
            $("#product_id").val(null).trigger("change"); 
            
            get_detail();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function get_detail() {
                $.ajax({
                    url: "{{ route('store-stock.detail') }}",
                    type: 'GET',
                    dataType: 'html',
                    success: function (res) {
                        $('.detail').html(res);
                    }
                });
            }

            $("#addItem").click(function () {
                $.ajax({
                    url: "{{ route('store-stock.add') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'type': $('#type').val(),
                        'product_id': $('#product_id').val(),
                        'qty': $('#qty').val(),
                        'price': $('#price').val(),
                    },
                    success: function (res) {
                        if (res.success) {
                            $('#Modal2').modal('toggle');
                            get_detail();
                        }
                    }
                });
            });

            $('#product_id').on('change', function () {
                $.ajax({
                    url: "{{ route('store-stock.price') }}",
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

            var harga = document.getElementById('price');

            $(document).ready(function () {
                var formated = formatRupiah($('#price').val(), 'Rp. ');
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

        });
    </script>

</x-app-layout>