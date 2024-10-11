<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Master') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">{{ __('Customer') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('customer.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Detail Customer') }}</h5>

                <div class="row p-3">
                    <div class="col-sm-2">
                        <strong>{{ __('Image') }}</strong>
                    </div>
                    <div class="col-sm-10">
                        @if(!empty($customer->image))
                        <img src="{{ asset($customer->image_url) }}" class="img-fluid img-view">
                        @endif
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-2">
                                <strong>{{ __('Name') }}</strong>
                            </div>
                            <div class="col-sm-4">
                                {{ $customer->name }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-2">
                                <strong>{{ __('Phone') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ $customer->phone }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-2">
                                <strong>{{ __('Id Card') }}</strong>
                            </div>
                            <div class="col-sm-4">
                                {{ $customer->id_card }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-2">
                                <strong>{{ __('Address') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ $customer->address }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-2">
                                <strong>{{ __('Created By') }}</strong>
                            </div>
                            <div class="col-sm-4">
                                {{ isset($customer->userCreated) ? $customer->userCreated->name : '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-2">
                                <strong>{{ __('Created At') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ $customer->created_at }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top"></div>
                <div class="row p-3">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-2">
                                <strong>{{ __('Updated By') }}</strong>
                            </div>
                            <div class="col-sm-4">
                                {{ isset($customer->userUpdated) ? $customer->userUpdated->name : '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-2">
                                <strong>{{ __('Updated At') }}</strong>
                            </div>
                            <div class="col-sm-10">
                                {{ $customer->updated_at }}
                            </div>
                        </div>
                    </div>
                </div>
                <fieldset class="border p-2">
                    <legend style="font-size: 15px; font-style: italic" class="w-auto">{{ __('List Car') }}</legend>

                    <div class="detail">

                    </div>
                </fieldset>

            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            get_detail();
        });

        function get_detail() {
            $.ajax({
                url: "{{ route('customerDetail') }}",
                type: 'GET',
                dataType: 'html',
                data: {
                    'view': 1,
                    'id': '<?= $customer->id ?>'
                },
                success: function (res) {
                    $('.detail').html(res);
                }
            });
        }
    </script>
</x-app-layout>