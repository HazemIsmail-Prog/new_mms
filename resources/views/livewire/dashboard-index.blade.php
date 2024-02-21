<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('messages.dashboard') }}</div>
                <div class="card-body">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            @livewire('dashboard.orders-chart')
                        </div>
                        <div class="col-md-9">
                            @livewire('dashboard.orders-status-counter')
                            @livewire('dashboard.marketing-counter')
                        </div>
                        <div class="col-md-3">
                            @livewire('dashboard.department-technician-counter')
                        </div>
                        <div class="col-md-12">
                            @livewire('dashboard.technician-timing')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('title')
    <title>@lang('messages.dashboard')</title>
@endsection
