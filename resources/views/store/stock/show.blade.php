<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Store') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('store-stock.index') }}">{{ __('Adjusting Stock') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('store-stock.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Detail Adjusting Stock') }}</h5>
                <div class="border-top"></div>

                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Date') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ date('d-m-Y', strtotime($storeStock->date)) }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Description') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $storeStock->description }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row pt-3">
                    <div class="col-sm-12">
                        <h5 class="card-title">{{ __('List Item') }}</h5>
                        <div class="border-top"></div>
                        <div class="detail">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Type</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Type Item</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Add Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody class="customtable">
                                        @if (count($storeStock->detail) > 0)
                                        @foreach ($storeStock->detail as $row)
                                        <tr>
                                            <td align='center'>{{ ucfirst($row->type) }}</td>
                                            <td align='center'>{{ $row->product->name }}</td>
                                            <td align='center'>{{ $row->typeProduct->name }}</td>
                                            <td align='center'>{{ __('Rp. ') }}@price($row->price)</td>
                                            <td align='center'>{{ number_format($row->qty, 2, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                    <td colspan="7" class="text-muted text-center">Item is empty</td>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>




            </div>
        </div>

    </div>

</x-app-layout>