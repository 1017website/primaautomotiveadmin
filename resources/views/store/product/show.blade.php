<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ __('Item') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('product.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Detail Item') }}</h5>
                <div class="border-top"></div>

                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Image') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        @if(!empty($product->image))
                        <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid img-view">
                        @endif
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Type Item') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ isset($product->typeProduct) ? $product->typeProduct->name : '-' }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Name') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $product->name }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Created By') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ isset($product->userCreated) ? $product->userCreated->name : '-' }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Updated By') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ isset($product->userUpdated) ? $product->userUpdated->name : '-' }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Created At') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $product->created_at }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Updated At') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $product->updated_at }}
                    </div>
                </div>


            </div>
        </div>

    </div>

</x-app-layout>