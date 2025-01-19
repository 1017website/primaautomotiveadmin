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

                <div class="form-group row">
                    <label for="images" class="col-sm-2 control-label">Images</label>
                    <div class="col-sm-10">
                        <form method="post" action="{{url('/car/uploadImages')}}" enctype="multipart/form-data"
                            class="dropzone" id="dropzoneImages">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

                <form class="form-horizontal" action="{{ route('car.update', $car->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                            <input value="{{ $car->name }}" type="text" class="form-control" id="name" name="name"
                                placeholder="Name Car" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="year" class="col-sm-2 text-left control-label col-form-label">{{ __('Year')
                            }}</label>
                        <div class="col-sm-10">
                            <input value="{{ $car->year }}" type="text" class="form-control" id="year" name="year"
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
                </fieldset>
            </div>
        </div>

    </div>

    <script>
        $('#car_type_id').val('{{ $car->car_type_id}}').change();
        $('#car_brand_id').val('{{ $car->car_brand_id}}').change();

$(document).ready(function(){
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
					'service_id': $('#service_id').val(),
					'car_id': '<?= $car->id ?>'
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
		
		function deleteTemp(id){
			$.ajax({
				url: "{{ route('car.deleteCar') }}",
				type: 'POST',
				dataType: 'json',
				data: {
					'service_id': id,
					'car_id': '<?= $car->id ?>'
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
            thumbnailWidth: null,
            thumbnailHeight: null,
            uploadMultiple: true,
            maxFilesize: 1, // 1MB limit
            maxFiles: 5,
            parallelUploads: 1,
            renameFile: function(file) {
                const timestamp = Date.now();
                const newName = `${timestamp}_${file.name}`;
                file.newName = newName;
                return newName;
            },
            acceptedFiles: ".jpeg,.jpg,.png",
            addRemoveLinks: true,
            timeout: 50000,
            init: function() {
                const existingFiles = @json($carImages);
                const dropzoneInstance = this;

                existingFiles.forEach(function(file) {
                    const mockFile = {
                        name: file.image,
                        size: file.size,
                        url: `{{ asset('') }}${file.image_url}`,
                    };
                    dropzoneInstance.emit("addedfile", mockFile);
                    dropzoneInstance.emit("thumbnail", mockFile, mockFile.url);
                    dropzoneInstance.emit("complete", mockFile);
                    dropzoneInstance.files.push(mockFile);
                });

                this.on("sending", function(file, xhr, formData) {
                    formData.append("filesize", file.size);
                });
            },
            removedfile: function(file) {
                const fileName = file.newName || file.name;
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    type: 'POST',
                    url: '{{ url("car/deleteImages") }}',
                    data: { _token: "{{ csrf_token() }}", filename: fileName },
                    success: function() {
                        toastr.success("File has been successfully removed");
                    },
                    error: function(error) {
                        console.error(error);
                        toastr.error("Failed to remove file.");
                    },
                });

                const fileRef = file.previewElement;
                if (fileRef) fileRef.parentNode.removeChild(fileRef);
            },
            success: function(file, response) {
                toastr.success("File has been successfully added");
            },
            error: function(file, response) {
                toastr.error(response);
            },
        };
    </script>

</x-app-layout>