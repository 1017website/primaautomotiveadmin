<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Type</th>
                <th scope="col">Brand</th>
				<th scope="col">Year</th>
                <th scope="col">Color</th>
				<th scope="col">Plate</th>
				<?php if(!isset($_GET['view'])){ ?>
					<th scope="col">Action</th>
				<?php } ?>
            </tr>
        </thead>
        <?php
        $grandTotal = 0;
        ?>
        <tbody class="customtable">
            @if (count($detailCustomer) > 0)
            @foreach ($detailCustomer as $row)
            <tr>
                <td align='left'>{{ $row->car->name }}</td>
                <td align='left'>{{ $row->car->type->name }}</td>
				<td align='left'>{{ $row->car->brand->name }}</td>
                <td align='left'>{{ $row->car_year }}</td>
				<td align='left'>{{ $row->car_color }}</td>
				<td align='left'>{{ $row->car_plate }}</td>
				<?php if(!isset($_GET['view'])){ ?>
					<td align='center'><button type="button" onclick="deleteCar({{ $row->id }})" class="btn btn-danger"><i class="fas fa-trash"></i></button></td>
				<?php } ?>
            </tr>
            @endforeach
            @else
        <td colspan="8" class="text-muted text-center">Car is empty</td>
        @endif
        </tbody>
    </table>
</div>