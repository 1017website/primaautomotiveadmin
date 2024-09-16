<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Prima X Shine') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('wash-product.index') }}">{{ __('Product')
                                    }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('wash-product.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Create Product') }}</h5>
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

                <form class="form-horizontal" action="{{ route('wash-product.store') }}" method="POST">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name')
                            }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                                placeholder="" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="buying_price" class="col-sm-2 text-left control-label col-form-label">{{ __('Buying
                            Price')
                            }}</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="buying_price" name="buying_price"
                                value="{{ old('buying_price') }}" placeholder="" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="selling_price" class="col-sm-2 text-left control-label col-form-label">{{
                            __('Selling Price')
                            }}</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="selling_price" name="selling_price"
                                value="{{ old('selling_price') }}" placeholder="" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="stock" class="col-sm-2 text-left control-label col-form-label">{{
                            __('Stock')
                            }}</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}"
                                placeholder="" required="true">
                        </div>
                    </div>

                    <div class="border-top"></div>
                    <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>

    </div>

</x-app-layout>