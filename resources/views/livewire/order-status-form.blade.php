<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form wire:submit.prevent="save">
                <div class="card">
                    <div class="card-header">@lang('messages.edit_order_status')</div>
                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ Session::get('success') }}
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                            </div>
                        @endif

                        <input required class="form-control form-control-sm" type="number" wire:model="order_id"
                            placeholder="{{ __('messages.order_number') }}">
                        <table class=" table">
                            <thead class=" text-center">
                                <th>{{ __('messages.status') }}</th>
                                <th>{{ __('messages.technician') }}</th>
                                <th>{{ __('messages.date') }}</th>
                                <th>{{ __('messages.time') }}</th>
                                <th>{{ __('messages.user') }}</th>
                                <th></th>
                            </thead>
                            <tbody class=" text-center">
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td>
                                            <select required wire:model="rows.{{ $index }}.status_id"
                                                class=" form-control form-control-sm">
                                                <option value=""></option>
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select wire:model="rows.{{ $index }}.technician_id"
                                                class=" form-control form-control-sm">
                                                <option value=""></option>
                                                @foreach ($users->whereIn('title_id', [10, 11]) as $technician)
                                                    <option value="{{ $technician->id }}">{{ $technician->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input required wire:model="rows.{{ $index }}.date"
                                                class=" form-control form-control-sm" type="date"></td>
                                        <td><input required wire:model="rows.{{ $index }}.time"
                                                class=" form-control form-control-sm" type="time"></td>
                                        <td>
                                            <select required wire:model="rows.{{ $index }}.user_id"
                                                class=" form-control form-control-sm">
                                                <option value=""></option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <button wire:click.prevent="delete_row({{ $index }})" type="submit"
                                                class="text-danger btn btn-sm">
                                                <svg style="width: 15px;height: 15px">
                                                    <use
                                                        xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
                                                    </use>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <button tabindex="-1" wire:click.prevent="add_row()"
                                            class="btn btn-sm btn-ghost-success">{{ __('messages.add_row') }}</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer text-center">
                        <button class="btn btn-facebook" type="submit">@lang('messages.update')</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

@section('title')
    <title>@lang('messages.edit_order_status')</title>
@endsection
