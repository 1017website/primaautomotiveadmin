<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Product</th>
                <th scope="col">Qty</th>
                <th scope="col">Price</th>
                <th scope="col" colspan=2>Disc</th>
                <th scope="col">Total</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <?php
        $grandTotal = 0;
        ?>
        <tbody class="customtable">
            @if (count($detailOrder) > 0)
            @foreach ($detailOrder as $row)
            <tr>
                <td align='center'>{{ $row->product_name }}</td>
                <td align='center'>{{ number_format($row->product_qty, 2) }}</td>
                <td align='center'>{{ __('Rp. ') }}@price($row->product_price)</td>
                <td align='center'>{{ number_format($row->disc_persen, 2, ',', '.') }}</td>
                <td align='center'>{{ __('Rp. ') }}@price($row->disc)</td>
                <td align='center'>{{ __('Rp. ') }}@price($row->total)</td>
                <?php
                $grandTotal += $row->total;
                ?>
                <td align='center'><button type="button" onclick="deleteTempProduct({{ $row->id }})"
                        class="btn btn-danger"><i class="fas fa-trash"></i></button></td>
            </tr>
            @endforeach
            @else
            <td colspan="8" class="text-muted text-center">Product is empty</td>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td align='center' colspan="5"><b>Sub Total</b></td>
                <td align='center' class="sub_product" data-total="<?= $grandTotal ?>">{{ __('Rp. ')
                    }}@price($grandTotal)</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    function get_detail() {
    $.ajax({
    url: "{{ route('wash-sale.detailProduct') }}",
            type: 'GET',
            dataType: 'html',
            success: function (res) {
            $('.detail_product').html(res);
            }
    });
    }

    function deleteTempProduct(id) {
    $.ajax({
        url: "{{ route('wash-sale.deleteOrderProduct') }}",
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