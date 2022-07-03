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
		<div class="table-responsive">
			<div class="row">
				<div class="col-md-12">
					<table id="order" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>{{ __('Month') }}</th>
								<th>{{ __('Order') }}</th>
								<th>{{ __('Progress') }}</th>
								<th>{{ __('Done') }}</th>
								<th>{{ __('Revenue') }}</th>
								<th>{{ __('Expense') }}</th>
								<th>{{ __('Balance') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $index => $row)
							<tr>
								<td align=center>{{ $index }}</td>
								<td align=right>{{ number_format(isset($row['order']->orders)?$row['order']->orders:0) }}</td>          
								<td align=right>{{ number_format(isset($row['order']->progress)?$row['order']->progress:0) }}</td>
								<td align=right>{{ number_format(isset($row['order']->done)?$row['order']->done:0) }}</td>
								<td align=right>{{ number_format(isset($row['revenue']->revenue)?$row['revenue']->revenue:0) }}</td>
								<td align=right>{{ number_format(isset($row['expense']->expense)?$row['expense']->expense:0) }}</td>
								<td align=right>{{ number_format((isset($row['revenue']->revenue)?$row['revenue']->revenue:0) - (isset($row['expense']->expense)?$row['expense']->expense:0)) }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<table id="order" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>{{ __('Product') }}</th>
								<th>{{ __('Qty') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($products as $row)
							<tr>
								<td>{{ ($row->name) }}</td>
								<td align=right>{{ number_format($row->qty) }}</td>          
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
    </div>
</x-app-layout>
