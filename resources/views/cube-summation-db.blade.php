@extends('layouts.master')

@section('content')

    <h1>Cube Summation using the Database</h1>
    <h3>
        {!!
            isset($size) ?
            "The current matrix size is $size X $size X $size" :
            "Create the matrix before proceeding"
         !!}
    </h3>

    <div class="divider"></div>

    {!! Form::open([
        'route' => 'cube-summation-db.create'
    ]) !!}
    <h4>Create a new Matrix</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('size', 'Size (size from 1 to 21)', ['class' => 'control-label']) !!}
                {!! Form::number('size', isset($size) ? $size : '', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-2">
            {!! Form::submit('Create new Matrix', ['class' => 'btn btn-primary', 'name' => 'submit-btn']) !!}
        </div>
        <div class="col-md-6">
            <p class="text-danger">NOTE: This deletes the old matrix</p>
            <p class="text-warning">Due to heroku constraints, the maximum size can be 21 X 21
                X21</p>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="divider"></div>

    {!! Form::open(['route' => 'cube-summation-db.update']) !!}
    <h4>Update a Matrix cell</h4>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('x', 'X position', ['class' => 'control-label']) !!}
                {!! Form::number('x', 1, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('y', 'Y position', ['class' => 'control-label']) !!}
                {!! Form::number('y', 1, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('z', 'Z position', ['class' => 'control-label']) !!}
                {!! Form::number('z', 1, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('value', 'Value', ['class' => 'control-label']) !!}
                {!! Form::number('value', 1, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::submit('Update value', ['class' => 'btn btn-primary', 'name' => 'submit-btn']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="divider"></div>

    {!! Form::open(['route' => 'cube-summation-db.query']) !!}
    <h4>Query the matrix</h4>
    <div class="row">
        <div class="col-md-1">
            <div class="form-group">
                {!! Form::label('x1', 'X1', ['class' => 'control-label']) !!}
                {!! Form::number('x1', 1, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                {!! Form::label('y1', 'Y1', ['class' => 'control-label']) !!}
                {!! Form::number('y1', 1, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                {!! Form::label('z1', 'Z1', ['class' => 'control-label']) !!}
                {!! Form::number('z1', 1, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                {!! Form::label('x2', 'X2', ['class' => 'control-label']) !!}
                {!! Form::number('x2', 1, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                {!! Form::label('y2', 'Y2', ['class' => 'control-label']) !!}
                {!! Form::number('y2', 1, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                {!! Form::label('z2', 'Z2', ['class' => 'control-label']) !!}
                {!! Form::number('z2', 1, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::submit('Query', ['class' => 'btn btn-primary', 'name' => 'submit-btn']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}


@stop
