<div x-data="{ search_form: false }">
    <button @click="search_form = ! search_form" class="btn btn-sm btn-facebook mb-2">
        <svg style="width: 15px;height: 15px">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-search') }}"></use>
        </svg>
    </button>
    <div x-show="search_form" x-collapse.duration.100ms style="display: none">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('orders.index') }}">
                    <div class="d-flex flex-wrap flex-xxl-nowrap">
                        <div class="form-group w-100">
                            <label for="name">{{ __('messages.customer_name') }}</label>
                            <input autocomplete="off" list="autocompleteOff" type="text"
                                name="name" id="name" class="form-control"
                                value="{{ request('name') }}">
                        </div>
                        <div class="form-group w-100">
                            <label for="phone">{{ __('messages.customer_phone') }}</label>
                            <input autocomplete="off" list="autocompleteOff" type="number"
                            name="phone" id="phone" class="form-control"
                            value="{{ request('phone') }}">
                        </div>
                        <div class="form-group w-100">
                            <label for="area_id">{{ __('messages.area') }}</label>
                            <select class="form-control select2" multiple style="width: 100%" name="area_id[]" id="area_id">
                                <option disabled value="">---</option>
                                @foreach ($areas->sortBy->name as $area)
                                <option 
                                {{ request('area_id') ? (in_array($area->id, request('area_id')) ? 'selected' : '') : '' }}
                                value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group w-100">
                            <label for="block">{{ __('messages.block') }}</label>
                            <input autocomplete="off" list="autocompleteOff" type="text"
                            name="block" id="block" class="form-control"
                            value="{{ request('block') }}">
                        </div>
                        <div class="form-group w-100">
                            <label for="street">{{ __('messages.street') }}</label>
                            <input autocomplete="off" list="autocompleteOff" type="text"
                            name="street" id="street" class="form-control"
                            value="{{ request('street') }}">
                        </div>
                    </div>
                    
                    <div class="d-flex flex-wrap flex-xxl-nowrap">
                        
                        <div class="form-group w-100">
                            <label for="order_number">{{ __('messages.order_number') }}</label>
                            <input autocomplete="off" list="autocompleteOff" type="number"
                                name="order_number" id="order_number" class="form-control"
                                value="{{ request('order_number') }}">
                        </div>
                        <div class="form-group w-100">
                            <label for="creator_id">{{ __('messages.creator') }}</label>
                            <select class="form-control select2" multiple style="width: 100%" name="creator_id[]" id="creator_id">
                                <option disabled value="">---</option>
                                @foreach ($creators as $creator)
                                    <option
                                        {{ request('creator_id') ? (in_array($creator->id, request('creator_id')) ? 'selected' : '') : '' }}
                                        value="{{ $creator->id }}">{{ $creator->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group w-100">
                            <label for="status_id">{{ __('messages.status') }}</label>
                            <select class="form-control select2" multiple="multiple"
                                name="status_id[]" id="status_id" style="width: 100%">
                                <option disabled value="">---</option>
                                @foreach ($statuses as $status)
                                    <option
                                        {{ request('status_id') ? (in_array($status->id, request('status_id')) ? 'selected' : '') : '' }}
                                        value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group w-100">
                            <label for="technician_id">{{ __('messages.technician') }}</label>
                            <select class="form-control select2" style="width: 100%" multiple name="technician_id[]" id="technician_id">
                                <option disabled value="">---</option>
                                @foreach ($technicians as $technician)
                                    <option
                                        {{ request('technician_id') ? (in_array($technician->id, request('technician_id')) ? 'selected' : '') : '' }}
                                        value="{{ $technician->id }}">{{ $technician->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group w-100">
                            <label for="department_id">{{ __('messages.department') }}</label>
                            <select class="form-control select2" multiple style="width: 100%" name="department_id[]" id="department_id">
                                <option disabled value="">---</option>
                                @foreach ($departments as $department)
                                    <option
                                        {{ request('department_id') ? (in_array($department->id, request('department_id')) ? 'selected' : '') : '' }}
                                        value="{{ $department->id }}">{{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group w-100">
                            <label for="start_created_at">{{ __('messages.created_at') }}</label>
                            <input autocomplete="off" list="autocompleteOff" type="date"
                                name="start_created_at" id="start_created_at" class="form-control"
                                value="{{ request('start_created_at') }}">
                            <input autocomplete="off" list="autocompleteOff" type="date"
                                name="end_created_at" id="end_created_at" class="form-control"
                                value="{{ request('end_created_at') }}">
                        </div>

                        <div class="form-group w-100">
                            <label
                                for="start_created_at">{{ __('messages.completed_at') }}</label>
                            <input autocomplete="off" list="autocompleteOff" type="date"
                                name="start_completed_at" id="start_completed_at"
                                class="form-control" value="{{ request('start_completed_at') }}">
                            <input autocomplete="off" list="autocompleteOff" type="date"
                                name="end_completed_at" id="end_completed_at"
                                class="form-control" value="{{ request('end_completed_at') }}">
                        </div>


                    </div>

                    <div class="text-center">
                        <button class="btn btn-sm btn-facebook" name="action"
                            value="search">{{ __('messages.search') }}</button>
                        <button class="btn btn-sm btn-facebook" name="action"
                            value="excel">{{ __('messages.export_to_excel') }}</button>
                        @if (request()->input())
                            <a href="{{ route('orders.index') }}"
                                class="btn btn-sm btn-danger">{{ __('messages.cancel') }}</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
