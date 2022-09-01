<x-app-layout>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">

                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Setting') }}</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Setting') }}</h5>
                <div class="border-top"></div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {!! $message !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

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

                <form class="form-horizontal" action="{{ route('setting.store') }}" method="POST">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ isset($setting) ? $setting->name : '' }}" placeholder="Name" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-sm-2 text-left control-label col-form-label">{{ __('Address') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="address" name="address" value="{{ isset($setting) ? $setting->address : '' }}" placeholder="Address" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 text-left control-label col-form-label">{{ __('Phone') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ isset($setting) ? $setting->phone : '' }}" placeholder="Phone" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 text-left control-label col-form-label">{{ __('Email') }}</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" value="{{ isset($setting) ? $setting->email : '' }}" placeholder="Email" required="true">
                        </div>
                    </div>


                    <div class="border-top"></div>
                    <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
