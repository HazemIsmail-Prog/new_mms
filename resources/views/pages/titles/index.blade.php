@extends('layouts.app')

@section('title')
<title>@lang('messages.titles')</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>@lang('messages.titles')</div>
                        @can('titles_create')
                            <div><a class="btn btn-info"
                                    href="{{route('titles.create')}}">@lang('messages.add_title')</a></div>
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
                                    <th>@lang('messages.title')</th>
                                    <th class="text-center">@lang('messages.status')</th>
                                    <th class="text-center">@lang('messages.actions')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($titles as $title)
                                    <tr>
                                        <td>{{$title->name}}</td>
                                        <td class="text-center">
                                        <span
                                            class="badge badge-pill {{$title->active == 1 ? 'badge-success' : 'badge-danger' }}">
                                            {{$title->active == 1 ? __('messages.active') : __('messages.inactive') }}
                                        </span>

                                        </td>
                                        <td class="text-center" nowrap>
                                            @can('titles_edit')
                                                <a class="text-info btn btn-sm" href="{{route('titles.edit',$title)}}">
                                                    <svg style="width: 15px;height: 15px">
                                                        <use
                                                            xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-pencil')}}"></use>
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('titles_delete')
                                                <form class="d-inline" action="{{route('titles.destroy',$title)}}"
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
                            <div class="card-footer">
                                {{$titles->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
