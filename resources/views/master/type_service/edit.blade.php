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
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('type-service.index') }}">{{ __('Type Service') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('type-service.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Edit Type Service') }}</h5>
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

                <form class="form-horizontal" action="{{ route('type-service.update', $typeService->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 text-left control-label col-form-label">{{ __('Name') }}</label>
                        <div class="col-sm-10">
                            <input value="{{ $typeService->name }}" type="text" class="form-control" id="name" name="name" placeholder="Name Type Service" required="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="color" class="col-sm-2 text-left control-label col-form-label">{{ __('Color') }}</label>
                        <div class="col-sm-8 input-group">
                            <select class="select2 form-select shadow-none mt-3" id="color" name="color[]" multiple="multiple" style="width: 100%">
                                <?php foreach ($color as $row) { ?>
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2" style="font-size:2rem;">
                            <a href="javascript:;" onclick="selectAll();"><i class="mdi mdi-playlist-check"></i></a> 
                            <a href="javascript:;" onclick="deSelectAll();"><i class="mdi mdi-playlist-remove"></i></a>
                        </div>
                    </div>

                    <input value="[{{ $typeService->color_id }}]" type="text" class="form-control hidden" id="color_text">

                    <div class="border-top"></div>
                    <button type="submit" class="btn btn-default btn-action">Save</button>
                </form>

            </div>
        </div>

    </div>

    <script>
        var select_ids = [];
        $(document).ready(function (e) {
            var color = $('#color_text').val();
            $('#color').val(JSON.parse(color)).change();

            $('select#color option').each(function (index, element) {
                select_ids.push($(this).val());
            });
        });

        function selectAll() {
            $('select#color').val(select_ids);
            $('#color').trigger('change');
        }

        function deSelectAll() {
            $('select#color').val('');
            $('#color').trigger('change');
        }
    </script>

</x-app-layout>