<x-app-layout>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">

                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Setting') }}</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Setting General') }}</h5>
                <div class="border-top"></div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {!! $message !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

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

                <form class="form-horizontal" action="{{ route('setting.store') }}" method="POST">
                    @csrf

                    <div class="form-group row">
                        <label for="code" class="col-sm-2 text-left control-label col-form-label">{{ __('Code Store') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="code" name="code" value="{{ isset($setting) ? $setting->code : '' }}" placeholder="Code Store" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="backend_url" class="col-sm-2 text-left control-label col-form-label">{{ __('Backend Url') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="backend_url" name="backend_url" value="{{ isset($setting) ? $setting->backend_url : '' }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="frontend_url" class="col-sm-2 text-left control-label col-form-label">{{ __('Frontend Url') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="frontend_url" name="frontend_url" value="{{ isset($setting) ? $setting->frontend_url : '' }}">
                        </div>
                    </div>

                    <h5 class="card-title">{{ __('Setting Print') }}</h5>
                    <div class="border-top"></div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ isset($setting) ? $setting->name : '' }}" placeholder="Name" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-sm-2 text-left control-label col-form-label">{{ __('Address') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="address" name="address" value="{{ isset($setting) ? $setting->address : '' }}" placeholder="Address" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 text-left control-label col-form-label">{{ __('Phone') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ isset($setting) ? $setting->phone : '' }}" placeholder="Phone" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 text-left control-label col-form-label">{{ __('Email') }}</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" value="{{ isset($setting) ? $setting->email : '' }}" placeholder="Email" required="true">
                        </div>
                    </div>

                    <h5 class="card-title">{{ __('Setting Bonus') }}</h5>
                    <div class="border-top"></div>

                    <div class="form-group row">
                        <label for="target_panel" class="col-sm-2 text-left control-label col-form-label">{{ __('Target Panel') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control numb" id="target_panel" name="target_panel" value="{{ isset($setting) ? $setting->target_panel : '' }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="target_revenue" class="col-sm-2 text-left control-label col-form-label">{{ __('Target Revenue') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control numb" id="target_revenue" name="target_revenue" value="{{ isset($setting) ? $setting->target_revenue : '' }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="bonus_panel" class="col-sm-2 text-left control-label col-form-label">{{ __('Bonus/Panel') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control numb" id="bonus_panel" name="bonus_panel" value="{{ isset($setting) ? $setting->bonus_panel : '' }}">
                        </div>
                    </div>

                    <div class="border-top"></div>
                    <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>
    </div>

    <script>
        $(function () {
            $("input[class*='numb']").keydown(function (event) {
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

        var harga1 = document.getElementById('target_revenue');
        $(document).ready(function () {
            console.log(harga1.value);
            var formated = formatRupiah($('#target_revenue').val(), 'Rp. ');
            harga1.value = formated;
        });
        harga1.addEventListener('keyup', function (e) {
            harga1.value = formatRupiah(this.value, 'Rp. ');
        });

        var harga2 = document.getElementById('bonus_panel');
        $(document).ready(function () {
            console.log(harga2.value);
            var formated = formatRupiah($('#bonus_panel').val(), 'Rp. ');
            harga2.value = formated;
        });
        harga2.addEventListener('keyup', function (e) {
            harga2.value = formatRupiah(this.value, 'Rp. ');
        });

        function formatRupiah(angka, prefix) {
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
    </script>
</x-app-layout>
