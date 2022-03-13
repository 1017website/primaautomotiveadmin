<x-guest-layout>
    <div id="loginform">
        <div class="text-center p-t-20 p-b-20">
            <span class="db"><img src="{{asset('plugins/images/logo.png')}}" alt="logo"/></span>
        </div>
        
        @if (count($errors) > 0)
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form class="form-horizontal mt-3" id="loginform" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="row m-t-20">
                <div class="col-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                        </div>
                        <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required="">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-key"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required="">
                    </div>
                </div>
            </div>
            <div class="row border-top border-secondary">
                <div class="col-12">
                    <div class="form-group">
                        <div class="p-t-20">                                    
                            <button class="btn btn-success float-right" type="submit">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>