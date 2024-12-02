<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Users') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">{{ __('User List')
                                    }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Register User') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('user.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Register User') }}</h5>
                <div class="border-top"></div>
                @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif

                <form class="form-horizontal" action="{{ route('user.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{
                                            __('Name')
                                            }}</label>
                                        <div class="col-sm-10">
                                            <input value="{{ old('name') }}" type="text" class="form-control" id="name"
                                                name="name" required="true">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="username" class="col-sm-2 text-left control-label col-form-label">{{
                                            __('Username')
                                            }}</label>
                                        <div class="col-sm-10">
                                            <input value="{{ old('username') }}" type="text" class="form-control"
                                                id="username" name="username" required="true">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 text-left control-label col-form-label">{{
                                            __('Email')
                                            }}</label>
                                        <div class="col-sm-10">
                                            <input value="{{ old('email') }}" type="email" class="form-control"
                                                id="email" name="email" required="true">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="password" class="col-sm-2 text-left control-label col-form-label">{{
                                            __('Password')
                                            }}</label>
                                        <div class="col-sm-10">
                                            <input value="{{ old('password') }}" type="password" class="form-control"
                                                id="password" name="password" required="true">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="password_confirmation"
                                            class="col-sm-2 text-left control-label col-form-label">{{
                                            __('Confirm Password')
                                            }}</label>
                                        <div class="col-sm-10">
                                            <input value="{{ old('password_confirmation') }}" type="password"
                                                class="form-control" id="password_confirmation"
                                                name="password_confirmation" required="true">
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

</x-app-layout>