<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Prima X Shine') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Assets') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('wash-asset.create') }}">{{ __('Create') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Assets') }}</h5>
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
                    <table id="assets" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Quantity')}}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Updated By') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Updated At') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assets as $row)
                            <tr>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->quantity }}</td>
                                <td>{{ isset($row->userCreated) ? $row->userCreated->name : '-' }}</td>
                                <td>{{ isset($row->userUpdated) ? $row->userUpdated->name : '-' }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td>{{ $row->updated_at }}</td>
                                <td class="action-button">
                                    <form action="{{ route('wash-asset.destroy',$row->id) }}" method="POST">
                                        <a class="btn btn-default" href="{{ route('wash-asset.edit',$row->id) }}"><i
                                                class="fas fa-pencil-alt"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <script>
        $('#assets').DataTable();
    </script>


</x-app-layout>