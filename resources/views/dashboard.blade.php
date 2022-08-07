<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">

                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Dashboard Store') }}</h5>
                <div class="border-top"></div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="card">

                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h5 class="card-title">Overview Latest Month</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-dark p-10 text-white text-center">
                                            <i class="mdi mdi-receipt fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format($dataStore['invoice_month']) }}</h5>
                                            <small class="font-light">Total Invoice</small>
                                        </div>
                                    </div>
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-success p-10 text-white text-center">
                                            <i class="mdi mdi-currency-usd fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format($dataStore['revenue_month']) }}</h5>
                                            <small class="font-light">Total Revenue</small>
                                        </div>
                                    </div>
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-danger p-10 text-white text-center">
                                            <i class="mdi mdi-directions fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format($dataStore['expense_month']) }}</h5>
                                            <small class="font-light">Total Expense</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h5 class="card-title">Overview Summary</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-dark p-10 text-white text-center">
                                            <i class="mdi mdi-receipt fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format($dataStore['invoice_summary']) }}</h5>
                                            <small class="font-light">Total Invoice</small>
                                        </div>
                                    </div>
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-success p-10 text-white text-center">
                                            <i class="mdi mdi-currency-usd fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format($dataStore['revenue_summary']) }}</h5>
                                            <small class="font-light">Total Revenue</small>
                                        </div>
                                    </div>
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-danger p-10 text-white text-center">
                                            <i class="mdi mdi-directions fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format($dataStore['expense_summary']) }}</h5>
                                            <small class="font-light">Total Expense</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h5 class="card-title">Product Sold</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    @foreach ($dataStore['products'] as $row)
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-cyan p-10 text-white text-center">
                                            <h5 class="mb-0 mt-1">{{ number_format(isset($row->qty)?$row->qty:0) }}</h5>
                                            <small class="font-light">{{ $row->name }}</small>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <h5 class="card-title">{{ __('Dashboard Workshop') }}</h5>
                <div class="border-top"></div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="card">

                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h5 class="card-title">Overview Latest Month</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-dark p-10 text-white text-center">
                                            <i class="mdi mdi-book-multiple fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format(isset($dataWorkshop['month']['order']->orders)?$dataWorkshop['month']['order']->orders:0) }}</h5>
                                            <small class="font-light">Total Orders</small>
                                        </div>
                                    </div>
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-dark p-10 text-white text-center">
                                            <i class="mdi mdi-wrench fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format(isset($dataWorkshop['month']['order']->progress)?$dataWorkshop['month']['order']->progress:0) }}</h5>
                                            <small class="font-light">Total Progress</small>
                                        </div>
                                    </div>
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-dark p-10 text-white text-center">
                                            <i class="mdi mdi-check-circle-outline fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format(isset($dataWorkshop['month']['order']->done)?$dataWorkshop['month']['order']->done:0) }}</h5>
                                            <small class="font-light">Total Done</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-success p-10 text-white text-center">
                                            <i class="mdi mdi-currency-usd fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format(isset($dataWorkshop['month']['revenue']->revenue)?$dataWorkshop['month']['revenue']->revenue:0) }}</h5>
                                            <small class="font-light">Total Revenue</small>
                                        </div>
                                    </div>
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-danger p-10 text-white text-center">
                                            <i class="mdi mdi-directions fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format(isset($dataWorkshop['month']['expense']->expense)?$dataWorkshop['month']['expense']->expense:0) }}</h5>
                                            <small class="font-light">Total Expense</small>
                                        </div>
                                    </div>
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-info p-10 text-white text-center">
                                            <i class="mdi mdi-scale-balance fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format((isset($dataWorkshop['month']['revenue']->revenue)?$dataWorkshop['month']['revenue']->revenue:0) - (isset($dataWorkshop['month']['expense']->expense)?$dataWorkshop['month']['expense']->expense:0)) }}</h5>
                                            <small class="font-light">Balance</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h5 class="card-title">Overview Summary</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-dark p-10 text-white text-center">
                                            <i class="mdi mdi-book-multiple fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format(isset($dataWorkshop['ALL']['order']->orders)?$dataWorkshop['ALL']['order']->orders:0) }}</h5>
                                            <small class="font-light">Total Orders</small>
                                        </div>
                                    </div>
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-dark p-10 text-white text-center">
                                            <i class="mdi mdi-wrench fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format(isset($dataWorkshop['ALL']['order']->progress)?$dataWorkshop['ALL']['order']->progress:0) }}</h5>
                                            <small class="font-light">Total Progress</small>
                                        </div>
                                    </div>
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-dark p-10 text-white text-center">
                                            <i class="mdi mdi-check-circle-outline fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format(isset($dataWorkshop['ALL']['order']->done)?$dataWorkshop['ALL']['order']->done:0) }}</h5>
                                            <small class="font-light">Total Done</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-success p-10 text-white text-center">
                                            <i class="mdi mdi-currency-usd fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format(isset($dataWorkshop['ALL']['revenue']->revenue)?$dataWorkshop['ALL']['revenue']->revenue:0) }}</h5>
                                            <small class="font-light">Total Revenue</small>
                                        </div>
                                    </div>
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-danger p-10 text-white text-center">
                                            <i class="mdi mdi-directions fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format(isset($dataWorkshop['ALL']['expense']->expense)?$dataWorkshop['ALL']['expense']->expense:0) }}</h5>
                                            <small class="font-light">Total Expense</small>
                                        </div>
                                    </div>
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-info p-10 text-white text-center">
                                            <i class="mdi mdi-scale-balance fs-3 mb-1 font-16"></i>
                                            <h5 class="mb-0 mt-1">{{ number_format((isset($dataWorkshop['ALL']['revenue']->revenue)?$dataWorkshop['ALL']['revenue']->revenue:0) - (isset($dataWorkshop['ALL']['expense']->expense)?$dataWorkshop['ALL']['expense']->expense:0)) }}</h5>
                                            <small class="font-light">Balance</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h5 class="card-title">Used Product</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    @foreach ($dataWorkshop['products'] as $row)
                                    <div class="col-4" style="padding-bottom:5px;">
                                        <div class="bg-cyan p-10 text-white text-center">
                                            <h5 class="mb-0 mt-1">{{ number_format(isset($row->qty)?$row->qty:0) }}</h5>
                                            <small class="font-light">{{ $row->name }}</small>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
