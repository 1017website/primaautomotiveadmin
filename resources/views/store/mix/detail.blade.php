<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Item</th>
                <th scope="col">Current Stock</th>
                <th scope="col">Weight</th>
				<th scope="col">Price</th>
				<th scope="col">amount</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="customtable">
            @if (count($detailItem) > 0)
            @foreach ($detailItem as $row)
            <tr>
                <td align='center'>{{ $row->product->name }}</td>
                <td align='center'>{{ isset($row->currentStock) ? $row->currentStock->weight : 0 }}</td>
                <td align='center'>{{ number_format($row->weight, 2, ',', '.') }}</td>
				<td align='center'>{{ number_format($row->price, 2, ',', '.') }}</td>
				<td align='center'>{{ number_format($row->amount, 2, ',', '.') }}</td>
                <td align='center'><button type="button" onclick="deleteTemp({{ $row->id }})" class="btn btn-danger"><i class="fas fa-trash"></i></button></td>
            </tr>
            @endforeach
            @else
        <td colspan="7" class="text-muted text-center">Item is empty</td>
        @endif
        </tbody>
    </table>
</div>

<script>
    function get_detail() {
        $.ajax({
            url: "{{ route('mix.detail') }}",
            type: 'GET',
            dataType: 'html',
            success: function (res) {
                $('.detail').html(res);
            }
        });
    }
    
    function deleteTemp(id) {
        $.ajax({
            url: "{{ route('mix.delete') }}",
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