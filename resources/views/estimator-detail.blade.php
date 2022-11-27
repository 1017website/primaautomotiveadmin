<div class="detail-car">
    <h4 class="text-center" style="margin-bottom: 1.5rem;">Car</h4>
    <div class="image-car">
        <div class="row el-element-overlay">
            <?php foreach ($car->image as $row) { ?>
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="el-card-item">
                            <div class="el-card-avatar el-overlay-1"> <img src="{{ $row->image_url }}" alt="user" />
                                <div class="el-overlay">
                                    <ul class="list-style-none el-info">
                                        <li class="el-item"><a class="btn default btn-outline image-popup-vertical-fit el-link" href="{{ $row->image_url }}"><i class="mdi mdi-magnify-plus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="detail-car">

    <fieldset class="border p-2">

        <div class="hidden">
            <input type="text" class="form-control" id="session_id" name="session_id" required="true" value="{{ $session }}">
        </div>

        <legend style="font-size: 15px;" class="w-auto">{{ __('List Service') }}</legend>
        <button type="button" class="btn btn-default btn-action mt-2 mb-2" data-toggle="modal" data-target="#Modal2">{{ __('Add Service') }}</button>
        <button type="button" class="btn btn-default btn-action mt-2 mb-2" data-toggle="modal" data-target="#Modal3">{{ __('Add Additional Service') }}</button>

        <div class="detail">

        </div>
    </fieldset>

    <!-- Modal -->
    <div class="modal fade" id="Modal2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="service_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Service') }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="service_id" name="service_id" style="width: 100%;">                              
                                @foreach($services as $row)                                
                                <option value="{{$row->id}}">{{$row->name}}</option>    
                                @endforeach
                            </select>
                        </div>                                
                    </div>

                    <div class="form-group row">
                        <label for="service_qty" class="col-sm-2 text-left control-label col-form-label">{{ __('Qty') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="service_qty" name="service_qty" required="true" value="1">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="qty" class="col-sm-2 text-left control-label col-form-label">{{ __('Price') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="price" name="price" required="" readonly="">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default addService">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <!-- Modal -->
    <div class="modal fade" id="Modal3" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Additional Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="service_additional_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Additional Service') }}</label>
                        <div class="col-sm-10">
                            <select class="select2 form-control custom-select" id="service_additional_id" name="service_additional_id" style="width: 100%;">                              
                                @foreach($additionalServices as $row)                                
                                <option value="{{$row->id}}">{{$row->name}}</option>    
                                @endforeach
                            </select>
                        </div>                                
                    </div>

                    <div class="form-group row">
                        <label for="service_qty" class="col-sm-2 text-left control-label col-form-label">{{ __('Qty') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="service_qty" name="service_qty" required="true" value="1">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="price_additional" class="col-sm-2 text-left control-label col-form-label">{{ __('Price') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="price_additional" name="price_additional" required="" readonly="">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default addAdditionalService">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
</div>    

<div class="form-group row" style="margin-top:1.5rem;">
    <div class="col-sm-12 text-center">
        <a href="#" type="button" class="btn btn-default" id="btn-download"><i class="mdi mdi-download"></i>Download</a>
        <a href="#" type="button" class="btn btn-default" id="btn-order"><i class="mdi mdi-cart-plus"></i>Order</a>
    </div>
</div> 

<script src="{{asset('plugins/libs/magnific-popup/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('plugins/libs/magnific-popup/meg.init.js')}}"></script>

<script type="text/javascript">
$(document).ready(function ($) {

    $('#service_id').select2({});
    $('#service_additional_id').select2({});

    get_detail();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function get_detail() {
        $.ajax({
            url: "{{ route('detailEstimatorService') }}",
            type: 'POST',
            dataType: 'html',
            data: {
                'session_id': $('#session_id').val(),
            },
            success: function (res) {
                $('.detail').html(res);
            }
        });
    }

    $(".addService").click(function () {
        $.ajax({
            url: "{{ route('addEstimatorService') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                'session_id': $('#session_id').val(),
                'service_id': $('#service_id').val(),
                'service_qty': $('#service_qty').val(),
            },
            success: function (res) {
                if (res.success) {
                    $('#Modal2').modal('hide');
                    $('#Modal3').modal('hide');
                    get_detail();
                } else {
                    popup(res.message, 'error');
                }
            }
        });
    });
    $("#service_id").trigger("change");

    $(".addAdditionalService").click(function () {
        $.ajax({
            url: "{{ route('addEstimatorService') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                'session_id': $('#session_id').val(),
                'service_additional_id': $('#service_additional_id').val(),
                'service_qty': $('#service_qty').val(),
            },
            success: function (res) {
                if (res.success) {
                    $('#Modal2').modal('hide');
                    $('#Modal3').modal('hide');
                    get_detail();
                } else {
                    popup(res.message, 'error');
                }
            }
        });
    });
    $("#service_additional_id").trigger("change");
});

$(function () {
    $("input[id*='service_qty']").keydown(function (event) {
        if (event.shiftKey == true) {
            event.preventDefault();
        }
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
    });
});

$('#service_id').on('change', function () {
    if ($('#service_id').val() != '') {
        $.ajax({
            url: "{{ route('priceEstimatorService') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                'service_id': this.value
            },
            success: function (res) {
                $('#price').val(res.price);
                var price = document.getElementById('price');
                var formated = formatRupiah($('#price').val(), 'Rp. ');
                price.value = formated;
            }
        });
    }
});

$('#service_additional_id').on('change', function () {
    if ($('#service_additional_id').val() != '') {
        $.ajax({
            url: "{{ route('priceEstimatorService') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                'service_id': this.value
            },
            success: function (res) {
                $('#price_additional').val(res.price);
                var price = document.getElementById('price');
                var formated = formatRupiah($('#price').val(), 'Rp. ');
                price.value = formated;
            }
        });
    }
});

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
</script>