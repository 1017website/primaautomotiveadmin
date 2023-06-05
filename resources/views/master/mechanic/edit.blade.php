<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('mechanic.index') }}">{{ __('Employee') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('mechanic.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Edit Employee') }}</h5>
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

                <form class="form-horizontal" action="{{ route('mechanic.update', $mechanic->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-sm-6">

                            <div class="form-group row">
                                <label for="id_card" class="col-sm-2 text-left control-label col-form-label">{{ __('Id Card') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="id_card" name="id_card" value="{{ $mechanic->id_card }}" placeholder="Ktp/Sim">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $mechanic->name }}" placeholder="Name" required="true">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="position" class="col-sm-2 text-left control-label col-form-label">{{ __('Position') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="position" name="position" value="{{ $mechanic->position }}" placeholder="Position" required="true">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="birth_date" class="col-sm-2 text-left control-label col-form-label">{{ __('Birth Date') }}</label>
                                <div class="col-sm-10 input-group">
                                    <input type="text" class="form-control mydatepicker" id="birth_date" name="birth_date" value="{{ date('d-m-Y', strtotime($mechanic->birth_date)) }}"  placeholder="dd/mm/yyyy">
                                    <div class="input-group-append">
                                        <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 text-left control-label col-form-label">{{ __('Phone') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control phone" id="phone" name="phone" value="{{ $mechanic->phone }}" placeholder="081xxx">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 text-left control-label col-form-label">{{ __('Address') }}</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="address" name="address" placeholder="Address">{{ $mechanic->address }}</textarea>
                                </div>
                            </div>

                            <h5 class="card-title">{{ __('Wages') }}</h5>
                            <div class="border-top"></div>

                            <div class="form-group row">
                                <label for="salary" class="col-sm-2 text-left control-label col-form-label">{{ __('Salary/Day') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="salary" name="salary" placeholder="" value="{{ $mechanic->salary }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="positional_allowance" class="col-sm-2 text-left control-label col-form-label">{{ __('Position Allowance') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="positional_allowance" name="positional_allowance" value="{{ $mechanic->positional_allowance }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="healthy_allowance" class="col-sm-2 text-left control-label col-form-label">{{ __('Healthy Allowance') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="healthy_allowance" name="healthy_allowance" value="{{ $mechanic->healthy_allowance }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="other_allowance" class="col-sm-2 text-left control-label col-form-label">{{ __('Other Allowance') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="other_allowance" name="other_allowance" value="{{ $mechanic->other_allowance }}" required>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group row">

                                <div class="col-sm-12" style="text-align: center;">
                                    <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                                        <!-- Profile Photo File Input -->
                                        <input type="file" class="hidden" name="image"
                                               wire:model="photo"
                                               x-ref="photo"
                                               x-on:change="
                                               photoName = $refs.photo.files[0].name;
                                               const reader = new FileReader();
                                               reader.onload = (e) => {
                                               photoPreview = e.target.result;
                                               };
                                               reader.readAsDataURL($refs.photo.files[0]);
                                               " />

                                        <!-- Current Profile Photo -->
                                        <div class="mt-2" x-show="! photoPreview">
                                            <img src="{{ !empty($mechanic->image) ? $mechanic->image_url : asset('plugins/images/users/default-user.png') }}" alt="" class="rounded-full h-20 w-20 object-cover">
                                        </div>

                                        <!-- New Profile Photo Preview -->
                                        <div class="mt-2" x-show="photoPreview" style="display: none;">
                                            <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center ml-auto mr-auto"
                                                  x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                            </span>
                                        </div>

                                        <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                                            {{ __('Select A New Photo') }}
                                        </x-jet-secondary-button>

                                        <x-jet-input-error for="photo" class="mt-2" />
                                    </div>
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

    <script>

        var salary = document.getElementById('salary');
        $(document).ready(function () {
            var formated = formatRupiah($('#salary').val(), 'Rp. ');
            salary.value = formated;
        });
        salary.addEventListener('keyup', function (e) {
            salary.value = formatRupiah(this.value, 'Rp. ');
        });

        var positional_allowance = document.getElementById('positional_allowance');
        $(document).ready(function () {
            var formated = formatRupiah($('#positional_allowance').val(), 'Rp. ');
            positional_allowance.value = formated;
        });
        positional_allowance.addEventListener('keyup', function (e) {
            positional_allowance.value = formatRupiah(this.value, 'Rp. ');
        });

        var healthy_allowance = document.getElementById('healthy_allowance');
        $(document).ready(function () {
            var formated = formatRupiah($('#healthy_allowance').val(), 'Rp. ');
            healthy_allowance.value = formated;
        });
        healthy_allowance.addEventListener('keyup', function (e) {
            healthy_allowance.value = formatRupiah(this.value, 'Rp. ');
        });

        var other_allowance = document.getElementById('other_allowance');
        $(document).ready(function () {
            var formated = formatRupiah($('#other_allowance').val(), 'Rp. ');
            other_allowance.value = formated;
        });
        other_allowance.addEventListener('keyup', function (e) {
            other_allowance.value = formatRupiah(this.value, 'Rp. ');
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