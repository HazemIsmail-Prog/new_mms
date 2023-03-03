@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@lang('messages.artisan_commands')</div>
                    <div class="card-body">
                        @php
                            $commands = [
                                'websockets:serve',
                                'migrate',
                                'migrate:fresh',
                                'migrate:fresh --seed',
                                'db:seed --class=OrderSeeder',
                                'cache:clear',
                                'view:clear',
                                'route:clear',
                                'clear-compiled',
                                'config:cache',
                            ];
                        @endphp

                        <table class="table table-hover">
                            <tbody>
                                @foreach ($commands as $command)
                                    <tr>
                                        <td class=" text-center">
                                            <form action="{{route('artisan.run',['command'=>$command])}}" method="post">
                                                @csrf
                                                <button class="btn btn-facebook btn-lg" type="submit">{{ $command }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <form action="{{route('artisan.run')}}" method="post" class=" text-center">
                            @csrf
                            <input type="text" name="command" value="" class="form-control">
                            <button class="btn btn-facebook btn-lg" type="submit">@lang('messages.run')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
