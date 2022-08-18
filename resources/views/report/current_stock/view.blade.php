<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Type Item</th>
                <th>Item</th>
                <th>Price</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($models as $row => $value){ ?>
            <tr>
                <td align="center">{{ $no++ }}</td>
                <td align="left">{{ $value->typeProduct->name }}</td>
                <td align="left">{{ $value->product->name }}</td>
                <td align="right">{{ __('Rp. ') }}@price($value->price)</td>
                <td align="right">{{ number_format($value->qty, 0, ',', '.') }}</td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot>

        </tfoot>
    </table>
</div>

