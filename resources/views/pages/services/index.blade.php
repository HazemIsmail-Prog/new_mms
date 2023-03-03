@extends('layouts.app')

@section('title')
<title>@lang('messages.services')</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>@lang('messages.services')</div>
                        @can('services_create')
                            <div>
                                <a class="btn btn-info"
                                   href="{{route('services.create')}}">@lang('messages.add_service')</a>
                            </div>
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

                        <div class="table-responsive">

                            <table class="table table-hover table-outline mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th>@lang('messages.service')</th>
                                    <th class="text-center">@lang('messages.min_price')</th>
                                    <th class="text-center">@lang('messages.max_price')</th>
                                    <th class="text-center">@lang('messages.department')</th>
                                    <th class="text-center">@lang('messages.status')</th>
                                    <th class="text-center">@lang('messages.actions')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($services->sortBy('name') as $service)
                                    <tr>
                                        <td>{{$service->name}}</td>
                                        <td class=" text-center">{{$service->min_price}}</td>
                                        <td class=" text-center">{{$service->max_price}}</td>
                                        <td class=" text-center">{{$service->department->name}}</td>
                                        <td class="text-center">
                                        <span
                                            class="badge badge-pill {{$service->active == 1 ? 'badge-success' : 'badge-danger' }}">
                                            {{$service->active == 1 ? __('messages.active') : __('messages.inactive') }}
                                        </span>
                                        </td>
                                        <td class="text-center" nowrap>
                                            @can('services_edit')

                                                <a class="text-info btn btn-sm"
                                                   href="{{route('services.edit',$service)}}">
                                                    <svg style="width: 15px;height: 15px">
                                                        <use
                                                            xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-pencil')}}"></use>
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('services_delete')
                                                <form class="d-inline"
                                                      action="{{route('services.destroy',$service)}}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger btn btn-sm"
                                                            onclick="return confirm('{{__('messages.delete_r_u_sure')}}')">
                                                        <svg style="width: 15px;height: 15px">
                                                            <use
                                                                xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-trash')}}"></use>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="3">No results</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            {{$services->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
