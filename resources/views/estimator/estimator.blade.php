<x-app-layout>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Estimator Internal') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

	<div class="container-fluid">
        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
			<div class="row">
				<div class="col-sm-12">

					<h4 class="text-center" style="margin-bottom: 1.5rem;">Estimator Internal</h4>

					<div class="form-group row">
						<label for="color_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Choose Your Color') }}</label>
						<div class="col-sm-10">
							<select class="select2 form-control custom-select" id="color_id" name="color_id" style="width: 100%;">
								<option></option>
								@foreach($colors as $row)                                
								<option value="{{$row->id}}">{{$row->name}}</option>    
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="type_service_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Choose Your Service') }}</label>
						<div class="col-sm-10">
							<select class="select2 form-control custom-select" id="type_service_id" name="type_service_id" style="width: 100%;">
								<option></option>
								@foreach($services as $row)                                
								<option value="{{$row->id}}">{{$row->name}}</option>    
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="car_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Choose Your Car') }}</label>
						<div class="col-sm-10">
							<select class="select2 form-control custom-select" id="car_id" name="car_id" style="width: 100%;">
								<option></option>
								@foreach($cars as $row)                                
								<option value="{{$row->id}}">{{$row->name}} {{$row->year}}</option>    
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-12 text-center">
							<a href="#" type="button" class="btn btn-default" id="btn-estimator">Go</a>
						</div>
					</div>  

					<div class="border-top" style="margin-bottom: 1rem;"></div>

					<div class="cars">

					</div>

				</div>

			</div>
			</div>
		</div>


	</div>

	@stack('modals')        

	<script>
$(document).ready(function () {
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$('#color_id').select2({
	placeholder: "Please select a color"
});
$('#type_service_id').select2({
	placeholder: "Please select a service"
});
$('#car_id').select2({
	placeholder: "Please select a car"
});

$('#color_id').on('change', function () {
	$.ajax({
		url: "{{ route('internal.changeColor') }}",
		type: 'POST',
		dataType: 'json',
		data: {
			'color_id': this.value
		},
		success: function (res) {
			if (res.success) {
				var $select = $("#type_service_id");
				$select.empty().trigger("change");
				var items = res.services;
				var data = [];
				$(items).each(function () {
					if (!$select.find("option[value='" + this.id + "']").length) {
						$select.append(new Option(this.text, this.id, true, true));
					}
					data.push(this.id);
				});
				$select.val(data).trigger('change');
				$select.prepend('<option selected=""></option>').select2({placeholder: "Please select a service"});
			} else {
				popup(res.message, 'error');
			}
		}
	});
});

$('#btn-estimator').on('click', function () {
	if ($("#color_id").val() == '') {
		popup('Color must be selected', 'error');
		return false;
	}

	if ($("#type_service_id").val() == '') {
		popup('Service must be selected', 'error');
		return false;
	}

	if ($("#car_id").val() == '') {
		popup('Car must be selected', 'error');
		return false;
	}

	$.ajax({
		url: "{{ route('internal.showEstimator') }}",
		type: 'POST',
		dataType: 'html',
		data: {
			'color_id': $("#color_id").val(),
			'type_service_id': $("#type_service_id").val(),
			'car_id': $("#car_id").val()
		},
		success: function (res) {
			$('.cars').html(res);
		}
	});
});
});

	</script>
</x-app-layout>
