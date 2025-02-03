<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Store') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Product') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('store-product.create') }}">{{ __('Create') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Product') }}</h5>
                <div class="border-top"></div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {!! $message !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <!-- Dropdown filter -->
                <div class="col-sm-10">
                    <label for="type_product" class="text-left control-label col-form-label">{{ __('Type Item')
                        }}</label>
                    <select id="typeProductFilter" class="form-control w-25 mb-3">
                        <option value="">{{ __('All Types') }}</option>
                        @foreach ($typeProducts as $type)
                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="table-responsive">
                    <table id="store-product" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Type Item') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Unit') }}</th>
                                <th>{{ __('HPP') }}</th>
                                <th>{{ __('Margin(%)') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($storeProduct as $row)
                            <tr>
                                <td>{{ isset($row->typeProduct) ? $row->typeProduct->name : '-' }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->um }}</td>
                                <td align="right" data-order="{{ $row->hpp }}">{{ __('Rp. ') }}@price($row->hpp)</td>
                                <td align='center'>{{ number_format($row->margin_profit, 2, ',', '.') }}</td>
                                <td align="right" data-order="{{ $row->price }}">{{ __('Rp. ') }}@price($row->price)
                                </td>
                                <td>{{ isset($row->userCreated) ? $row->userCreated->name : '-' }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td class="action-button">
                                    <form action="{{ route('store-product.destroy',$row->id) }}" method="POST">
                                        <a class="btn btn-primary" href="{{ route('store-product.print', $row->id) }}"
                                            target="_blank"><i class="fa fa-print"></i></a>
                                        <a class="btn btn-info" href="{{ route('store-product.show',$row->id) }}"><i
                                                class="fas fa-eye"></i></a>
                                        <a class="btn btn-default" href="{{ route('store-product.edit',$row->id) }}"><i
                                                class="fas fa-pencil-alt"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <script>
        $('#store-product').DataTable();

        $(document).ready(function () {
            var table = $('#store-product').DataTable();

            $('#typeProductFilter').on('change', function () {
                var selectedType = $(this).val();
                
                if (selectedType) {
                    table.column(0).search('^' + $.fn.dataTable.util.escapeRegex(selectedType) + '$', true, false).draw();
                } else {
                    table.column(0).search('').draw(); 
                }
            });
        });
    </script>


</x-app-layout>