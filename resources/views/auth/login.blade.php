@extends('layouts.main')
@section('content')
{!! Form::open(array('route' => 'login')) !!}
    <div class="row">
        <div class="large-8 small-centered column">
            <div class="row">
                Email
                <input type="email" name="email" value="{{ old('email') }}">
            </div>
            <div class="row">
                Password
                <input type="password" name="password" id="password">
            </div>

            <div class="row">
                <input type="checkbox" name="remember"> Remember Me
            </div>
            <div class="">
            {!! Form::submit('Submit', array('class' => 'button right')) !!}
            </div>
        </div>
    </div>
{!! Form::close() !!}
@stop