<div class="col-sm-12" data-scroll="overflow-x" data-layout="report">
    <div id="rpt_dtl" class="table-responsive display" cellspacing="0" width="100%">
        <table class="table table-bordered" width="100%">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('No') }}</th>
                    <th>{{ __('Item') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Qty In') }}</th>
                    <th>{{ __('Qty Out') }}</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($models as $row => $value) { ?>
                    <tr>
                        <td align="center">{{ $no++ }}</td>
                        <td align="left">{{ $value->product->name }}</td>
                        <td align="left">{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                        <td align="right">{{ number_format($value->weight_in, 2, ',', '.') }}</td>
                        <td align="right">{{ number_format($value->weight_out, 2, ',', '.') }}</td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </div>
</div>

