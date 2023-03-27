<x-app-layout>

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            background-color: #2255a4!important;
            border: none!important;
        }
		.select2-selection--multiple{
			overflow: hidden !important;
			height: auto !important;
		}
    </style>
	
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
						<div class="col-sm-4">
							<select class="select2 form-control custom-select" id="color_id" name="color_id" style="width: 100%;">
								<option></option>
								@foreach($colors as $row)                                
								<option value="{{$row->id}}">{{$row->name}}</option>    
								@endforeach
							</select>
						</div>
						<div class="col-sm-1">
							<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_color" >New</button>
						</div>
					</div>

					<div class="form-group row">
						<label for="color_primer" class="col-sm-2 text-left control-label col-form-label"></label>
						<div class="col-sm-4">
							<select class="select2 form-control custom-select" id="color_primer" name="color_primer" style="width: 100%;">
								<option></option>
								@foreach($colorPrimers as $row)                                
								<option value="{{$row->id}}">{{$row->name}}</option>    
								@endforeach
							</select>
						</div>
						<div class="col-sm-1">
							<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_color_primer" >New</button>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="type_service_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Choose Your Service') }}</label>
						<div class="col-sm-4">
							<select class="select2 form-control custom-select" id="type_service_id" name="type_service_id" style="width: 100%;">
								<option></option>
								@foreach($services as $row)                                
								<option value="{{$row->id}}">{{$row->name}}</option>    
								@endforeach
							</select>
						</div>
						<div class="col-sm-1">
							<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_service" >New</button>
						</div>
					</div>

					<div class="form-group row">
						<label for="car_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Choose Your Car') }}</label>
						<div class="col-sm-4">
							<select class="select2 form-control custom-select" id="car_id" name="car_id" style="width: 100%;">
								<option></option>
								@foreach($cars as $row)                                
								<option value="{{$row->id}}">{{$row->name}} {{$row->year}}</option>    
								@endforeach
							</select>
						</div>
						<div class="col-sm-1">
							<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_car" >New</button>
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
			<div class="card-footer">
				<div class="form-group row">
					<label for="disclaimer" class="col-sm-12 text-left control-label col-form-label">{{ __('Disclaimer') }}</label>
					<div class="col-sm-12">
						<i>{{ isset($setting) ? $setting->disclaimer : '' }}</i>
					</div>
				</div>
			</div>
		</div>


	</div>

    <!-- Modal -->
    <div class="modal fade" id="modal_color" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Color</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for=".name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control name" required="true">
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
    <!-- Modal -->
	
    <!-- Modal -->
    <div class="modal fade" id="modal_color_primer" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Primer Color</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for=".name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control name" required="true">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default add" data-update="primer_color">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
	
    <!-- Modal -->
    <div class="modal fade" id="modal_service" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for=".name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control name" required="true">
                        </div>
                    </div>
					<div class="form-group row">
						<label for=".name" class="col-sm-2 text-left control-label col-form-label">{{ __('Color') }}</label>
						<div class="col-sm-10 input-group">
							<select class="select2 form-select shadow-none mt-3" id="color" name="color" multiple="multiple" style="width: 100%">
								<?php foreach ($colors as $row) { ?>
									<option value="{{ $row->id }}">{{ $row->name }}</option>
								<?php } ?>
							</select>
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default add" data-update="service">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
	
    <!-- Modal -->
    <div class="modal fade" id="modal_car" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Car</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					<div class="form-group row">
						<label for=".name" class="col-sm-2 text-left control-label col-form-label">{{ __('Type') }}</label>
						<div class="col-sm-10 input-group">
							<select class="select2 form-select shadow-none mt-3" id="type" name="type" style="width: 100%">
								<?php foreach ($carType as $row) { ?>
									<option value="{{ $row->id }}">{{ $row->name }}</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for=".name" class="col-sm-2 text-left control-label col-form-label">{{ __('Brand') }}</label>
						<div class="col-sm-10 input-group">
							<select class="select2 form-select shadow-none mt-3" id="brand" name="brand" style="width: 100%">
								<?php foreach ($carBrand as $row) { ?>
									<option value="{{ $row->id }}">{{ $row->name }}</option>
								<?php } ?>
							</select>
						</div>
					</div>
                    <div class="form-group row">
                        <label for=".name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control name" required="true">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for=".name" class="col-sm-2 text-left control-label col-form-label">{{ __('Year') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control year" required="true">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default add" data-update="cars">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
	
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
$('#color_primer').select2({
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

$('.add').on('click', function () {
	data = {};
	data.value = $(this).parent().parent().find('.name').val();
	data.type = $(this).data('update');
	data.color = $(this).parent().parent().find('#color').val();
	data.type_car = $(this).parent().parent().find('#type').val();
	data.brand = $(this).parent().parent().find('#brand').val();
	data.year = $(this).parent().parent().find('.year').val();
	$.ajax({
		url: "{{ route('internal.saveMaster') }}",
		type: 'POST',
		dataType: 'json',
		data: data,
		success: function (res) {
			if (res.success) {
				if(data.type == 'color'){
					$('#color_id').append(res.html)
					$('#color').append(res.html)
				}
				if(data.type == 'primer_color'){
					$('#color_primer').append(res.html)
				}
				if(data.type == 'service'){
					$('#color_id').trigger('change')
				}
				if(data.type == 'cars'){
					$('#car_id').append(res.html)
				}
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
