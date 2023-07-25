<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Store') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('mix.index') }}">{{ __('Mixing Color') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('mix.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Detail') }}</h5>
                <div class="border-top"></div>

                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Date') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ date('d-m-Y', strtotime($mix->date)) }}
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Description') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        {{ $mix->description }}
                    </div>
                </div>

				<div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Product') }}</strong>
                    </div>
                    <div class="col-sm-3">
                        {{ $mix->code .' - '.$mix->name }}
                    </div>
                    <div class="col-sm-1">
                        <strong>{{ __('Weight') }}</strong>
                    </div>
                    <div class="col-sm-2">
                        {{ $mix->berat_jenis }}
                    </div>
                    <div class="col-sm-1">
                        <strong>{{ __('Qty') }}</strong>
                    </div>
                    <div class="col-sm-2">
                        {{ $mix->qty .'  '.$mix->um }}
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
                                            <th scope="col">Line</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Type Item</th>
                                            <th scope="col">Weight</th>
                                        </tr>
                                    </thead>
                                    <tbody class="customtable">
                                        @if (count($mix->detail) > 0)
                                        @foreach ($mix->detail as $row)
                                        <tr>
                                            <td align='center'>{{ ucfirst($row->line) }}</td>
                                            <td align='center'>{{ $row->product->name }}</td>
                                            <td align='center'>{{ $row->product->typeProduct->name }}</td>
                                            <td align='center'>{{ number_format($row->weight, 2, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                    <td colspan="4" class="text-muted text-center">Item is empty</td>
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