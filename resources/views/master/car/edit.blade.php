<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('car.index') }}">{{ __('Car') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('car.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Edit Car') }}</h5>
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

                <form class="form-horizontal" action="{{ route('car.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="car_type_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Type') }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="car_type_id" name="car_type_id" style="width: 100%;">
                                @foreach($carType as $row)                                
                                <option value="{{$row->id}}">{{$row->name}}</option>    
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="car_type_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Brand') }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="car_brand_id" name="car_brand_id" style="width: 100%;">
                                @foreach($carBrand as $row)                                
                                <option value="{{$row->id}}">{{$row->name}}</option>    
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                        <div class="col-sm-10">
                            <input value="{{ $car->name }}" type="text" class="form-control" id="name" name="name" placeholder="Name Car" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="year" class="col-sm-2 text-left control-label col-form-label">{{ __('Year') }}</label>
                        <div class="col-sm-10">
                            <input value="{{ $car->year }}" type="text" class="form-control" id="year" name="year" placeholder="Year Car" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="images" class="col-sm-2 text-left control-label col-form-label">{{ __('Image') }}</label>
                        <div class="col-sm-10">
                            <input required type="file" class="form-control" name="images[]" placeholder="images" multiple>
                        </div>
                    </div>



                    <div class="border-top"></div>
                    <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>

    </div>

    <script>
        $('#car_type_id').val('{{ $car->car_type_id}}').change();
        $('#car_brand_id').val('{{ $car->car_brand_id}}').change();


    </script>

</x-app-layout>