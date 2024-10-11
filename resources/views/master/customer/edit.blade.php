<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">{{ __('Customer') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('customer.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Edit Customer') }}</h5>
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

                <form class="form-horizontal" action="{{ route('customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class ="row">

                        <div class="col-sm-12">   
                            <fieldset class="border p-2">
                                <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('Customer') }}</legend>
                                <div class ="row">

                                    <div class="col-sm-12">
                                        <div class="form-group row">

                                            <div class="col-sm-6" style="text-align: center;">
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
                                                        <img src="{{ !empty($customer->image) ? asset($customer->image_url) : asset('plugins/images/users/default-user.png') }}" alt="" class="rounded-full h-20 w-20 object-cover">
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

                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name" value="{{ $customer->name }}" required="true">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2 text-left control-label col-form-label">{{ __('Phone') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control phone" id="phone" name="phone" value="{{ $customer->phone }}" required="true">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="id_card" class="col-sm-2 text-left control-label col-form-label">{{ __('Id Card') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="id_card" name="id_card" value="{{ $customer->id_card }}" placeholder="Ktp/Sim">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 text-left control-label col-form-label">{{ __('Address') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="address" name="address" value="{{ $customer->address }}">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </fieldset>
                        </div>

                        <div class="col-sm-12">
                            <fieldset class="border p-2">
                                <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('Car') }}</legend>
                                <div class ="row">
                                    <div class="col-sm-6">

                                        <div class="form-group row">
                                            <label for="cars_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                                            <div class="col-sm-10">
                                                <select class="select2 form-control custom-select" id="cars_id" name="cars_id" style="width: 100%;">                              
                                                    @foreach($car as $row)                                
                                                    <option value="{{ $row->id }}"> {{ $row->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="car_plate" class="col-sm-2 text-left control-label col-form-label">{{ __('Plate') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="car_plate" name="car_plate" value="">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="car_year" class="col-sm-2 text-left control-label col-form-label">{{ __('Year') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="car_year" name="car_year" value="">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="car_color" class="col-sm-2 text-left control-label col-form-label">{{ __('Color') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="car_color" name="car_color" value="">
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-default btn-add float-right">Add Car</button>
                                    </div>

                                </div>
                            </fieldset>
                        </div>

                    </div>
                    <fieldset class="border p-2">
                        <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('List Car') }}</legend>

                        <div class="detail">

                        </div>
                    </fieldset>
                    <div class="border-top"></div>
                    <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            get_detail();
        });

        function get_detail() {
            $.ajax({
                url: "{{ route('customerDetail') }}",
                type: 'GET',
                dataType: 'html',
                success: function (res) {
                    $('.detail').html(res);
                }
            });
        }

        function deleteCar(id) {
            $.ajax({
                url: "{{ route('deleteCustomerCar') }}",
                type: 'POST',
                dataType: 'html',
                data: {
                    'id': id
                },
                success: function (res) {
                    $('.detail').html(res);
                }
            });
        }

        $(".btn-add").click(function () {
            if ($('#car_plate').val() == '') {
                alert("Car Plate Cant be empty");
                return
            }
            $.ajax({
                url: "{{ route('addCarCustomer') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'cars_id': $('#cars_id').val(),
                    'car_year': $('#car_year').val(),
                    'car_color': $('#car_color').val(),
                    'car_plate': $('#car_plate').val(),
                },
                success: function (res) {
                    if (res.success) {
                        get_detail();
                    } else {
                        alert('Failed Add Car')
                    }
                }
            });
        });
    </script>
</x-app-layout>