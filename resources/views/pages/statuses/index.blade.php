@extends('layouts.app')

@section('title')
<title>@lang('messages.statuses')</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>@lang('messages.statuses')</div>
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
                                    <th>{{__('messages.name')}}</th>
                                    <th class="text-center">{{__('messages.color')}}</th>
                                    <th class="text-center">@lang('messages.actions')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($statuses as $status)
                                    <tr>
                                        <td>{{$status->name}}</td>
                                        <td class="text-center">
                                            <span style="background: {{$status->color}} ; color: white"
                                                  class="badge badge-pill py-2 px-3">{{$status->color}}</span>
                                        </td>
                                        <td class="text-center" nowrap>
                                            @can('statuses_edit')
                                                <a class="text-info btn btn-sm"
                                                   href="{{route('statuses.edit',$status)}}">
                                                    <svg style="width: 15px;height: 15px">
                                                        <use
                                                            xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-pencil')}}"></use>
                                                    </svg>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="4">No results</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
