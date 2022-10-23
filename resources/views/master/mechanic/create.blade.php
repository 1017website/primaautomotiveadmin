<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('HRM') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('mechanic.index') }}">{{ __('Employee') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
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
                <h5 class="card-title">{{ __('Create Employee') }}</h5>
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

                <form class="form-horizontal" action="{{ route('mechanic.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">

                            <div class="form-group row">
                                <label for="id_card" class="col-sm-2 text-left control-label col-form-label">{{ __('Id Card') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="id_card" name="id_card" value="{{ old('id_card') }}" placeholder="Ktp/Sim">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Name" required="true">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="position" class="col-sm-2 text-left control-label col-form-label">{{ __('Position') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="position" name="position" value="{{ old('position') }}" placeholder="Position" required="true">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="birth_date" class="col-sm-2 text-left control-label col-form-label">{{ __('Birth Date') }}</label>
                                <div class="col-sm-10 input-group">
                                    <input type="text" class="form-control mydatepicker" id="birth_date" name="birth_date" value="{{ old('birth_date') }}"  placeholder="dd/mm/yyyy">
                                    <div class="input-group-append">
                                        <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 text-left control-label col-form-label">{{ __('Phone') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control phone" id="phone" name="phone" value="{{ old('phone') }}" placeholder="081xxx">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 text-left control-label col-form-label">{{ __('Address') }}</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="address" name="address" placeholder="Address">{{ old('address') }}</textarea>
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
                                            <img src="{{asset('plugins/images/users/default-user.png')}}" alt="" class="rounded-full h-20 w-20 object-cover">
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

</x-app-layout>