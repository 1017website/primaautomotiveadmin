<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Store') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('mix.index') }}">{{ __('Mixing Color') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('mix.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Add Mixing Color') }}</h5>
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

                <form class="form-horizontal" action="{{ route('mix.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-sm-5">

                            <div class="form-group row">
                                <label for="date" class="col-sm-12 text-left control-label col-form-label">{{ __('Date') }}</label>
                                <div class="col-sm-5 input-group">
                                    <input type="text" class="form-control mydatepicker" id="date" name="date" value="{{ empty(old('date'))?date('d/m/Y'):old('date') }}"  placeholder="dd/mm/yyyy">
                                    <div class="input-group-append">
                                        <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-12 text-left control-label col-form-label">{{ __('Description') }}</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="address" name="description" placeholder="Description">{{ old('description') }}</textarea>
                                </div>
                            </div>
						</div>
						<div class="col-sm-7">
							<div class="form-group row">
								<div class="col-sm-3">
									<label for="rack_id" class="text-left control-label col-form-label">{{ __('Rack') }}</label>
                                    <select class="select2 form-control custom-select" id="rack_id" name="rack_id" style="width: 100%;" onchange="getproduct()">
                                        @foreach($mixingRack as $v)                                
											<option value="{{$v->id}}">{{$v->name}}</option>    
                                        @endforeach
                                    </select>
								</div>
							</div>
							<div class="form-group row">
                                <div class="col-sm-3">
									<label for="product" class="text-left control-label col-form-label">{{ __('Product') }}</label>
									<select class="select2 form-control custom-select" id="product" name="product" style="width: 100%;">                              
										<option value="0">New</option>
										<?php foreach($product as $v){ ?>
											<option value="<?= $v->id ?>" data-code="<?= $v->barcode ?>"
												data-berat_jenis="<?= $v->berat_jenis ?>"
												data-name="<?= $v->name ?>"
												data-price="<?= $v->price ?>"
												data-um="<?= $v->um ?>"
												data-type="<?= $v->type_product_id ?>"
											><?= $v->name ?></option>
										<?php } ?>
										
									</select>
								</div>
								<div class="col-sm-3">
									<label for="name" class="text-left control-label col-form-label">{{ __('Name') }}</label>
									<input type="text" class="form-control" id="name" name="name" >
								</div>
							</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="card-title">{{ __('List Item') }}</h5>
                            <button type="button" id="add_item" class="btn btn-default btn-action mt-2 mb-2" data-toggle="modal" data-target="#Modal2">Add Item</button>
                            <div class="border-top"></div>

                            <div class="detail">

                            </div>

                        </div>
                    </div>

                    <div class="border-top"></div>
                    <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="product_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Product') }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="product_id" name="product_id" style="width: 100%;">                              

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="qty" class="col-sm-2 text-left control-label col-form-label">{{ __('Weight') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="weight" name="weight" required="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default" id="addItem">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <script type="text/javascript">
		bahanList = [];
		var bahan = function () {
			this.product = '';
			this.name = '';
			this.rack_id = '';
		}

		$('#product').on('change', function () {
			if($('#product option:selected').data('code') != undefined){
				$('#code').val($('#product option:selected').data('code'));
				$('#code').attr('readonly',true)
				$('#add_item').hide()
			}else{
				$('#code').val('');
				$('#add_item').show()
				$('#code').attr('readonly',false)
			}
			if($('#product option:selected').data('name') != undefined){
				$('#name').val($('#product option:selected').data('name'));
				$('#name').attr('readonly',true)
			}else{
				$('#name').val('');
				$('#name').attr('readonly',false)
			}
			$('#type_product_id').attr('disabled',false)
			if($('#product option:selected').data('type') != undefined){
				$('#type_product_id').val($('#product option:selected').data('type')).trigger('change');
				$('#type_product_id').attr('disabled',true)
			}
			if($('#product option:selected').data('um') != undefined){
				$('#um').val($('#product option:selected').data('um'));
				$('#um').attr('readonly',true)
			}else{
				$('#um').val('');
				$('#um').attr('readonly',false)
			}
			if($('#product option:selected').data('berat_jenis') != undefined){
				$('#berat_jenis').val($('#product option:selected').data('berat_jenis'));
				$('#berat_jenis').attr('readonly',true)
			}else{
				$('#berat_jenis').val('')
				$('#berat_jenis').attr('readonly',false)
			}

			$.ajax({
				url: "{{ route('mix.ingredient') }}",
				type: 'POST',
				dataType: 'json',
				data: {
					'id': $('#product').val()
				},
				success: function (res) {
					if (res.success) {
						get_detail();
					}else{
						get_detail();
					}
				}
			});
		});
		
		function getproduct(){
			html = ''
			$.each(bahanList, function(index, val){
				
				if(val.rack_id == $('#rack_id').val())
				{
					html += '<option value="'+val.product+'">'+val.name+'</option>';
				}
				
			});
			$("#product_id").html(html)
            $("#product_id").val(null).trigger("change"); 
		}
        $(document).ready(function ($) {
			<?php foreach($bahan as $v){ ?>
				tmp = new bahan();
				tmp.product = '<?= $v->product_id ?>'
				tmp.name = '<?= $v->product->name ?>'
				tmp.rack_id = '<?= $v->rack_id ?>'
				bahanList.push(tmp);
			<?php }?>

            getproduct();
            get_detail();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#addItem").click(function () {
                $.ajax({
                    url: "{{ route('mix.add') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'product_id': $('#product_id').val(),
                        'qty': $('#weight').val(),
						'rack_id': $('#rack_id').val()
                    },
                    success: function (res) {
                        if (res.success) {
                            $('#Modal2').modal('toggle');
                            get_detail();
                        }
                    }
                });
            });
			
            $(function () {
                $("input[id*='qty']").keydown(function (event) {
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

        });
		function formatRupiah(angka, prefix)
		{
			console.log(angka);
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
		function get_detail() {
			$.ajax({
				url: "{{ route('mix.detail') }}",
				type: 'GET',
				data: {
					'rack_id': $('#rack_id').val()
				},
				dataType: 'html',
				success: function (res) {
					$('.detail').html(res);
				}
			});
		}
    </script>

</x-app-layout>