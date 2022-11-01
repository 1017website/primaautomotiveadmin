<x-app-layout>
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            background-color: #2255a4!important;
            border: none!important;
        }
    </style>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">{{ __('Attendance') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Manual') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('attendance.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Add Manual') }}</h5>
                <div class="border-top"></div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>{{ __('Whoops! ') }}</strong>{{ __('There were some problems with your input.') }}<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form class="form-horizontal" action="{{ route('attendance.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-sm-12">

                            <div class ="row">
                                <div class="col-sm-6">

                                    <div class="form-group row">
                                        <label for="date" class="col-sm-2 text-left control-label col-form-label">{{ __('Date') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <input type="text" class="form-control mydatepicker" id="date" name="date" value="{{ !empty(old('date'))?old('date'):date('d-m-Y') }}" placeholder="dd/mm/yyyy" autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="time" class="col-sm-2 text-left control-label col-form-label">{{ __('Time') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <input type="text" class="form-control timepicker" id="time" name="time" value="{{ !empty(old('time'))?old('time'):date('H:i:s') }}" placeholder="" autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="input-group-text form-control"><i class="fa fa-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="status" class="col-sm-2 text-left control-label col-form-label">{{ __('Status') }}</label>
                                        <div class="col-sm-8">
                                            <select class="select2 form-control custom-select" id="status" name="status" style="width: 100%;">                              
                                                <option value="in">In</option>
                                                <option value="out">Out</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="employee" class="col-sm-2 text-left control-label col-form-label">{{ __('Employee') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <select class="select2 form-select shadow-none mt-3" id="employee" name="employee[]" multiple="multiple" style="width: 100%">
                                                <?php foreach ($employee as $row) { ?>
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2" style="font-size:2rem;">
                                            <a href="javascript:;" onclick="selectAll();"><i class="mdi mdi-playlist-check"></i></a> 
                                            <a href="javascript:;" onclick="deSelectAll();"><i class="mdi mdi-playlist-remove"></i></a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="border-top"></div>
                            <button type="submit" class="btn btn-default btn-action">Save</button>

                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>

    <script>
        $('.timepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '06:00am',
            maxTime: '12:00pm',
            defaultTime: '08',
            startTime: '10:00',
            dynamic: false,
            dropdown: false,
            scrollbar: false
        });

        var select_ids = [];
        $(document).ready(function (e) {
            $('select#employee option').each(function (index, element) {
                select_ids.push($(this).val());
            });
        });

        function selectAll() {
            $('select#employee').val(select_ids);
            $('#employee').trigger('change');
        }

        function deSelectAll() {
            $('select#employee').val('');
            $('#employee').trigger('change');
        }
    </script>

</x-app-layout>