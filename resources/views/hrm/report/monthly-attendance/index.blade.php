<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Report') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Daily Attendance') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Daily Attendance') }}</h5>
                <div class="border-top"></div>

                <div class="filter">

                    <!--date-->
                    <div class="form-group row">
                        <label for="month" class="col-sm-2 text-left control-label col-form-label">{{ __('Month')
                            }}</label>
                        <div class="col-sm-3 input-group">
                            <input type="month" class="form-control" id="month" name="month"
                                value="{{ !empty(old('month')) ? old('month') : date('Y-m') }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                            </div>
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
                <div class="view">

                </div>

            </div>
        </div>

    </div>

    <script>
        $("#search").click(function () {
            $.ajax({
                url: "{{ route('attendanceViewMonth') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    'month': $('#month').val(),
                },
                success: function (res) {
                    console.log(res);
                    if (res.success) {
                        $('.view').html(res.html);
                    } else {
                        Command: toastr["error"](res.message);
                    }
                }
            });
        });

        $("body").off("click", "#print").on("click", "#print", function ()
        {
            var w = window.open(),
                    newstr = $('.view').html();
            $.get("{{asset('css/report.css')}}", function (css) {
                var judul = "Report Attendance";
                w.document.write("<html>");
                w.document.write("<head>");
                w.document.write("<style>");
                w.document.write(css);
                w.document.write("@page { size: landscape; }"); 
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