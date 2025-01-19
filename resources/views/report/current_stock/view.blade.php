<div class="col-sm-12" data-scroll="overflow-x" data-layout="report">
    <div id="rpt_dtl" class="table-responsive display" cellspacing="0" width="100%">
        <table class="table table-bordered" width="100%">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('No') }}</th>
                    <th>{{ __('Type Item') }}</th>
                    <th>{{ __('Item') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Qty') }}</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($models as $row => $value) { ?>
                <tr>
                    <td align="center">{{ $no++ }}</td>
                    <td align="left">{{ $value->typeProduct ? $value->typeProduct->name : 'Deleted Data' }}</td>
                    <td align="left"> {{ $value->product ? $value->product->name : 'Deleted Product' }}</td>
                    <td align="right">{{ __('Rp. ') }}@price($value->price)</td>
                    <td align="right">{{ number_format($value->qty, 0, ',', '.') }}</td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </div>
</div>