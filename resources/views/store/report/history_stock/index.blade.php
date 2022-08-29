<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Report') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('History Stock Store') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Current Stock Store') }}</h5>
                <div class="border-top"></div>

                <div class="filter">

                    <!--date-->
                    <div class="form-group row">
                        <label for="date" class="col-sm-2 text-left control-label col-form-label">{{ __('Date') }}</label>
                        <div class="col-sm-3 input-group">
                            <input type="text" class="form-control mydatepicker" id="date_1" name="date_1" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                            <div class="input-group-append">
                                <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-3 input-group">
                            <input type="text" class="form-control mydatepicker" id="date_2" name="date_2" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                            <div class="input-group-append">
                                <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>

                    <!--type item-->
                    <div class="form-group row">
                        <label for="type_item" class="col-sm-2 text-left control-label col-form-label">{{ __('Type Item') }}</label>
                        <div class="col-sm-3">
                            <select class="select2 form-control custom-select" id="type_product_id" name="type_product_id" style="width: 100%;">
                                <option value="ALL">ALL</option> 
                                @foreach($typeProducts as $typeProduct)                                
                                <option value="{{$typeProduct->id}}">{{$typeProduct->name}}</option>    
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 input-group">
                            <button type="button" class="btn btn-default" id="search">Show</button>
                            <button type="button" class="btn btn-default" id="print">Print</button>
                        </div>
                    </div>

                </div>
                <div class="border-top"></div>
                <div class="detail">

                </div>

            </div>
        </div>

    </div>

    <script>
        $("#search").click(function () {
            $.ajax({
                url: "{{ route('historyStockViewStore') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    'date_1': $('#date_1').val(),
                    'date_2': $('#date_2').val(),
                    'type_product_id': $('#type_product_id').val()
                },
                success: function (res) {
                    console.log(res);
                    if (res.success) {
                        $('.detail').html(res.html);
                    } else {
                        Command: toastr["error"](res.message);
                    }
                }
            });
        });

        $("body").off("click", "#print").on("click", "#print", function ()
        {
            var w = window.open(),
                    newstr = $('.detail').html();
            $.get("{{asset('css/report.css')}}", function (css) {
                var judul = "Report History Stock Store";
                w.document.write("<html>");
                w.document.write("<head>");
                w.document.write("<style>");
                w.document.write(css);
                w.document.write("</style>");
                w.document.write("</head>");
                w.document.write("<body>");
                w.document.write("<div class=\"title-report\">" + judul + "</div>");
                w.document.write(newstr);
                w.document.write("</body>");
                w.document.write("</html>");
                setTimeout(function () {
                    w.print();
                    w.close();
                }, 600);
            });
        });
    </script>


</x-app-layout>