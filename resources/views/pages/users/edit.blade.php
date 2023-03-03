@extends('layouts.app')

@section('title')
<title>@lang('messages.edit_user')</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form action="{{route('users.update',$user)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">@lang('messages.edit_user')</div>
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
                                <input autocomplete="off" type="text" name="name_ar"
                                       value="{{old('name_ar',$user->name_ar)}}"
                                       class="form-control @error('name_ar') is-invalid @enderror">
                                @error('name_ar')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="name_en">@lang('messages.name_en')</label>
                                <input autocomplete="off" type="text" name="name_en"
                                       value="{{old('name_en',$user->name_en)}}"
                                       class="form-control @error('name_en') is-invalid @enderror">
                                @error('name_en')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="username">@lang('messages.username')</label>
                                <input autocomplete="off" type="text" name="username"
                                       value="{{old('username',$user->username)}}"
                                       class="form-control @error('username') is-invalid @enderror">
                                @error('username')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="email">@lang('messages.email')</label>
                                <input autocomplete="off" type="email" name="email"
                                       value="{{old('email',$user->email)}}"
                                       class="form-control @error('email') is-invalid @enderror">
                                @error('email')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="password">@lang('messages.password')</label>
                                <input autocomplete="off" type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror">
                                @error('password')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="title_id">@lang('messages.title')</label>
                                <select name="title_id"
                                        class="form-control @error('title_id') is-invalid @enderror">
                                    <option value="">---</option>
                                    @foreach($titles as $title)
                                        <option
                                            value="{{$title->id}}" {{old('title_id',$user->title_id) == $title->id ? 'selected' : ''}}>{{$title->name}}</option>
                                    @endforeach
                                </select>
                                @error('title_id')<span class="small text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="card">
                                <div class="card-header">{{__('messages.roles')}}</div>
                                <div class="card-body">
                                    @error('roles')<span class="small text-danger">{{ $message }}</span>@enderror
                                    @foreach($roles as $role)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$role->id}}"
                                                   {{$user->roles->pluck('id')->contains($role->id) ? 'checked' : ''}}
                                                   name="roles[]"
                                                   id="{{$role->id}}">
                                            <label class="form-check-label" for="{{$role->id}}">
                                                {{$role->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>






                            <div class="card">
                                <div class="card-header">{{__('messages.departments')}}</div>
                                <div class="card-body">
                                    @error('departments')<span class="small text-danger">{{ $message }}</span>@enderror
                                    @foreach($departments as $department)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$department->id}}"
                                                   {{$user->departments->pluck('id')->contains($department->id) ? 'checked' : ''}}
                                                   name="departments[]"
                                                   id="{{$department->id}}">
                                            <label class="form-check-label" for="{{$department->id}}">
                                                {{$department->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('messages.status')</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="active" {{old('active',$user->active) ? 'checked' : ''}}>
                                    <label class="form-check-label" for="active">
                                        @lang('messages.active')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-facebook" type="submit">@lang('messages.save')</button>
                            <a href="{{route('users.index')}}" class="btn text-danger"
                               type="button">@lang('messages.back')</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
