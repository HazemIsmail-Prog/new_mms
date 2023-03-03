@extends('layouts.app')

@section('title')
<title>@lang('messages.areas')</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>@lang('messages.areas')</div>
                        @can('areas_create')
                            <div><a class="btn btn-info" href="{{route('areas.create')}}">@lang('messages.add_area')</a>
                            </div>
                        @endcan
                    </div>

                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" area="alert">
                                {{ Session::get('success') }}
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                            </div>
                        @endif

                        <div class="table-responsive">

                            <table class="table table-hover table-outline mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th>@lang('messages.areas')</th>
                                    <th class="text-center">@lang('messages.actions')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($areas as $area)
                                    <tr>
                                        <td>{{$area->name}}</td>
                                        <td class="text-center" nowrap>
                                            @can('areas_edit')
                                                <a class="text-info btn btn-sm" href="{{route('areas.edit',$area)}}">
                                                    <svg style="width: 15px;height: 15px">
                                                        <use
                                                            xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-pencil')}}"></use>
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('areas_delete')
                                                <form class="d-inline" action="{{route('areas.destroy',$area)}}"
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
                                        <td class="text-center" colspan="2">No results</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            {{$areas->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
