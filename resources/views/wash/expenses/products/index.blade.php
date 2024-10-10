<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Wash Expense Products') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Spending') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('wash-expense-product.create') }}">{{ __('Create') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Wash Expense Products') }}</h5>
                <div class="border-top"></div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {!! $message !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="table-responsive">
                    <table id="spending" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Code')}}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Created At') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($washExpensesProduct as $row)
                            <tr>
                                <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                <td>{{ $row->code }}</td>
                                <td>{{ $row->name }}</td>
                                <td align="right" data-order="{{ $row->price }}">{{ __('Rp. ') }}@price($row->price)</td>
                                <td>{{ $row->stock }}</td>
                                <td>{{ isset($row->userCreated) ? $row->userCreated->name : '-' }}</td>
                                <td>{{ $row->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('#spending').DataTable({
                "ordering": false
            });
        });
    </script>


</x-app-layout>