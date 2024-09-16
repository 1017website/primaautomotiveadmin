<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('User') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('User') }}</h5>
                <div class="border-top"></div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {!! $message !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <form action="{{ route('user.edit') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table id="user" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Store') }}</th>
                                    <th>{{ __('Workshop') }}</th>
                                    <th>{{ __('Prima X Shine') }}</th>
                                    <th>{{ __('HRM') }}</th>
                                    <th>{{ __('Setting') }}</th>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Estimator') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $row)
                                <tr>
                                    <td>{{ $row->name }}</td>

                                    <!-- Hidden input to send 0 when checkbox is unchecked -->
                                    <td>
                                        <input type="hidden" name="roles[{{ $row->id }}][store]" value="0">
                                        <input type="checkbox" name="roles[{{ $row->id }}][store]" value="1" {{
                                            $row->is_store == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="hidden" name="roles[{{ $row->id }}][workshop]" value="0">
                                        <input type="checkbox" name="roles[{{ $row->id }}][workshop]" value="1" {{
                                            $row->is_workshop == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="hidden" name="roles[{{ $row->id }}][wash]" value="0">
                                        <input type="checkbox" name="roles[{{ $row->id }}][wash]" value="1" {{
                                            $row->is_wash == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="hidden" name="roles[{{ $row->id }}][hrm]" value="0">
                                        <input type="checkbox" name="roles[{{ $row->id }}][hrm]" value="1" {{
                                            $row->is_hrm == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="hidden" name="roles[{{ $row->id }}][setting]" value="0">
                                        <input type="checkbox" name="roles[{{ $row->id }}][setting]" value="1" {{
                                            $row->is_setting == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="hidden" name="roles[{{ $row->id }}][user]" value="0">
                                        <input type="checkbox" name="roles[{{ $row->id }}][user]" value="1" {{
                                            $row->is_user == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="hidden" name="roles[{{ $row->id }}][estimator]" value="0">
                                        <input type="checkbox" name="roles[{{ $row->id }}][estimator]" value="1" {{
                                            $row->is_estimator == 1 ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-info">{{ __('Save Changes') }}</button>
                </form>

            </div>
        </div>

    </div>

    <script>
        $('#user').DataTable();
    </script>


</x-app-layout>