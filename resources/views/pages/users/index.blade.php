@extends('layouts.app')

@section('title')
<title>@lang('messages.users')</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>@lang('messages.users')</div>
                        @can('users_create')
                            <div><a class="btn btn-info"
                                    href="{{route('users.create')}}">@lang('messages.add_user')</a></div>
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
                                    <th>@lang('messages.name')</th>
                                    <th class="text-center">@lang('messages.username')</th>
                                    <th class="text-center">@lang('messages.title')</th>
                                    <th class="text-center">@lang('messages.department')</th>
                                    <th class="text-center">@lang('messages.roles')</th>
                                    <th class="text-center">@lang('messages.status')</th>
                                    <th class="text-center">@lang('messages.actions')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td class="text-center">{{$user->username}}</td>
                                        <td class="text-center">{{$user->title->name}}</td>
                                        <td class="text-center">{{$user->departments->pluck('name')->implode(' - ')}}</td>
                                        <td class="text-center">{{$user->roles->pluck('name')->implode(' - ')}}</td>
                                        <td class="text-center">
                                        <span
                                            class="badge badge-pill {{$user->active == 1 ? 'badge-success' : 'badge-danger' }}">
                                            {{$user->active == 1 ? __('messages.active') : __('messages.inactive') }}
                                        </span>

                                        </td>
                                        <td class="text-center" nowrap>
                                            @can('users_edit')
                                                <a class="text-info btn btn-sm" href="{{route('users.edit',$user)}}">
                                                    <svg style="width: 15px;height: 15px">
                                                        <use
                                                            xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-pencil')}}"></use>
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('users_create')
                                                <a class="text-success btn btn-sm" href="{{route('users.replicate',$user)}}">
                                                    <svg style="width: 15px;height: 15px">
                                                        <use
                                                            xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-copy')}}"></use>
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('users_delete')
                                                <form class="d-inline" action="{{route('users.destroy',$user)}}"
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
                                        <td colspan="7">No results</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="7">
                                        {{$users->links()}}
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
