<x-guest-layout>
    <div id="loginform">
                        
        @if (count($errors) > 0)
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <div id="confirmform">
            <div class="text-center">
                <span class="text-white">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</span>
            </div>
            <div class="row m-t-20">
                <form class="col-12" method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <div class="input-group mb-3 mt-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-danger text-white" id="basic-addon1"><i class="ti-pencil"></i></span>
                        </div>
                        <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required="">
                    </div>
                    <div class="row m-t-20 p-t-20 pt-3 border-top border-secondary">
                        <div class="col-12">
                            <button class="btn btn-info float-right" type="submit">{{ __('Confirm') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-guest-layout>