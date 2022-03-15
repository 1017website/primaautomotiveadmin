<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('mechanic.index') }}">{{ __('Mechanic') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
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
                <h5 class="card-title">{{ __('Detail Mechanic') }}</h5>
                <div class="border-top"></div>

                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Image') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        @if(!empty($mechanic->image))
                        <img src="{{ asset('storage/'.$mechanic->image) }}" class="img-fluid img-view">
                        @endif
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Id Card') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $mechanic->id_card }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Name') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $mechanic->name }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Birth Date') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ date('d-m-Y', strtotime($mechanic->birth_date)) }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Phone') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $mechanic->phone }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Phone') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $mechanic->address }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Created By') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ isset($mechanic->userCreated) ? $mechanic->userCreated->name : '-' }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Updated By') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ isset($mechanic->userUpdated) ? $mechanic->userUpdated->name : '-' }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Created At') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $mechanic->created_at }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Updated At') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $mechanic->updated_at }}
                    </div>
                </div>


            </div>
        </div>

    </div>

</x-app-layout>