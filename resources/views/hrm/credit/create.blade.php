<x-app-layout>
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            background-color: #2255a4!important;
            border: none!important;
        }
    </style>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('employee-credit.index') }}">{{ __('Credit') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('employee-credit.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Add') }}</h5>
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

                <form class="form-horizontal" action="{{ route('employee-credit.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-sm-12">

                            <div class ="row">
                                <div class="col-sm-6">

                                    <div class="form-group row">
                                        <label for="date" class="col-sm-2 text-left control-label col-form-label">{{ __('Date') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <input type="text" class="form-control mydatepicker" id="date" name="date" value="{{ !empty(old('date'))?old('date'):date('d-m-Y') }}" placeholder="dd/mm/yyyy" autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="employee_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Employee') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <select class="select2 form-select shadow-none mt-3" id="employee_id" name="employee_id" style="width: 100%">
                                                <?php foreach ($employee as $row) { ?>
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="total" class="col-sm-2 text-left control-label col-form-label">{{ __('Nominal') }}</label>
                                        <div class="col-sm-8">
                                            <input value="{{ old('total') }}" type="text" class="form-control" id="total" name="total" placeholder="Nominal" required="true">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tenor" class="col-sm-2 text-left control-label col-form-label">{{ __('Tenor') }}</label>
                                        <div class="col-sm-8">
                                            <select class="select2 form-control custom-select" id="tenor" name="tenor" style="width: 100%;">                              
                                                <option value="1">1x</option>
                                                <option value="3">3x</option>
                                                <option value="6">6x</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="description" class="col-sm-2 text-left control-label col-form-label">{{ __('Description') }}</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="border-top"></div>
                            <button type="submit" class="btn btn-default btn-action">Save</button>

                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>

    <script>
        var harga = document.getElementById('total');

        $(document).ready(function () {
            console.log(harga.value);
            var formated = formatRupiah($('#total').val(), 'Rp. ');
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