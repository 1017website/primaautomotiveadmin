<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Prima X Shine') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('wash-service.index') }}">{{ __('Service')
                                    }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('wash-service.index') }}">{{ __('Back') }}</a>
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

                <form class="form-horizontal" action="{{ route('wash-service.update', $washService->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name')
                            }}</label>
                        <div class="col-sm-10">
                            <input value="{{ $washService->name }}" type="text" class="form-control" id="name"
                                name="name" placeholder="" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cost" class="col-sm-2 text-left control-label col-form-label">{{ __('Cost')
                            }}</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="cost" name="cost"
                                value="{{ $washService->cost }}" placeholder="" required="true">
                        </div>
                    </div>

                    <div class="border-top"></div>
                    <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>

    </div>



</x-app-layout>