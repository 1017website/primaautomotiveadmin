<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('service.index') }}">{{ __('Service') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('service.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Edit Service') }}</h5>
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

                <form class="form-horizontal" action="{{ route('service.update', $service->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                        <div class="col-sm-10">
                            <input value="{{ $service->name }}" type="text" class="form-control" id="name" name="name" placeholder="Name Service" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="estimated_costs" class="col-sm-2 text-left control-label col-form-label">{{ __('Estimated Costs') }}</label>
                        <div class="col-sm-10">
                            <input value="{{ $service->estimated_costs }}" type="text" class="form-control" id="estimated_costs" name="estimated_costs" placeholder="Estimated Costs" required="true">
                        </div>
                    </div>

                    <div class="border-top"></div>
                    <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>

    </div>

    <script>
        var harga = document.getElementById('estimated_costs');

        $(document).ready(function () {
            console.log(harga.value);
            var formated = formatRupiah($('#estimated_costs').val(), 'Rp. ');
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
    </script>

</x-app-layout>