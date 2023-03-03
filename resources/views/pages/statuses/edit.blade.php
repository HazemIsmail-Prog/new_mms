@extends('layouts.app')

@section('title')
<title>@lang('messages.edit_status')</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form action="{{route('statuses.update',$status)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="card">
                        <div class="card-header">@lang('messages.edit_status')</div>
                        <div class="card-body">
                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ Session::get('success') }}
                                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">×</span></button>
                                </div>
                            @endif


                            <div class="form-group">
                                <label for="name_ar">{{__('messages.name_ar')}}</label>
                                <input type="text" id="name_ar" name="name_ar"
                                       value="{{old('name_ar',$status->name_ar)}}"
                                       class="form-control @error('name_ar') is-invalid @enderror">
                                @error('name_ar')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="name_en">{{__('messages.name_en')}}</label>
                                <input type="text" id="name_en" name="name_en"
                                       value="{{old('name_en',$status->name_en)}}"
                                       class="form-control @error('name_en') is-invalid @enderror">
                                @error('name_en')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="color">{{__('messages.color')}}</label>
                                <input type="color" id="color" name="color"
                                       value="{{old('color',$status->color)}}"
                                       class="form-control @error('color') is-invalid @enderror">
                                @error('color')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>

                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-facebook" type="submit">@lang('messages.update')</button>
                            <a href="{{route('statuses.index')}}" class="btn text-danger"
                               type="button">{{__('messages.back')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
