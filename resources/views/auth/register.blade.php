@extends('layouts.main')
@section('content')
{!! Form::open(array('route' => 'register')) !!}
    <div class="row">
        <div class="large-6 small-centered columns">
            Name
            <input type="text" name="name" value="{{ old('name') }}">
            @if($errors->has('name'))
                <p>{{$errors->first('name')}}</p>
            @endif
        </div>

        <div class="large-6 small-centered columns">
            Email
            <input type="email" name="email" value="{{ old('email') }}">
            @if($errors->has('email'))
                <p>{{$errors->first('email')}}</p>
            @endif
        </div>

        <div class="large-6 small-centered columns">
            Password
            <input type="password" name="password">
            @if($errors->has('password'))
                <p>{{$errors->first('password')}}</p>
            @endif
        </div>

        <div class="large-6 small-centered columns">
            Confirm Password
            <input type="password" name="password_confirmation">
            @if($errors->has('password_confirmation'))
                <p>{{$errors->first('password_confirmation')}}</p>
            @endif
        </div>
        <div class="">
        {!! Form::submit('Submit', array('class' => 'button right')) !!}
        </div>
    </div>
{!! Form::close() !!}
@stop