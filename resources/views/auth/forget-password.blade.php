@extends('layouts.main')
@section('content')
{!! Form::open(array('route' => 'forget-password')) !!}
    <div class="row">
        <div class="large-8 small-centered column">
            <div class="row">
                Email
                <input type="email" name="email" value="{{ old('email') }}">
            </div>
            <div class="">
            {!! Form::submit('Submit', array('class' => 'button right')) !!}
            </div>
        </div>
    </div>
{!! Form::close() !!}
@stop