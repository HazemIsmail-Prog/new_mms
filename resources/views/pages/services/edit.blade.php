@extends('layouts.app')

@section('title')
<title>@lang('messages.edit_service')</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form action="{{route('services.update',$service)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="card">
                        <div class="card-header">@lang('messages.edit_service')</div>
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
                                <input autofocus type="text" name="name_ar" value="{{old('name_ar',$service->name_ar)}}"
                                       class="form-control @error('name_ar') is-invalid @enderror">
                                @error('name_ar')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="name_en">@lang('messages.name_en')</label>
                                <input type="text" name="name_en" value="{{old('name_en',$service->name_en)}}"
                                       class="form-control @error('name_en') is-invalid @enderror">
                                @error('name_en')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="min_price">@lang('messages.min_price')</label>
                                <input type="number" min="0" step="0.001" name="min_price"
                                    value="{{ old('min_price',$service->min_price) }}"
                                    class="form-control @error('min_price') is-invalid @enderror">
                                @error('min_price')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="max_price">@lang('messages.max_price')</label>
                                <input type="number" min="0" step="0.001" name="max_price"
                                    value="{{ old('max_price',$service->max_price) }}"
                                    class="form-control @error('max_price') is-invalid @enderror">
                                @error('max_price')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="department_id">@lang('messages.department')</label>
                                <select name="department_id" id="department_id"
                                    class="form-control @error('department_id') is-invalid @enderror">
                                    <option value="">---</option>
                                    @foreach ($departments as $department)
                                        <option {{ old('department_id',$service->department_id) == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="active">@lang('messages.status')</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="active"
                                           {{old('active') || $service->active == 1 ? 'checked' : ''}} id="active">
                                    <label class="form-check-label" for="active">
                                        @lang('messages.active')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-facebook" type="submit">@lang('messages.update')</button>
                            <a href="{{route('services.index')}}" class="btn text-danger"
                               type="button">@lang('messages.back')</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
