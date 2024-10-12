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
                        <label for="id_color_code" class="col-sm-2 text-left control-label col-form-label">{{ __('Color
                            Code')
                            }}</label>
                        <div class="col-sm-7">
                            <select class="select2 form-control custom-select" id="id_color_code" name="id_color_code"
                                style="width: 100%;">
                                <option></option>
                                @foreach($colorCode as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-info" data-toggle="modal"
                                data-target="#modal_color">New</button>
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
                        <label for="id_color_group" class="col-sm-2 text-left control-label col-form-label">{{ __('Color
                            Group')
                            }}</label>
                        <div class="col-sm-7">
                            <select class="select2 form-control custom-select" id="id_color_group" name="id_color_group"
                                style="width: 100%;">
                                <option></option>
                                @foreach($colorGroup as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-info" data-toggle="modal"
                                data-target="#modal_color_group">New</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_color_category" class="col-sm-2 text-left control-label col-form-label">{{
                            __('Color Category')
                            }}</label>
                        <div class="col-sm-7">
                            <select class="select2 form-control custom-select" id="id_color_category"
                                name="id_color_category" style="width: 100%;">
                                <option></option>
                                @foreach($colorCategory as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-info" data-toggle="modal"
                                data-target="#modal_color_category">New</button>
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

        <!-- Modal for Add Color Code -->
        <div class="modal fade" id="modal_color" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Color Code</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for=".name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name')
                                }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control name" required="true">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for=".id_color_group" class="col-sm-2 text-left control-label col-form-label">{{
                                __('Color
                                Group')
                                }}</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control custom-select id_color_group" id="id_color_group"
                                    name="id_color_group" style="width: 100%;">
                                    <option></option>
                                    @foreach($colorGroup as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-default add" data-update="color">Add</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Add Color Group -->
        <div class="modal fade" id="modal_color_group" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Color Group</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for=".name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name')
                                }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control name" required="true">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-default add" data-update="colorGroup">Add</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Add Color Category -->
        <div class="modal fade" id="modal_color_category" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Color Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for=".name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name')
                                }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control name" required="true">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for=".cost" class="col-sm-2 text-left control-label col-form-label">{{ __('Cost (%)')
                                }}</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control cost" id="cost" name="cost" placeholder=""
                                    required="true" step="0.01">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-default add" data-update="colorCategory">Add</button>
                    </div>
                </div>
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

            $('.add').on('click', function () {
                data = {};
                data.value = $(this).parent().parent().find('.name').val();
                data.type = $(this).data('update');
                data.color = $(this).closest('.modal-content').find('.name').val();
                data.colorGroup = $(this).closest('.modal-content').find('.id_color_group').val();
                data.cost = $(this).closest('.modal-content').find('.cost').val();
                $.ajax({
                    url: "{{ route('color-database.saveMaster') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function (res) {
                        console.log(data);
                        if (res.success) {
                            if (data.type == 'color') {
                                popup(res.message, 'success');
                                console.log(res.html);
                                $('#id_color_code').append(res.html)
                            }
                            if (data.type == 'colorGroup') {
                                popup(res.message, 'success');
                                console.log(res.html);
                                $('#id_color_group').append(res.html)
                            }
                            if (data.type == 'colorCategory') {
                                popup(res.message, 'success');
                                console.log(res.html);
                                $('#id_color_category').append(res.html)
                            }
                            $(".modal:visible").modal('toggle');
                        } else {
                            popup(res.message, 'error');
                        }
                    }
                });
            });
        });    

    </script>

</x-app-layout>