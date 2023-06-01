<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Service') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('service-parent.create') }}">{{ __('Create') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Service') }}</h5>
                <div class="border-top"></div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {!! $message !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="table-responsive">
                    <table id="service" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th rowspan=2>{{ __('Type Service') }}</th>
                                <th rowspan=2>{{ __('Name') }}</th>
                                <th colspan=4>{{ __('Estimated Costs') }}</th>
                                <th rowspan=2>{{ __('Panel') }}</th>
                                <th rowspan=2>{{ __('Created By') }}</th>
                                <th rowspan=2>{{ __('Updated By') }}</th>
                                <th rowspan=2>{{ __('Action') }}</th>
                            </tr>
							<tr>
                                <th>{{ __('S') }}</th>
                                <th>{{ __('M') }}</th>
                                <th>{{ __('L') }}</th>
                                <th>{{ __('XL') }}</th>
							</tr>
                        </thead>
                        <tbody>
                            @foreach ($service as $row)
                            <tr>
                                <td>{{ isset($row->typeService) ? $row->typeService->name : 'Additional' }}</td>
                                <td>{{ $row->name }}</td>
								<?php $s = '<td></td>'; $m = '<td></td>'; $l = '<td></td>'; $xl = '<td></td>';
								foreach($row->service as $v){
									if($v->type == 's')
										$s = "<td>Rp.". number_format($v->estimated_costs)."</td>";
									if($v->type == 'm')
										$m = "<td>Rp.".number_format($v->estimated_costs)."</td>";
									if($v->type == 'l')
										$l = "<td>Rp.".number_format($v->estimated_costs)."</td>";
									if($v->type == 'xl')
										$xl = "<td>Rp.".number_format($v->estimated_costs)."</td>";
								}
								echo $s.$m.$l.$xl;
								?>
                                <td align="right" data-order="{{ $row->panel }}">@price($row->panel)</td>
                                <td>{{ isset($row->userCreated) ? $row->userCreated->name : '-' }}</td>
                                <td>{{ isset($row->userUpdated) ? $row->userUpdated->name : '-' }}</td>
                                <td class="action-button">
									<button class="btn btn-warning btn-edit" data-id="{{ $row->id }}"><i class="fas fa-pencil-alt"></i></button>
                                    <form action="{{ route('service-parent.destroy',$row->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

	<div class="modal fade" id="Modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
				</div>
				<div class="modal-body">
                    <div class="form-group row">
                        <label for="type_service_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Type Service') }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="type_service_id" name="type_service_id" style="width: 100%;">
                                <option value="">Additional</option>
                                @foreach($typeService as $row)                                
                                <option value="{{$row->id}}">{{$row->name}}</option>    
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Name Service" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="estimated_costs" class="col-sm-2 text-left control-label col-form-label">{{ __('S') }}</label>
                        <div class="col-sm-10">
                            <input value="0" type="text" class="form-control" id="s" name="s" placeholder="S Costs">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="estimated_costs" class="col-sm-2 text-left control-label col-form-label">{{ __('M') }}</label>
                        <div class="col-sm-10">
                            <input value="0" type="text" class="form-control" id="m" name="m" placeholder="M Costs">
                        </div>
                    </div>
					
                    <div class="form-group row">
                        <label for="estimated_costs" class="col-sm-2 text-left control-label col-form-label">{{ __('L') }}</label>
                        <div class="col-sm-10">
                            <input value="0" type="text" class="form-control" id="l" name="l" placeholder="L Costs">
                        </div>
                    </div>
					
                    <div class="form-group row">
                        <label for="estimated_costs" class="col-sm-2 text-left control-label col-form-label">{{ __('XL') }}</label>
                        <div class="col-sm-10">
                            <input value="0" type="text" class="form-control" id="xl" name="xl" placeholder="XL Costs">
                        </div>
                    </div>
					
                    <div class="form-group row">
                        <label for="panel" class="col-sm-2 text-left control-label col-form-label">{{ __('Panel') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="panel" name="panel" required="" value="{{ old('panel') }}">
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default" id="updateService">Save</button>
				</div>
			</div>
		</div>
	</div>
	
    <script>
        $('#service').DataTable();
    </script>

	<script>
        var harga = document.getElementById('s');
		var harga2 = document.getElementById('m');
		var harga3 = document.getElementById('l');
		var harga4 = document.getElementById('xl');

        $(document).ready(function ($) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
		
        harga.addEventListener('keyup', function (e) {
            harga.value = formatRupiah(this.value, 'Rp. ');
        });

        harga2.addEventListener('keyup', function (e) {
            harga2.value = formatRupiah(this.value, 'Rp. ');
        });
        harga3.addEventListener('keyup', function (e) {
            harga3.value = formatRupiah(this.value, 'Rp. ');
        });
        harga4.addEventListener('keyup', function (e) {
            harga4.value = formatRupiah(this.value, 'Rp. ');
        });
		
        function formatRupiah(angka, prefix)
        {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
		
        $(function () {
            $("input[id*='panel']").keydown(function (event) {
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
                if ($(this).val().indexOf(',') !== -1 && event.keyCode == 188)
                    event.preventDefault();
                //if a decimal has been added, disable the "."-button
            });
        });
		
		function format_rp(){
            var formated = formatRupiah($('#s').val(), 'Rp. ');
            harga.value = formated;
			var formated = formatRupiah($('#m').val(), 'Rp. ');
			harga2.value = formated;
			var formated = formatRupiah($('#l').val(), 'Rp. ');
			harga3.value = formated;
			var formated = formatRupiah($('#xl').val(), 'Rp. ');
			harga4.value = formated;
		}
		
        var editId = 0;
        $(".btn-edit").click(function () {
            editId = $(this).data('id')
			
            $.ajax({
                url: "{{ route('serviceParent.editCustom') }}",
                type: 'POST',
                data: {
                    'id': editId,
                },
                dataType: 'JSON',
                success: function (res) {
					$('#type_service_id').val(res.type).trigger('change');
					$('#name').val(res.name);
					$('#s').val(res.s);
					$('#m').val(res.m);
					$('#l').val(res.l);
					$('#xl').val(res.xl);
					$('#panel').val(res.panel);
					format_rp()
					$('#Modal').modal('show');
                }
            });
        });

        $("#updateService").click(function () {

            $(this).prop('disabled', true);
            $.ajax({
                url: "{{ route('serviceParent.updateService') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    'id': editId,
                    'name': $('#name').val(),
					's': $('#s').val(),
					'm': $('#m').val(),
					'l': $('#l').val(),
					'xl': $('#xl').val(),
					'panel': $('#panel').val(),
                    'type_service_id': $('#type_service_id').val()
                },
                success: function (res) {
					location.reload()
                    if (res.success) {
                        $("#updateOrder").prop('disabled', false);
                        $('#Modal').modal('hide');
                        editId = 0;
                    } else {
                        $("#updateOrder").prop('disabled', false);
						$(this).prop('disabled', false);
                        alert(res.message)
                    }
                }
            });
        });
	</script>
</x-app-layout>