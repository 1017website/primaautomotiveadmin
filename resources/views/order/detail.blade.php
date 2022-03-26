<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Service</th>
                <th scope="col">Est Cost</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="customtable">
            @if (count($detailOrder) > 0)
            @foreach ($detailOrder as $row)
            <tr>
                <td align='center'>{{ $row->service_name }}</td>
                <td align='center'>{{ __('Rp. ') }}@price($row->service_price)</td>
                <td align='center'><button type="button" onclick="deleteTemp({{ $row->id }})" class="btn btn-danger"><i class="fas fa-trash"></i></button></td>
            </tr>
            @endforeach
            @else
        <td colspan="7" class="text-muted text-center">Service is empty</td>
        @endif
        </tbody>
    </table>
</div>

<script>
    function get_detail() {
    $.ajax({
    url: "{{ route('detailOrder') }}",
            type: 'GET',
            dataType: 'html',
            success: function (res) {
            $('.detail').html(res);
            }
    });
    }

    function deleteTemp(id) {
    $.ajax({
    url: "{{ route('deleteOrder') }}",
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