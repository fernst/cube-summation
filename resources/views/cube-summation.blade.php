@extends('layouts.master')

@section('content')

    <h1>Cube Summation</h1>
    {!! Form::open([
        'route' => 'cube-summation.process'
    ]) !!}

    <div class="form-group">
        {!! Form::label('instructions', 'Instructions:', ['class' => 'control-label']) !!}
        {!! Form::textarea('instructions', isset($instructions) ? $instructions : '', ['class' => 'form-control']) !!}
    </div>

    {!! Form::submit('Process instructions list', ['class' => 'btn btn-primary', 'name' => 'submit-btn']) !!}

    {!! Form::close() !!}

    <h3>Output</h3>
    <p>
        {{{ $output or 'Please paste instructions list and click on Process Instructions List' }}}
    </p>

@stop
