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
                    <tr data-id="{{ $row->id }}" data-stock="{{ $row->stock_id }}">
                        <td align='center'>{{ $row->product_name }}</td>
                        <td align='center'>{{ __('Rp. ') }}@price($row->product_price)</td>
                        <td align='center' class="editable">{{ number_format($row->qty, 2, ',', '.') }}</td>
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
    function get_detail(){
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
    
    $(".table td.editable").dblclick(function(){
        var OriginalContent = $(this).text();
        $(this).addClass("cellEditing");
        $(this).html("<input id='col-editable' class='col-editable' value='" + OriginalContent + "' style='text-align:center'/>"); 
        
        $("#col-editable").keydown(function (event) {
            if (event.shiftKey == true) {
                event.preventDefault();
            }
            
            if(event.keyCode != 13){
                if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                        (event.keyCode >= 96 && event.keyCode <= 105) ||
                        event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                        event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 188) {
                } else {
                    event.preventDefault();
                }
                if ($(this).val().indexOf(',') !== -1 && event.keyCode == 188)
                    event.preventDefault();
                //if a decimal has been added, disable the "."-button                
            }
       });               
        
        $(this).children().first().focus();
        $(this).children().first().keypress(function(e){
            var charCode = (e.which) ? e.which : event.keyCode

            if (
                (charCode != 45 || $(this).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
                (charCode != 46 || $(this).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
                (charCode < 48 || charCode > 57) && (charCode != 13)){
                return false;
            }

            if (e.which == 13){
                var newContent = $(this).val()
                var cell = $(this).parent();
                cell.text(newContent); 
                cell.removeClass("cellEditing");
                if($.trim(newContent) != OriginalContent){
                    saveChanges(cell);
                }
            } 
        }); 
        $(this).children().first().blur(function(){
            var cell = $(this).parent();
            cell.text(OriginalContent);
            cell.removeClass("cellEditing"); 
        }); 
    });
    
    function saveChanges(cell){
        var dataPost = {
            "id" : $(cell).closest("tr").data().id,
            "stock_id" : $(cell).closest("tr").data().stock,
            "qty" : $.trim(cell.html()),
        };
        
        $.ajax({
            url: "{{ route('store-chasier.save') }}",
            type: 'POST',
            dataType: 'json',
            data: dataPost,
            success: function (res) {
                if (res.success) {
                    get_detail();
                }else{
                    Command: toastr["error"](res.message)
                }
            }
        });
    }
</script>