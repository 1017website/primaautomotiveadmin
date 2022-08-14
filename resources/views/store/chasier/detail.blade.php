<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Item</th>
                <th scope="col">Price</th>
                <th scope="col">Qty</th>
                <th scope="col">Total</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="customtable">
            <?php
            $sub = 0;
            if (count($detailItem) > 0) {
                foreach ($detailItem as $row) {
                    ?>
                    <tr>
                        <td align='center'>{{ $row->product_name }}</td>
                        <td align='center'>{{ __('Rp. ') }}@price($row->product_price)</td>
                        <td align='center'>{{ number_format($row->qty, 2, ',', '.') }}</td>
                        <td align='right'>{{ __('Rp. ') }} @price($row->product_price * $row->qty )</td>
                        <td align='center'><button type="button" onclick="deleteTemp({{ $row->id }})" class="btn btn-danger"><i class="fas fa-trash"></i></button></td>
                    </tr>
                    <?php
                    $sub += ($row->product_price * $row->qty);
                }
            } else {
                ?>
                <tr>
                    <td colspan="5" class="text-muted text-center">Item is empty</td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot class="customtable">
            <tr>
                <td colspan="3" class="text-muted text-right">Sub Total :</td>
                <td class="text-muted text-right">{{ __('Rp. ') }} <?= number_format($sub) ?></td>
                <td class="text-muted text-right"></td>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    function get_detail() {
    $.ajax({
    url: "{{ route('store-chasier.detail') }}",
            type: 'GET',
            dataType: 'html',
            success: function (res) {
            $('.detail').html(res);
            }
    });
    }

    function deleteTemp(id) {
    $.ajax({
    url: "{{ route('store-chasier.deleteProduct') }}",
            type: 'POST',
            dataType: 'json',
            data: {
            'id': id
            },
            success: function (res) {
            get_detail();
            }
    });
    }

</script>