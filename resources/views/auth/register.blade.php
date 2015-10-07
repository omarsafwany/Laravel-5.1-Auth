@extends('layouts.main')
@section('content')
{!! Form::open(array('route' => 'register')) !!}
    <div class="row">
        <div class="large-6 small-centered columns">
            Name
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div class="large-6 small-centered columns">
            Email
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="large-6 small-centered columns">
            Password
            <input type="password" name="password">
        </div>

        <div class="large-6 small-centered columns">
            Confirm Password
            <input type="password" name="password_confirmation">
        </div>
        <div class="">
        {!! Form::submit('Submit', array('class' => 'button right')) !!}
        </div>
    </div>
{!! Form::close() !!}
@stop