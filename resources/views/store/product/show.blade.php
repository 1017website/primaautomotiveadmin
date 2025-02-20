@php
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
$generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
@endphp

<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Store') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('store-product.index') }}">{{ __('Product') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-primary" href="{{ route('store-product.print', $storeProduct->id) }}" target="_blank"><i class="fa fa-print"></i>{{ __('Print') }}</a>
            <a class="btn btn-default" href="{{ route('store-product.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Detail Product') }}</h5>
                <div class="border-top"></div>

                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Image') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        @if(!empty($storeProduct->image))
                        <img src="{{ asset($storeProduct->image_url) }}" class="img-fluid img-view">
                        @endif
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Barcode') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        <img src="https://barcode.tec-it.com/barcode.ashx?data={{$storeProduct->barcode}}&code=Code128&eclevel=L'/">
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Type Item') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ isset($storeProduct->typeProduct) ? $storeProduct->typeProduct->name : '-' }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Name') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $storeProduct->name }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('HPP') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ __('Rp. ') }}@price($storeProduct->hpp)
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Margin Profit') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ number_format($storeProduct->margin_profit, 0, ',', '.') }}%
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Price') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ __('Rp. ') }}@price($storeProduct->price)
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Density') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $storeProduct->density }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Document') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        @if((!empty($storeProduct->document)))
                        <a href="{{ asset($storeProduct->document_url) }}" class="btn btn-default" target="_blank">Download</a>
                        @endif
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Created By') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ isset($storeProduct->userCreated) ? $storeProduct->userCreated->name : '-' }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Updated By') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ isset($storeProduct->userUpdated) ? $storeProduct->userUpdated->name : '-' }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Created At') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $storeProduct->created_at }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Updated At') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $storeProduct->updated_at }}
                    </div>
                </div>


            </div>
        </div>

    </div>

</x-app-layout>