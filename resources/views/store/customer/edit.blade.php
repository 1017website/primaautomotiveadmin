<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Store') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('store-customer.index') }}">{{ __('Customer') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('store-customer.index') }}">{{ __('Back') }}</a>
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

                <form class="form-horizontal" action="{{ route('store-customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
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

                    </div>
                    <div class="border-top"></div>
                    <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>

    </div>

</x-app-layout>