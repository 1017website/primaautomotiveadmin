<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Service</th>
                <th scope="col">Qty</th>
                <th scope="col">Cost Service</th>
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
                <td align='center'>{{ $row->service_name }}</td>
                <td align='center'>{{ number_format($row->service_qty, 2) }}</td>
                <td align='center'>{{ __('Rp. ') }}@price($row->service_price)</td>
                <td align='center'>{{ number_format($row->disc_persen, 2, ',', '.') }}</td>
                <td align='center'>{{ __('Rp. ') }}@price($row->service_disc)</td>
                <td align='center'>{{ __('Rp. ') }}@price($row->service_total)</td>
                <?php
                $grandTotal += $row->service_total;
                ?>
                <td align='center'><button type="button" onclick="deleteTemp({{ $row->id }})" class="btn btn-danger"><i
                            class="fas fa-trash"></i></button></td>
            </tr>
            @endforeach
            @else
            <td colspan="8" class="text-muted text-center">Service is empty</td>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td align='center' colspan="5"><b>Sub Total</b></td>
                <td align='center' class="sub" data-total="<?= $grandTotal ?>">{{ __('Rp. ') }}@price($grandTotal)</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    function get_detail() {
    $.ajax({
    url: "{{ route('wash-sale.detailOrder') }}",
            type: 'GET',
            dataType: 'html',
            success: function (res) {
            $('.detail').html(res);
            }
    });
    }

    function deleteTemp(id) {
    $.ajax({
    url: "{{ route('wash-sale.deleteOrder') }}",
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