<x-app-layout>
    <style>
        [type='checkbox']:checked,
        [type='radio']:checked {
            background-color: rgb(31 41 55) !important;
        }
    </style>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('User Roles Configuration') }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('User Roles Configuration') }}</h5>
                <div class="border-top"></div>

                @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {!! $message !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <form method="POST" action="{{ route('user-role.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="user">{{ __('Select User') }}</label>
                        <select id="id_user" name="id_user" class="form-control">
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" id="selectAllButton" class="btn btn-info mb-2">{{ __('Select All')
                        }}</button>
                    <div style="height: 500px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                        @foreach ($menus->where('parent', 0) as $parentMenu)
                        <div class="py-1 pl-2 border ml-1">
                            <label>
                                <input type="checkbox" class="parentCheckbox" name="menus[]"
                                    id="dropdownCheckbox_{{ $parentMenu->id }}" value="{{ $parentMenu->id }}" {{
                                    in_array($parentMenu->id,
                                $user->assignedMenus ?? []) ? 'checked' : '' }}>
                                {{ $parentMenu->name }}
                            </label><br>
                        </div>

                        @foreach ($menus->where('parent', $parentMenu->id) as $childMenu)
                        <div class="py-1 pl-4 border ml-1 childDropdown_{{ $parentMenu->id }}"
                            style="display: none; margin-left: 20px;">
                            <label><input type="checkbox" name="menus[]" class="childCheckbox"
                                    value="{{ $childMenu->id }}" {{ in_array($childMenu->id,
                                $user->assignedMenus ?? []) ? 'checked' : '' }}>
                                {{ $childMenu->name }}</label><br>
                        </div>

                        @foreach ($menus->where('parent', $childMenu->id) as $grandChildMenu)
                        <div class="py-1 pl-5 border ml-1 grandChildDropdown_{{ $childMenu->id }}"
                            style="display: none; margin-left: 20px;">
                            <label><input class="grandChildCheckbox" type="checkbox" value="{{ $grandChildMenu->id }}" name="menus[]" {{
                                    in_array($grandChildMenu->id, $user->assignedMenus ?? []) ?
                                'checked' : '' }}>
                                {{ $grandChildMenu->name }}</label><br>
                        </div>
                        @endforeach
                        @endforeach
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-default mt-3">{{ __('Save Changes') }}</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            function loadUserMenus() {
                var userId = $('#id_user').val(); 

                $('.parentCheckbox, .childCheckbox, .grandChildCheckbox').prop('checked', false);
                $('.childDropdown, .grandChildDropdown').hide(); 
                
                if (userId) {
                    $.ajax({
                        url: "{{ route('user-role.getMenu') }}",
                        type: "GET",
                        data: { id_user: userId },
                        success: function (response) {
                            var assignedMenus = response.assignedMenus;

                            assignedMenus.forEach(function (menuId) {
                                var checkbox = $('input[value="' + menuId + '"]');
                                checkbox.prop('checked', true);

                                if (checkbox.hasClass('parentCheckbox')) {
                                    $('.childDropdown_' + menuId).show();
                                }

                                if (checkbox.hasClass('childCheckbox')) {
                                    $('.grandChildDropdown_' + menuId).show();
                                }
                            });
                        }
                    });
                }
            }

            $('#id_user').change(function () {
                loadUserMenus();
            });

            $(document).ready(function () {
                loadUserMenus();
            });

            $('.parentCheckbox').change(function () {
                var parentId = $(this).val();
                var isChecked = $(this).prop('checked');

                // Toggle child dropdown visibility
                $('.childDropdown_' + parentId).toggle(this.checked);

                // Check/uncheck all child checkboxes
                $('.childDropdown_' + parentId).find('input.childCheckbox').prop('checked', isChecked).trigger('change');
            });

            $('.childCheckbox').change(function () {
                var childId = $(this).val();
                var isChecked = $(this).prop('checked');

                // Toggle grandchild dropdown visibility
                $('.grandChildDropdown_' + childId).toggle(this.checked);

                // Check/uncheck all grandchild checkboxes
                $('.grandChildDropdown_' + childId).find('input.grandChildCheckbox').prop('checked', isChecked);
            });

            $('#selectAllButton').click(function () {
                var allChecked = $('input[type="checkbox"]').length === $('input[type="checkbox"]:checked').length;

                // Toggle all checkboxes
                $('input[type="checkbox"]').prop('checked', !allChecked);

                // Show or hide child and grandchild dropdowns based on selection
                $('.childDropdown, .grandChildDropdown').toggle(!allChecked);
            });

            $('#userRoles').DataTable();

            document.querySelectorAll('.parentCheckbox').forEach(function (checkbox) {
                checkbox.addEventListener('change', function() {
                    var parentId = this.value;
                    var childDropdown = document.querySelectorAll('.childDropdown_' + parentId);

                    childDropdown.forEach(function (dropdown) {
                        dropdown.style.display = checkbox.checked ? 'block' : 'none';
                    });
                });
            });

            document.querySelectorAll('.childCheckbox').forEach(function (checkbox) {
                checkbox.addEventListener('change', function() {
                    var childId = this.value;
                    var grandChildDropdown = document.querySelectorAll('.grandChildDropdown_' + childId);

                    grandChildDropdown.forEach(function (dropdown) {
                        dropdown.style.display = checkbox.checked ? 'block' : 'none';
                    });
                });
            });
        });
    </script>
</x-app-layout>