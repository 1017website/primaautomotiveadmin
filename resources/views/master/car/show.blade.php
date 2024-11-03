<x-app-layout>

    <style>
        .car-images {
            background-color: #e9ecef;
            padding: 1rem;
            border-radius: 0.375rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
            --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-width: 1px;
            line-height: 1.5rem;
            --tw-shadow: 0 0 #0000;
            --tw-border-opacity: 1;
            border-color: rgb(209 213 219 / var(--tw-border-opacity));
            height: auto;
        }
    </style>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('car.index') }}">{{ __('Car') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
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
                <h5 class="card-title">{{ __('Detail Car') }}</h5>
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
                    <label for="images" class="col-sm-2 text-left control-label col-form-label">{{ __('Car
                        Images')}}</label>
                    <div class="col-sm-10">
                        <div class="car-images">
                            <div class="row">
                                @foreach($carImages as $images)
                                <div class="col-sm-3">
                                    <img src="{{asset($images->image_url)}}" class="default-border-radius" style="height:20rem;width:100%;object-fit: cover"/>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="car_type_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Type')
                        }}</label>
                    <div class="col-sm-10">
                        <select class="select2 form-control custom-select" id="car_type_id" name="car_type_id"
                            style="width: 100%;" disabled>
                            <option value="{{$car->car_type_id}}" selected>{{$car->type->name}}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="car_type_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Brand')
                        }}</label>
                    <div class="col-sm-10">
                        <select class="select2 form-control custom-select" id="car_brand_id" name="car_brand_id"
                            style="width: 100%;" disabled>
                            <option value="{{$car->car_brand_id}}" selected>{{$car->brand->name}}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name')
                        }}</label>
                    <div class="col-sm-10">
                        <input value="{{ $car->name }}" type="text" class="form-control" id="name" name="name"
                            placeholder="Name Car" required="true" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="year" class="col-sm-2 text-left control-label col-form-label">{{ __('Year')
                        }}</label>
                    <div class="col-sm-10">
                        <input value="{{ $car->year }}" type="text" class="form-control" id="year" name="year"
                            placeholder="Year Car" required="true" disabled>
                    </div>
                </div>

                <div class="border-top"></div>
                <fieldset class="border p-2">
                    <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('Profile Car') }}</legend>
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
				url: "{{ route('detailCarShow') }}",
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
    </script>

</x-app-layout>