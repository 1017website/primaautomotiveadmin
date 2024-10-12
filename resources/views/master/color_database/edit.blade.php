<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('color-database.index') }}">{{ __('Color Database') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
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
                <h5 class="card-title">{{ __('Edit Color Database') }}</h5>
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

                <form class="form-horizontal" action="{{ route('color-database.update', $colorDatabase->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="id_color_code" class="col-sm-2 text-left control-label col-form-label">{{ __('Color Code')
                            }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="id_color_code" name="id_color_code"
                                style="width: 100%;">
                                @if($colorDatabase->id_color_code != 0)
                                <option value="{{$colorDatabase->id_color_code}}">{{$colorDatabase->code->name}}</option>
                                @foreach($colorCode as $row)
                                @if ($row->id != $colorDatabase->code->id)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endif
                                @endforeach
                                @else
                                <option></option>
                                @foreach($colorCode as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name')
                            }}</label>
                        <div class="col-sm-10">
                            <input value="{{ $colorDatabase->name }}" type="text" class="form-control" id="name" name="name"
                                placeholder="" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Color Group')
                            }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="id_color_group" name="id_color_group"
                                style="width: 100%;">
                                @if($colorDatabase->id_color_group != 0)
                                <option value="{{$colorDatabase->id_color_group}}">{{$colorDatabase->group->name}}</option>
                                @foreach($colorGroup as $row)
                                @if ($row->id != $colorDatabase->group->id)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endif
                                @endforeach
                                @else
                                <option></option>
                                @foreach($colorGroup as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Color Category')
                            }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="id_color_category" name="id_color_category"
                                style="width: 100%;">
                                @if($colorDatabase->id_color_category != 0)
                                <option value="{{$colorDatabase->id_color_category}}">{{$colorDatabase->category->name}}</option>
                                @foreach($colorCategory as $row)
                                @if ($row->id != $colorDatabase->category->id)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endif
                                @endforeach
                                @else
                                <option></option>
                                @foreach($colorCategory as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Car Brand')
                            }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="id_car_brands" name="id_car_brands"
                                style="width: 100%;">
                                @if($colorDatabase->id_car_brands != 0)
                                <option value="{{$colorDatabase->id_car_brands}}">{{$colorDatabase->brand->name}}</option>
                                @foreach($carBrand as $row)
                                @if ($row->id != $colorDatabase->brand->id)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endif
                                @endforeach
                                @else
                                <option></option>
                                @foreach($carBrand as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="code_price" class="col-sm-2 text-left control-label col-form-label">{{ __('Code
                            Price')
                            }}</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="code_price" name="code_price"
                                value="{{ $colorDatabase->code_price }}" placeholder="" required="true">
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
			

            $('#id_color_code').on('change', function() {
                let selectedValue = $(this).val();
                if (selectedValue) {
                    $.ajax({
                        url: "{{ route('color-database.getColorGroups') }}",
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            'id_color_code': selectedValue
                        },
                        success: function(data) {
                            $('#id_color_group').append('<option></option>'); 
                            
                            $('#id_color_group').append('<option selected value="'+ data.id +'">'+ data.name +'</option>');
                            
                            if (data.length > 0) {
                                $('#id_color_group').val(data[0].id); 
                            }
                        },
                        error: function(err) {
                            console.error("Error fetching color groups:", err);
                        }
                    });
                } else {
                    $('#id_color_group').empty();
                    $('#id_color_group').append('<option></option>'); 
                }
            });
        });

    </script>

</x-app-layout>