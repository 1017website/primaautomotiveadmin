<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('HRM') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('mechanic.index') }}">{{ __('Employee') }}</a></li>
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
                <h5 class="card-title">{{ __('Detail Employee') }}</h5>
                <div class="border-top"></div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Image') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                @if(!empty($mechanic->image))
                                <img src="{{ asset('storage/'.$mechanic->image) }}" class="img-fluid img-view">
                                @endif
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Id Card') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $mechanic->id_card }}
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Name') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $mechanic->name }}
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Position') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $mechanic->position }}
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Birth Date') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ date('d-m-Y', strtotime($mechanic->birth_date)) }}
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Phone') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $mechanic->phone }}
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Address') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $mechanic->address }}
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Created By') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ isset($mechanic->userCreated) ? $mechanic->userCreated->name : '-' }}
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Updated By') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ isset($mechanic->userUpdated) ? $mechanic->userUpdated->name : '-' }}
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Created At') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $mechanic->created_at }}
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Updated At') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $mechanic->updated_at }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Salary/Day') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ __('Rp. ') }}@price($mechanic->salary)
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Position Allowance') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ __('Rp. ') }}@price($mechanic->positional_allowance)
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Healthy Allowance') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ __('Rp. ') }}@price($mechanic->healthy_allowance)
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Other Allowance') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ __('Rp. ') }}@price($mechanic->other_allowance)
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

</x-app-layout>