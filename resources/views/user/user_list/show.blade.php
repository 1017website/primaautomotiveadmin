<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Users') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">{{ __('User List')
                                    }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Show') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="div-top">
            <a class="btn btn-default" href="{{ route('user.index') }}">{{ __('Back') }}</a>
        </div>

        <form class="form-horizontal" action="{{ route('user.update', $user->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-section my-5" id="profile_information">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mx-3">
                            <h3 class="text-lg font-medium text-gray-900">User {{ $user->name }} Information</h3>
                            <p>Update your account's profile information and email address.</p>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card bg-white shadow default-border-radius">
                            <div class="card-body">
                                <div class="mx-3 py-5">
                                    <div class="profile-photo-section">
                                        <label for="profile_photo_path" class="text-lg">Photo</label>
                                        <div id="photo-preview-container">
                                            @if (!empty($user->profile_photo_path))
                                            <img id="current-photo" src="{{ asset($user->profile_photo_path) }}"
                                                alt="{{ $user->name }}" class="rounded-full h-20 w-20 object-cover">
                                            @else
                                            <div id="default-photo"
                                                class="flex items-center justify-center rounded-full h-20 w-20 bg-gray-800 text-white text-xl font-bold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            @endif
                                            <div id="new-photo-preview"
                                                class="rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                                                style="display: none;"></div>
                                        </div>

                                        <input type="file" id="profile_photo_path" name="profile_photo_path"
                                            class="hidden" accept="image/*">

                                        <button type="button"
                                            onclick="document.getElementById('profile_photo_path').click();"
                                            class="inline-flex items-center px-4 py-2 my-3 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition mt-2 mr-2">
                                            Select A New Photo
                                        </button>
                                    </div>


                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input id="name" type="text" name="name" class="form-control"
                                            value="{{ $user->name }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input id="username" type="text" name="username" class="form-control"
                                            value="{{ $user->username }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" name="email" class="form-control"
                                            value="{{ $user->email }}" readonly>
                                    </div>
                                    <div
                                        class="flex items-center justify-end py-3 bg-gray-50 text-right sm:rounded-bl-md sm:rounded-br-md">
                                        <button type="submit" class="btn btn-default">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- <form class="form-horizontal" action="{{ route('user.changePassword', $user->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-section my-5" id="change_password">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mx-3">
                            <h3 class="text-lg font-medium text-gray-900">Update User {{ $user->name }} Password</h3>
                            <p>Ensure your account is using a long, random password to stay secure.</p>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card bg-white shadow default-border-radius">
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                                @endif
                                <div class="mx-3 py-5">
                                    <div class="form-group">
                                        <label for="password">Current Password</label>
                                        <input type="password" class="form-control" id="current_password"
                                            name="current_password" required="true">
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password">New Password</label>
                                        <input id="new_password" type="password" name="new_password"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password_confirmation">New Password Confirmation</label>
                                        <input id="new_password_confirmation" type="password"
                                            name="new_password_confirmation" class="form-control" required>
                                    </div>

                                    <div
                                        class="flex items-center justify-end py-3 bg-gray-50 text-right sm:rounded-bl-md sm:rounded-br-md">
                                        <button type="submit" class="btn btn-default">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form> --}}

    </div>
    <script>
        const photoInput = document.getElementById('profile_photo_path');
        const currentPhoto = document.getElementById('current-photo');
        const newPhotoPreview = document.getElementById('new-photo-preview');
        const defaultPhoto = document.getElementById('default-photo'); 

        photoInput.addEventListener('change', function () {
            const file = photoInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    newPhotoPreview.style.display = 'block';
                    newPhotoPreview.style.backgroundImage = `url('${e.target.result}')`;
                    
                    if (currentPhoto) currentPhoto.style.display = 'none';
                    if (defaultPhoto) defaultPhoto.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });

    </script>

</x-app-layout>