<x-app-layout>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __('Unauthorized') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body text-center p-5">
                        <h1 class="display-4 text-danger font-bold">401</h1>
                        <h4 class="mb-3">{{ __('Unauthorized Access') }}</h4>
                        <p class="text-muted">You are not authorized to access this page.</p>
                        <div class="mt-4">
                            <a href="{{ url('/') }}" class="btn btn-default px-4">Go to Dashboard</a>
                            <a href="javascript:history.back()" class="btn btn-info px-4">Go Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>