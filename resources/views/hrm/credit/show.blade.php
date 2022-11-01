<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('employee-credit.index') }}">{{ __('Credit') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('employee-credit.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Detail Credit') }}</h5>

                <div class="row">
                    <div class="col-sm-12">

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-2">
                                <strong>{{ __('Date') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ date('d-m-Y', strtotime($employeeCredit->date)) }}
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-2">
                                <strong>{{ __('Employee') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ $employeeCredit->employee->name }}
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-2">
                                <strong>{{ __('Description') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ $employeeCredit->description }}
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-2">
                                <strong>{{ __('Total') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ __('Rp. ') }}@price($employeeCredit->total)
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-2">
                                <strong>{{ __('Tenor') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ $employeeCredit->tenor }}x
                            </div>
                        </div>

                        <div class="border-top"></div>
                        <div class="row p-3">
                            <div class="col-sm-2">
                                <strong>{{ __('Status') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ ucfirst($employeeCredit->status) }}
                            </div>
                        </div>

                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row pt-3">
                    <div class="col-sm-12">
                        <div class="detail">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="customtable">
                                        @if (count($employeeCredit->detail) > 0)
                                        @foreach ($employeeCredit->detail as $row)
                                        <tr>
                                            <td align='center'>{{ date('F Y', strtotime($row->date)) }}</td>
                                            <td align='center'>{{ __('Rp. ') }}@price($row->total)</td> 
                                            <td align='center'>{{ ucfirst($row->status) }}</td>
                                            <td align='center'>{{ $row->status == 'paid' ? ($row->description) : '' }}</td>
                                            @if ($row->status == 'unpaid')
                                            <td align='center'><button type="button" onclick="paid({{ $row->id }})" class="btn btn-success"><i class="fas fa-check"></i></button></td>
                                            @endif
                                        </tr>
                                        @endforeach
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

    <script>

        function paid(id) {
        $.ajax({
        url: "{{ route('employee-credit.paid') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                "_token": "{{ csrf_token() }}",
                        'id': id
                },
                success: function (res) {
                if (res.success){
                location.reload();
                } else{
                Command: toastr["error"](res.message);
                }
                }
        });
        }

    </script>

</x-app-layout>

