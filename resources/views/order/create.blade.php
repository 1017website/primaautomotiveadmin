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

                <form class="form-horizontal" action="{{ route('order.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-sm-12">

                            <fieldset class="border p-2">
                                <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('Customer') }}</legend>
                                <div class ="row">
                                    <div class="col-sm-6">

                                        <div class="form-group row">
                                            <label for="date" class="col-sm-2 text-left control-label col-form-label">{{ __('Date') }}</label>
                                            <div class="col-sm-5 input-group">
                                                <input type="text" class="form-control mydatepicker" id="date" name="date" value="{{ old('date') }}" placeholder="dd/mm/yyyy">
                                                <div class="input-group-append">
                                                    <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="cust_name" name="cust_name" value="{{ old('cust_name') }}" required="true">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2 text-left control-label col-form-label">{{ __('Phone') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="cust_phone" name="cust_phone" value="{{ old('cust_phone') }}" required="true">
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
                                            <label for="vehicle_name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="vehicle_name" name="vehicle_name" value="{{ old('vehicle_name') }}" required="true">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="border p-2">
                                <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('List Service') }}</legend>
                                <button type="button" id="addService" class="btn btn-default btn-action mt-2 mb-2" data-toggle="modal" data-target="#Modal2">Add Service</button>
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
            <div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <label for="product_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Service') }}</label>
                                <div class="col-sm-10">
                                    <select class="select2 form-control custom-select" id="service_id" name="service_id" style="width: 100%;">                              
                                        @foreach($service as $row)                                
                                        <option value="{{$row->id}}">{{$row->name}}</option>    
                                        @endforeach
                                    </select>
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
                        'service_id': $('#service_id').val()
                    },
                    success: function (res) {
                        if (res.success) {
                            $('#Modal2').modal('toggle');
                            get_detail();
                        }
                    }
                });
            });

        });
    </script>

</x-app-layout>