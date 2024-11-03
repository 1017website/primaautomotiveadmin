<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Service</th>
            </tr>
        </thead>
        <?php
        $grandTotal = 0;
        ?>
        <tbody class="customtable">
            @if (count($detail) > 0)
            @foreach ($detail as $row)
            <tr>
                <td align='center'>{{ $row->service->name }}</td>
            </tr>
            @endforeach
            @else
        <td colspan="2" class="text-muted text-center">Profile is empty</td>
        @endif
        </tbody>
    </table>
</div>