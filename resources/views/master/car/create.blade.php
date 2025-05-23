<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('car.index') }}">{{ __('Car') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
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
                <h5 class="card-title">{{ __('Create Car') }}</h5>
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


                <div class="form-group row">
                    <label for="images" class="col-sm-2 control-label">Images</label>
                    <div class="col-sm-10">
                        <form method="post" action="{{url('/car/uploadImages')}}" enctype="multipart/form-data"
                            class="dropzone" id="dropzoneImages">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

                <form class="form-horizontal" action="{{ route('car.store') }}" method="POST">
                    @csrf

                    <div class="form-group row">
                        <label for="car_type_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Type')
                            }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="car_type_id" name="car_type_id"
                                style="width: 100%;">
                                @foreach($carType as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="car_type_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Brand')
                            }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="car_brand_id" name="car_brand_id"
                                style="width: 100%;">
                                @foreach($carBrand as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name')
                            }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                                placeholder="Name Car" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="year" class="col-sm-2 text-left control-label col-form-label">{{ __('Year')
                            }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="year" name="year" value="{{ old('year') }}"
                                placeholder="Year Car" required="true">
                        </div>
                    </div>

                    <div class="border-top"></div>
                    <div class="form-group row">
                        <div class="col-sm-12 pull-right">
                            <button type="submit" class="btn btn-default btn-action">Save</button>
                        </div>
                    </div>
                </form>
                <fieldset class="border p-2">
                    <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('Profile Car') }}</legend>
                    <div class="row">
                        <div class="col-sm-5">
                            <select class="select2 form-control custom-select" id="service_id" name="service_id"
                                style="width: 100%;">
                                @foreach($service as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-default btn-action add">{{ __('Add') }}</button>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-sm-6">
                            <div class="detail">

                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            get_detail()
        });

        $(".add").click(function () {
            $.ajax({
                url: "{{ route('car.addCar') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    'service_id': $('#service_id').val()
                },
                success: function (res) {
                    if (res.success) {
                        get_detail();
                    } else {
                        popup(res.message, 'error');
                    }
                }
            });
        });

        function deleteTemp(id) {
            $.ajax({
                url: "{{ route('car.deleteCar') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    'service_id': id
                },
                success: function (res) {
                    if (res.success) {
                        get_detail();
                    } else {
                        popup(res.message, 'error');
                    }
                }
            });
        }

        function get_detail() {
            $.ajax({
                url: "{{ route('detailCar') }}",
                type: 'GET',
                data: {
                    'car_id': '0'
                },
                dataType: 'html',
                success: function (res) {
                    $('.detail').html(res);
                }
            });
        }

        //process upload
        Dropzone.options.dropzoneImages = {
        url: "{{ url('car/uploadTempImages') }}", // Set the upload URL
        method: "post", // Use POST method
        thumbnailWidth: null,
        thumbnailHeight: null,
        uploadMultiple: true,
        maxFilesize: 1, // Max file size in MB
        maxFiles: 5,
        parallelUploads: 1,
        renameFile: function (file) {
            var dt = new Date();
            var time = dt.getTime();
            let newName = time + '_' + file.name;
            file.newName = newName;
            return newName;
        },
        acceptedFiles: ".jpeg,.jpg,.png",
        addRemoveLinks: true,
        timeout: 50000,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') // CSRF token for Laravel
        },
        init: function () {
            var existingFiles = <?php echo json_encode($carImages); ?>;
            myDropzone = this;
            $.each(existingFiles, function (key, value) {
                var mockFile = {
                    name: value.image,
                    size: value.size,
                    status: Dropzone.ADDED,
                    url: "{{ asset('') }}" + value.image_url,
                };
                myDropzone.emit("addedfile", mockFile);
                myDropzone.emit("thumbnail", mockFile, mockFile.url);
                myDropzone.emit("complete", mockFile);
                myDropzone.files.push(mockFile);
            });

            this.on("sending", function (file, xhr, formData) {
                formData.append("filesize", file.size);
            });
        },
        success: function (file, response) {
            Command: toastr["success"]("File has been successfully added");
        },
        error: function (file, response) {
            Command: toastr["error"](response);
        },
        removedfile: function (file) {
            var name = file.newName ? file.newName : file.name;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url("car/deleteImages") }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    filename: name
                },
                success: function (data) {
                    Command: toastr["success"]("File has been successfully removed");
                },
                error: function (e) {
                    console.log(e);
                }
            });
            var fileRef;
            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        }
    };


    </script>

</x-app-layout>