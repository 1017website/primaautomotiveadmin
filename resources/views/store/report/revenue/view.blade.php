<div class="col-sm-12" data-scroll="overflow-x" data-layout="report">
    <div id="rpt_dtl" class="table-responsive display" cellspacing="0" width="100%">
        <table class="table table-bordered" width="100%">
            <thead class="thead-light">
                <tr>
                    <th>{{ __('No') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Invoice') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                <?php $grandTotal=0;$grandDp=0;$no=1; foreach ($models as $row => $value) { ?>
                    <tr>
                        <td align="center">{{ $no++ }}</td>
                        <td align="left">{{ ucfirst($value->type) }}</td>
                        <td align="left">{{ $value->code }}</td>
                        <td align="left">{{ date('d-m-Y', strtotime($value->date)) }}</td>
                        <td align="right">{{ __('Rp. ') }}@price($value->total)</td>
                    </tr>
                <?php $grandTotal+=$value->total; } ?>
                <tr class="font-weight-bold">
                    <td align="center" colspan="4"><b>{{ __('Grand Total') }}</b></td>
                    <td align="right"><b>{{ __('Rp. ') }}@price($grandTotal)</b></td>
                </tr>
            </tbody>
            <tfoot>
                
            </tfoot>
        </table>
    </div>
</div>

