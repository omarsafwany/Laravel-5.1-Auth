@extends('layouts.main')
@section('content')
{!! Form::open(array('route' => 'change-password')) !!}
    <div class="row">
        <div class="large-8 small-centered column">
            <div class="large-6 small-centered columns">
                Old Password
                <input type="password" name="old_password">
            </div>
            
            <div class="large-6 small-centered columns">
                New Password
                <input type="password" name="new_password">
            </div>

            <div class="large-6 small-centered columns">
                Confirm Password
                <input type="password" name="password_confirmation">
            </div>
            <div class="">
            {!! Form::submit('Submit', array('class' => 'button right')) !!}
            </div>
        </div>
    </div>
{!! Form::close() !!}
@stop