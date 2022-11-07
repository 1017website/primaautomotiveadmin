<x-app-layout>
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            background-color: #2255a4!important;
            border: none!important;
        }

        .form-control:disabled, .form-control[readonly] {
            background-color: #f3f3f3!important;
            opacity: 1;
        }
    </style>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('payroll.index') }}">{{ __('Payroll') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('payroll.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Add Payroll') }}</h5>
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

                <form class="form-horizontal" action="{{ route('payroll.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-sm-12">

                            <div class ="row">
                                <div class="col-sm-6">

                                    <div class="form-group row">
                                        <label for="start_date" class="col-sm-2 text-left control-label col-form-label">{{ __('Start Date') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <input type="text" class="form-control mydatepicker" id="start_date" name="start_date" value="{{ !empty(old('start_date'))?old('start_date'):date('d-m-Y') }}" placeholder="dd/mm/yyyy" autocomplete="off" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text form-control"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="employee_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Employee') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <select class="select2 form-select shadow-none mt-3" id="employee_id" name="employee_id" style="width: 100%">
                                                <?php foreach ($employee as $row) { ?>
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="employee_salary" class="col-sm-2 text-left control-label col-form-label">{{ __('Salary/Day') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="employee_salary" name="employee_salary" placeholder="" value="{{ old('employee_salary') }}" required readonly="true">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="positional_allowance" class="col-sm-2 text-left control-label col-form-label">{{ __('Position Allowance') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="positional_allowance" name="positional_allowance" value="{{ old('positional_allowance') }}" required readonly="true">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="healthy_allowance" class="col-sm-2 text-left control-label col-form-label">{{ __('Healthy Allowance') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="healthy_allowance" name="healthy_allowance" value="{{ old('healthy_allowance') }}" required readonly="true">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="other_allowance" class="col-sm-2 text-left control-label col-form-label">{{ __('Other Allowance') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="other_allowance" name="other_allowance" value="{{ old('other_allowance') }}" required readonly="true">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="bonus" class="col-sm-2 text-left control-label col-form-label nominal">{{ __('Bonus') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <input type="text" class="form-control" id="bonus" name="bonus" value="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="description_other" class="col-sm-2 text-left control-label col-form-label">{{ __('Other Description') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <input type="text" class="form-control" id="description_other" name="description_other" value="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="total_other" class="col-sm-2 text-left control-label col-form-label nominal">{{ __('Other Nominal') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <input type="text" class="form-control" id="total_other" name="total_other" value="">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group row">
                                        <label for="month" class="col-sm-2 text-left control-label col-form-label">{{ __('Month') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <input type="text" class="form-control" id="month" name="month" value="{{ date('F') }}" readonly="true">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="attendance" class="col-sm-2 text-left control-label col-form-label">{{ __('Attendance') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <input type="text" class="form-control" id="attendance" name="attendance" value="" readonly="true">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="penalty" class="col-sm-2 text-left control-label col-form-label nominal">{{ __('Penalty') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <input type="text" class="form-control" id="penalty" name="penalty" value="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="credit" class="col-sm-2 text-left control-label col-form-label">{{ __('Credit') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <input type="text" class="form-control" id="credit" name="credit" value="" readonly="true">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="total_salary" class="col-sm-2 text-left control-label col-form-label">{{ __('Take Home Pay') }}</label>
                                        <div class="col-sm-8 input-group">
                                            <input type="text" class="form-control" id="total_salary" name="total_salary" value="" readonly="true">
                                        </div>
                                        <label for="total_salary_description" class="col-sm-12 text-left control-label col-form-label" style="font-size: 11px;font-style: italic;">
                                            {{ __('Take Home Pay : ((Salary/Day * Attendance) + Position Allowance + Healthy Allowance + Other Allowance + Bonus + Other Nominal) - (Penalty + Credit)') }}
                                        </label>
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
        $("#start_date").on("change", function () {
            getAttendance();
        });

        $("#employee_id").on("change", function () {
            getAttendance();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getAttendance() {
            var date = $("#start_date").val();
            var employeeId = $("#employee_id").val();

            $.ajax({
                url: "{{ route('payroll.getAttendance') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    'date': date,
                    'employee_id': employeeId
                },
                success: function (res) {
                    if (res.success) {
                        resp = res.response;
                        $('#attendance').val(resp.attendance + ' Days');

                        $('#employee_salary').val(resp.salary);
                        var formated = formatRupiah($('#employee_salary').val(), 'Rp. ');
                        $('#employee_salary').val(formated);

                        $('#positional_allowance').val(resp.positional_allowance);
                        var formated = formatRupiah($('#positional_allowance').val(), 'Rp. ');
                        $('#positional_allowance').val(formated);

                        $('#healthy_allowance').val(resp.healthy_allowance);
                        var formated = formatRupiah($('#healthy_allowance').val(), 'Rp. ');
                        $('#healthy_allowance').val(formated);

                        $('#other_allowance').val(resp.other_allowance);
                        var formated = formatRupiah($('#other_allowance').val(), 'Rp. ');
                        $('#other_allowance').val(formated);

                        $('#credit').val(resp.credit);
                        var formated = formatRupiah($('#credit').val(), 'Rp. ');
                        $('#credit').val(formated);

                        totalSalary();
                    } else {
                        Command: toastr["error"](res.message);
                    }
                }
            });
        }

        $("input[id*='bonus']").keyup(function (event) {
            totalSalary();
        });

        $("input[id*='total_other']").keyup(function (event) {
            totalSalary();
        });

        $("input[id*='penalty']").keyup(function (event) {
            totalSalary();
        });

        //number format
        var bonus = document.getElementById('bonus');
        $(document).ready(function () {
            var formated = formatRupiah($('#bonus').val(), 'Rp. ');
            bonus.value = formated;
        });
        bonus.addEventListener('keyup', function (e) {
            bonus.value = formatRupiah(this.value, 'Rp. ');
        });

        var total_other = document.getElementById('total_other');
        $(document).ready(function () {
            var formated = formatRupiah($('#total_other').val(), 'Rp. ');
            total_other.value = formated;
        });
        total_other.addEventListener('keyup', function (e) {
            total_other.value = formatRupiah(this.value, 'Rp. ');
        });

        var penalty = document.getElementById('penalty');
        $(document).ready(function () {
            var formated = formatRupiah($('#penalty').val(), 'Rp. ');
            penalty.value = formated;
        });
        penalty.addEventListener('keyup', function (e) {
            penalty.value = formatRupiah(this.value, 'Rp. ');
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

        function totalSalary() {
            $('#total_salary').val('');

            var attendance = $('#attendance').val();
            var attendance = attendance.replace(/[^\d,-]/g, '');
            var attendance = attendance.replace(',', '.');
            var attendance = parseInt(attendance) || 0;

            var salary = $('#employee_salary').val();
            var salary = salary.replace(/[^\d,-]/g, '');
            var salary = salary.replace(',', '.');
            var salary = parseInt(salary) || 0;

            var positional_allowance = $('#positional_allowance').val();
            var positional_allowance = positional_allowance.replace(/[^\d,-]/g, '');
            var positional_allowance = positional_allowance.replace(',', '.');
            var positional_allowance = parseInt(positional_allowance) || 0;

            var healthy_allowance = $('#healthy_allowance').val();
            var healthy_allowance = healthy_allowance.replace(/[^\d,-]/g, '');
            var healthy_allowance = healthy_allowance.replace(',', '.');
            var healthy_allowance = parseInt(healthy_allowance) || 0;

            var other_allowance = $('#other_allowance').val();
            var other_allowance = other_allowance.replace(/[^\d,-]/g, '');
            var other_allowance = other_allowance.replace(',', '.');
            var other_allowance = parseInt(other_allowance) || 0;

            var bonus = $('#bonus').val();
            var bonus = bonus.replace(/[^\d,-]/g, '');
            var bonus = bonus.replace(',', '.');
            var bonus = parseInt(bonus) || 0;

            var total_other = $('#total_other').val();
            var total_other = total_other.replace(/[^\d,-]/g, '');
            var total_other = total_other.replace(',', '.');
            var total_other = parseInt(total_other) || 0;

            var credit = $('#credit').val();
            var credit = credit.replace(/[^\d,-]/g, '');
            var credit = credit.replace(',', '.');
            var credit = parseInt(credit) || 0;

            var penalty = $('#penalty').val();
            var penalty = penalty.replace(/[^\d,-]/g, '');
            var penalty = penalty.replace(',', '.');
            var penalty = parseInt(penalty) || 0;

            var total = ((parseFloat(salary) * parseFloat(attendance)) + parseFloat(positional_allowance) + parseFloat(healthy_allowance) + parseFloat(other_allowance) + parseFloat(bonus) + parseFloat(total_other)) - (parseFloat(credit) + parseFloat(penalty));
            if (total < 0) {
                var total = 0;
            }
            $('#total_salary').val(total);
            var formated = formatRupiah($('#total_salary').val(), 'Rp. ');
            $('#total_salary').val(formated);

        }
        //number format
    </script>

</x-app-layout>