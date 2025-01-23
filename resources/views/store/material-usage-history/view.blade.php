<div class="col-sm-12" data-scroll="overflow-x" data-layout="report">
    <div id="rpt_dtl" class="table-responsive display" cellspacing="0" width="100%">
        <table class="table table-bordered" width="100%">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('No') }}</th>
                    <th>{{ __('Type Item') }}</th>
                    <th>{{ __('Item') }}</th>
                    <th>{{ __('Mechanic') }}</th>
                    <th>{{ __('Quantity') }}</th>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Price') }}</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($models as $row => $value) { ?>
                <tr>
                    <td align="center">{{ $no++ }}</td>
                    <td align="left">{{ $value->typeProduct ? $value->typeProduct->name : '-' }}</td>
                    <td align="left">{{ $value->product ? $value->product->name : '-' }}</td>
                    <td align="left">{{ $value->mechanic ? $value->mechanic->name : '-' }}</td>
                    <td align="left">{{ $value->qty }}</td>
                    <td align="left">{{ $value->description }}</td>
                    <td align="left">{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                    <td align="right">{{ __('Rp. ') }}@price($value->price)</td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </div>
</div>