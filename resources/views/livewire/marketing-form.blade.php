<div class="card">
    <div class="card-header">@lang('messages.add_marketing')</div>
    <div class="card-body">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-lg-3">
                        <label for="name">@lang('messages.name')</label>
                        <input autofocus autocomplete="off" type="text" wire:model.lazy="marketing.name" id="name"
                            class="form-control @error('marketing.name') is-invalid @enderror">
                        @error('marketing.name')
                            <span class="small text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="phone">@lang('messages.phone')</label>
                        <input autofocus autocomplete="off" type="text" wire:model.lazy="marketing.phone" id="phone"
                            class="form-control @error('marketing.phone') is-invalid @enderror">
                        @error('marketing.phone')
                            <span class="small text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="address">@lang('messages.address')</label>
                        <input autofocus autocomplete="off" type="text" wire:model.lazy="marketing.address" id="address"
                            class="form-control @error('marketing.address') is-invalid @enderror">
                        @error('marketing.address')
                            <span class="small text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="type">@lang('messages.type')</label>
                        <select wire:model.lazy="marketing.type" name="type" id="type"
                            class="form-control @error('marketing.type') is-invalid @enderror">
                            <option value="">---</option>
                            <option value="marketing">{{ __('messages.marketing') }}</option>
                            <option value="information">{{ __('messages.information') }}</option>
                            <option value="service_not_available">{{ __('messages.service_not_available') }}</option>
                        </select>
                        @error('marketing.type')
                            <span class="small text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="notes">@lang('messages.notes')</label>
                        <input autocomplete="off" type="text" wire:model.lazy="marketing.notes" id="notes"
                            class="form-control @error('marketing.notes') is-invalid @enderror">
                        @error('marketing.notes')
                            <span class="small text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-center">
        <button wire:click.prevent="save" class="btn btn-facebook"
            type="submit">@lang('messages.save')</button>
        <a href="{{ route('marketing.index') }}" class="btn btn-ghost-danger" type="button">@lang('messages.back')</a>
    </div>
</div>


@section('title')
    <title>@lang('messages.marketing')</title>
@endsection
