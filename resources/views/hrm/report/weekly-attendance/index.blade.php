<x-app-layout>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Report') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Weekly Attendance') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Weekly Attendance') }}</h5>
                <div class="border-top"></div>

                <div class="filter">
                    <!-- Week selection -->
                    <div class="form-group row">
                        <label for="week" class="col-sm-2 text-left control-label col-form-label">{{ __('Week')
                            }}</label>
                        <div class="col-sm-3 input-group">
                            <input type="week" class="form-control" id="week" name="week" value="{{ date('Y-\WW') }}"
                                required>
                            <div class="input-group-append">
                                <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="location" class="col-sm-2 text-left control-label col-form-label">{{ __('Location')
                            }}</label>
                        <div class="col-sm-3 input-group">
                            <select class="form-control" id="location" name="location" required>
                                <option value="all">All</option>
                                <option value="Prima Automotive">Prima Automotive</option>
                                <option value="Shine Barrier">Shine Barrier</option>
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
                <div class="view"></div>
            </div>
        </div>
    </div>

    <script>
        $("#search").click(function () {
            $.ajax({
                url: "{{ route('attendanceViewWeek') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    'week': $('#week').val(),
                    'location': $('#location').val()
                },
                success: function (res) {
                    console.log(res);
                    if (res.success) {
                        $('.view').html(res.html);
                    } else {
                        toastr["error"](res.message);
                    }
                }
            });
        });

        $("body").off("click", "#print").on("click", "#print", function () {
            var w = window.open(),
                newstr = $('.view').html();
            $.get("{{ asset('css/report.css') }}", function (css) {
                var title = "Weekly Attendance Report";
                w.document.write("<html><head><style>" + css + "@page { size: landscape; }</style></head>");
                w.document.write("<body><div class='title-report'>" + title + "</div>" + newstr + "</body></html>");
                setTimeout(function () {
                    w.print();
                    w.close();
                }, 600);
            });
        });
    </script>
</x-app-layout>