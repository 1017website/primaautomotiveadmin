<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('workorder.index') }}">{{ __('Work Order') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Done') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('workorder.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ $workorder->code }}</h5>
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

                <form class="form-horizontal" action="{{ route('workorder.update', $workorder->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-sm-12">

                            <div class ="row">
                                <div class="col-sm-6">

                                    <div class="form-group row">
                                        <label for="date" class="col-sm-2 text-left control-label col-form-label">{{ __('Date') }}</label>
                                        <div class="col-sm-5 input-group">
                                            <input type="text" class="form-control mydatepicker" id="date_done" name="date_done" value="{{ !empty(old('date_done'))?old('date_done'):date('d-m-Y') }}" placeholder="dd/mm/yyyy" autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="document" class="col-sm-2 text-left control-label col-form-label">{{ __('Document') }}</label>
                                        <div class="col-sm-10">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="document" name="document">
                                                <label class="custom-file-label" for="validatedCustomFile">{{ __('Choose file...') }}</label>
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
                        <label for="product_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Item') }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="stock_id" name="stock_id" style="width: 100%;">
                                <option></option>
                                @foreach($items as $item)                                
                                <option value="{{$item->id}}">{{$item->product->name}} - {{ number_format($item->qty, 2, ',', '.') }} - {{ __('Rp. ') }}@price($item->product->price)</option>    
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

                    <input class="hidden" type="text" class="form-control" id="current_qty">

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

            get_detail();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function get_detail() {
                $.ajax({
                    url: "{{ route('detailWork') }}",
                    type: 'GET',
                    dataType: 'html',
                    success: function (res) {
                        $('.detail').html(res);
                    }
                });
            }

            $("#addItem").click(function () {
                let success = true;
                let message = "";
                let currentStock = $('#current_qty').val();
                let stock = $('#qty').val().replace(",", ".");

                if ($('#stock_id').val() == '') {
                    success = false;
                    message = 'Item required';
                }

                if (stock == '') {
                    success = false;
                    message = 'Qty required';
                }

                if ((parseFloat(stock) > parseFloat(currentStock)) && success) {
                    success = false;
                    message = 'Insufficient Stock';
                }

                if (success) {
                    $.ajax({
                        url: "{{ route('addWork') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'stock_id': $('#stock_id').val(),
                            'qty': $('#qty').val(),
                        },
                        success: function (res) {
                            if (res.success) {
                                $('#Modal2').modal('toggle');
                                get_detail();
                            } else {
                                popup(res.message, 'error');
                            }
                        }
                    });
                } else {
                    popup(message, 'error');
                }

            });

            document.querySelector('.custom-file-input').addEventListener('change', function (e) {
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

        });

        $("body").off("change", "#stock_id").on("change", "#stock_id", function (e) {
            $.ajax({
                url: "{{ route('getStock') }}",
                type: 'GET',
                data: {
                    'stock_id': $('#stock_id').val()
                },
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        $('#current_qty').val(res.qty);
                    } else {
                        popup(res.message, 'error');
                    }
                }
            });
        });

    </script>

</x-app-layout>