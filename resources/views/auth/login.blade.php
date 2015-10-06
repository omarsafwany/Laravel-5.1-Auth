{!! Form::open(array('route' => 'login')) !!}
    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        Password
        <input type="password" name="password" id="password">
    </div>

    <div>
        <input type="checkbox" name="remember"> Remember Me
    </div>
    {!! Form::submit('Submit') !!}
{!! Form::close() !!}