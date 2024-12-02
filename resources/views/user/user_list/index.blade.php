<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('User List') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="div-top">
            <a class="btn btn-default" href="{{ route('user.create') }}">{{ __('Register User') }}</a>
        </div>
        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('User List') }}</h5>
                <div class="border-top"></div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {!! $message !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="table-responsive">
                    <table id="user" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Profile Picture') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                @if(Auth::user()->name == 'superadmin')
                                <th>{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $row)
                            <tr>
                                <td class="d-flex justify-content-center">
                                    @if ($row->profile_photo_path)
                                    <img src="{{ $row->profile_photo_path }}" alt="{{ $row->name }}"
                                        class="rounded-full h-16 w-16 object-cover">
                                    @else
                                    <div
                                        class="flex items-center justify-center rounded-full h-16 w-16 bg-gray-800 text-white text-sm font-bold">
                                        {{ strtoupper(substr($row->name, 0, 1)) }}
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    {{ $row->name }}
                                </td>
                                <td>
                                    {{ $row->email}}
                                </td>
                                @if(Auth::user()->name == 'superadmin')
                                <td class="action-button">
                                    <a class="btn btn-info" href="{{ route('user.show',$row->id) }}"><i
                                            class="fas fa-eye"></i></a>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        $('#user').DataTable();
    </script>


</x-app-layout>