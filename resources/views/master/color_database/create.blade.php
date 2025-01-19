<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('color-database.index') }}">{{ __('Color
                                    Database') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('color-database.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Create Color Database') }}</h5>
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

                <form class="form-horizontal" action="{{ route('color-database.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="color_code" class="col-sm-2 text-left control-label col-form-label">{{ __('Color
                            Code')
                            }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="color_code" name="color_code"
                                value="{{ old('color_code') }}" placeholder="" required="true">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name')
                            }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                                placeholder="" required="true">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="color_group" class="col-sm-2 text-left control-label col-form-label">{{ __('Color
                            Group')
                            }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="color_group" name="color_group"
                                value="{{ old('color_group') }}" placeholder="" required="true">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="color_category" class="col-sm-2 text-left control-label col-form-label">{{ __('Color
                            Category')
                            }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="color_category" name="color_category"
                                value="{{ old('color_category') }}" placeholder="" required="true">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_car_brands" class="col-sm-2 text-left control-label col-form-label">{{
                            __('Car Brand')
                            }}</label>
                        <div class="col-sm-7">
                            <select class="select2 form-control custom-select" id="id_car_brands" name="id_car_brands"
                                style="width: 100%;">
                                <option></option>
                                @foreach($carBrand as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="code_price" class="col-sm-2 text-left control-label col-form-label">{{ __('Code
                            Price')
                            }}</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="code_price" name="code_price"
                                value="{{ old('code_price') }}" placeholder="" required="true">
                        </div>
                    </div>

                    <div class="border-top"></div>
                    <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("input[id*='cost']").keydown(function (event) {
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
            });
        });    

    </script>

</x-app-layout>