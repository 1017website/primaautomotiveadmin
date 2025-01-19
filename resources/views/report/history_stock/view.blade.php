<div class="col-sm-12" data-scroll="overflow-x" data-layout="report">
    <div id="rpt_dtl" class="table-responsive display" cellspacing="0" width="100%">
        <table class="table table-bordered" width="100%">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('No') }}</th>
                    <th>{{ __('Type Item') }}</th>
                    <th>{{ __('Item') }}</th>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Qty In') }}</th>
                    <th>{{ __('Qty Out') }}</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($models as $row => $value) { ?>
                    <tr>
                        <td align="center">{{ $no++ }}</td>
                        <td align="left">{{ $value->TypeProduct ? $value->typeProduct->name : 'Deleted Data' }}</td>
                        <td align="left">{{ $value->product ? $value->product->name : 'Deleted Product' }}</td>
                        <td align="left">{{ $value->description }}</td>
                        <td align="left">{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                        <td align="right">{{ __('Rp. ') }}@price($value->price)</td>
                        <td align="right">{{ number_format($value->qty_in, 0, ',', '.') }}</td>
                        <td align="right">{{ number_format($value->qty_out, 0, ',', '.') }}</td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </div>
</div>

