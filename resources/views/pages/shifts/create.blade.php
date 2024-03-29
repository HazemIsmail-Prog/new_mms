@extends('layouts.app')

@section('title')
<title>@lang('messages.add_shift')</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form action="{{route('shifts.store')}}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">@lang('messages.add_shift')</div>
                        <div class="card-body">
                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ Session::get('success') }}
                                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">×</span></button>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="name_ar">@lang('messages.name_ar')</label>
                                <input autofocus type="text" name="name_ar" value="{{old('name_ar')}}" id="name_ar"
                                       class="form-control @error('name_ar') is-invalid @enderror">
                                @error('name_ar')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="name_en">@lang('messages.name_en')</label>
                                <input autofocus type="text" name="name_en" value="{{old('name_en')}}" id="name_en"
                                       class="form-control @error('name_en') is-invalid @enderror">
                                @error('name_en')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="start_time">@lang('messages.start_time')</label>
                                <input autofocus type="time" name="start_time" value="{{old('start_time')}}" id="start_time"
                                       class="form-control @error('start_time') is-invalid @enderror">
                                @error('start_time')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="end_time">@lang('messages.end_time')</label>
                                <input autofocus type="time" name="end_time" value="{{old('end_time')}}" id="end_time"
                                       class="form-control @error('end_time') is-invalid @enderror">
                                @error('end_time')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-facebook" type="submit">@lang('messages.save')</button>
                            <a href="{{route('shifts.index')}}" class="btn text-danger"
                               type="button">@lang('messages.back')</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
