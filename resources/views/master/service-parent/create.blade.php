<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('service-parent.index') }}">{{ __('Service') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('service-parent.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Create Service') }}</h5>
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

                <form class="form-horizontal" action="{{ route('service-parent.store') }}" method="POST">
                    @csrf

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

                    <div class="border-top"></div>
                    <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>

    </div>

    <script>
        var harga = document.getElementById('s');
		var harga2 = document.getElementById('m');
		var harga3 = document.getElementById('l');
		var harga4 = document.getElementById('xl');
        $(document).ready(function () {
            var formated = formatRupiah($('#s').val(), 'Rp. ');
            harga.value = formated;
			var formated = formatRupiah($('#m').val(), 'Rp. ');
			harga2.value = formated;
			var formated = formatRupiah($('#l').val(), 'Rp. ');
			harga3.value = formated;
			var formated = formatRupiah($('#xl').val(), 'Rp. ');
			harga4.value = formated;
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
    </script>

</x-app-layout>