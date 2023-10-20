<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>{{ __('messages.marketings') }}</div>
                    <div>{{ __('messages.results_number') }} = {{ $marketings->total() }}</div>
                    @can('marketing_create')
                        <div><a class="btn btn-info" href="{{ route('marketing.form') }}">@lang('messages.add_marketing')</a></div>
                    @endcan
                </div>

                <div class="card-body">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                    @endif

                    {{-- filters --}}
                    <div x-data="{ search_form: false }">
                        <button @click="search_form = ! search_form" class="btn btn-sm btn-facebook mb-2">
                            <svg style="width: 15px;height: 15px">
                                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-search') }}"></use>
                            </svg>
                        </button>
                        <div x-show="search_form" x-collapse.duration.100ms style="display: none">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap flex-xxl-nowrap">
                                        <div class="form-group w-100">
                                            <label for="name">{{ __('messages.name') }}</label>
                                            <input wire:ignore wire:model="filter.name" type="text"
                                                id="name" class="form-control">
                                        </div>
                                        <div class="form-group w-100">
                                            <label for="phone">{{ __('messages.phone') }}</label>
                                            <input wire:ignore wire:model.debounce.1000ms="filter.phone"
                                                type="number" id="phone" class="form-control">
                                        </div>

                                    </div>

                                    <div class="d-flex flex-wrap flex-xxl-nowrap">

                                        <div wire:ignore class="form-group w-100">
                                            <label for="creator_id">{{ __('messages.creator') }}</label>
                                            <select data-model="creators" class="form-control select2" multiple
                                                style="width: 100%" id="creator_id">
                                                <option disabled value="">---</option>
                                                @foreach ($creators as $creator)
                                                    <option value="{{ $creator->id }}">{{ $creator->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div wire:ignore class="form-group w-100">
                                            <label for="type">{{ __('messages.type') }}</label>
                                            <select data-model="types" class="form-control select2"
                                                multiple="multiple" id="type" style="width: 100%">
                                                <option disabled value="">---</option>
                                                @foreach ($types as $type)
                                                    <option value="{{ $type }}">{{ __('messages.'.$type)  }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group w-100">
                                            <label for="start_created_at">{{ __('messages.created_at') }}</label>
                                            <input wire:ignore wire:model="filter.start_created_at" type="date"
                                                id="start_created_at" class="form-control">
                                            <input wire:ignore wire:model="filter.end_created_at" type="date"
                                                id="end_created_at" class="form-control">
                                        </div>


                                    </div>

                                    {{-- <button wire:click="export"
                                        class="btn btn-sm btn-facebook">{{ __('messages.export_to_excel') }}</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- filters --}}

                    <div wire:poll.30s class="table-responsive">

                        <table class="table table-hover table-outline mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">@lang('messages.created_at')</th>
                                    <th>@lang('messages.name')</th>
                                    <th class="text-center">{{ __('messages.tel') }}</th>
                                    <th class="">{{ __('messages.address') }}</th>
                                    <th class="">{{ __('messages.notes') }}</th>
                                    <th class="text-center">{{ __('messages.type') }}</th>
                                    <th class="text-center">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($marketings as $marketing)
                                    <tr>
                                        <td class="text-center" nowrap>
                                            <div class="small badge badge-pill badge-dark">
                                                {{ @$marketing->user->name }}
                                            </div>
                                            <div>{{ date('d-m-Y', strtotime($marketing->created_at)) }}</div>
                                            <div class="small">{{ date('H:i', strtotime($marketing->created_at)) }}
                                            </div>
                                        </td>
                                        <td>{{ $marketing->name }}</td>
                                        <td class="text-center">{{ $marketing->phone }}</td>
                                        <td>{{ $marketing->address }}</td>
                                        <td>{{ @$marketing->notes }}</td>
                                        <td class="text-center">{{ __('messages.' . $marketing->type) }}</td>
                                        <td class="text-center" nowrap>
                                            @can('marketing_edit')
                                                <a class="text-info btn btn-sm"
                                                    href="{{ route('marketing.form', $marketing->id) }}">
                                                    <svg style="width: 15px;height: 15px">
                                                        <use
                                                            xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-pencil') }}">
                                                        </use>
                                                    </svg>
                                                </a>
                                            @endcan
                                            {{-- @can('marketings_delete')
                                                <form class="d-inline" action=""
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger btn btn-sm"
                                                        onclick="return confirm('{{ __('messages.delete_r_u_sure') }}')">
                                                        <svg style="width: 15px;height: 15px">
                                                            <use
                                                                xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
                                                            </use>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endcan --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="6">
                                            <div>
                                                {{ __('messages.no_marketings_found') }}
                                            </div>
                                            @can('marketings_create')
                                                <div><a class="btn btn-info"
                                                        href="{{ route('marketings.form') }}">@lang('messages.add_marketing')</a></div>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class=" d-flex justify-content-between align-items-center mt-2">
                        <div>{{ $marketings->links() }}</div>
                        <select class=" form-control" style="width: fit-content;" wire:model="pagination">
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="500">500</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function popupWindow(url, windowName) {
            const w = window.outerWidth / 1.2;
            const h = window.outerHeight / 1.2;
            const y = window.top.outerHeight / 2 + window.top.screenY - (h / 2);
            const x = window.top.outerWidth / 2 + window.top.screenX - (w / 2);
            return window.open(url, windowName,
                `toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=${w}, height=${h}, top=${y}, left=${x}`
            );
        }

        $(document).ready(function() {

            $('.select2').select2({
                placeholder: "---",
                tags: false,
                dropdownAutoWidth: true,
                // allowClear: true,
                tokenSeparators: ['/', ','],
                textAlign: 'center',
            })

            $('.select2').on('change', function(e) {
                console.log(e.target.attributes['data-model'].value)
                @this.set('filter.' + e.target.attributes['data-model'].value, $(this).val());
                // index = e.target.attributes['data-index'].value;
                // value = e.target.value;
                // livewire.emit('selectedCompanyItem', index, value)
            });
        })
    </script>
@endpush

@section('title')
    <title>@lang('messages.marketings')</title>
@endsection
