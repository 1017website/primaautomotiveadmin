<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('store-investment.index') }}">{{ __('Investment') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('store-investment.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Add Investment') }}</h5>
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

                <form class="form-horizontal" action="{{ route('store-investment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-sm-12">

                            <div class ="row">
                                <div class="col-sm-6">

                                    <div class="form-group row">
                                        <label for="date" class="col-sm-2 text-left control-label col-form-label">{{ __('Date') }}</label>
                                        <div class="col-sm-5 input-group">
                                            <input type="text" class="form-control mydatepicker" id="date" name="date" value="{{ (!empty(old('date'))?old('date'):date('d-m-Y')) }}" placeholder="dd/mm/yyyy" autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="description" class="col-sm-2 text-left control-label col-form-label">{{ __('Note') }}</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="cost" class="col-sm-2 text-left control-label col-form-label">{{ __('Costs') }}</label>
                                        <div class="col-sm-10">
                                            <input value="{{ old('cost') }}" type="text" class="form-control" id="cost" name="cost" required="true">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="shrink" class="col-sm-2 text-left control-label col-form-label">{{ __('Month') }}</label>
                                        <div class="col-sm-10">
                                            <input value="{{ old('shrink') }}" type="text" class="form-control" id="shrink" name="shrink" required="true">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="border-top"></div>
                            <button type="submit" class="btn btn-default btn-action">Save</button>
                            </form>

                        </div>
                    </div>

            </div>

        </div>

    </div>

    <script type="text/javascript">
        var harga = document.getElementById('cost');

        $(document).ready(function () {
            console.log(harga.value);
            var formated = formatRupiah($('#cost').val(), 'Rp. ');
            harga.value = formated;
        });

        harga.addEventListener('keyup', function (e) {
            harga.value = formatRupiah(this.value, 'Rp. ');
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
            $("input[id*='shrink']").keydown(function (event) {
                if (event.shiftKey == true) {
                    event.preventDefault();
                }
                if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                        (event.keyCode >= 96 && event.keyCode <= 105) ||
                        event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                        event.keyCode == 39 || event.keyCode == 46) {
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