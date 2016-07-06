<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cube Summation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
</head>
<style>
    .divider {
        height: 5px;
        width:100%;
        display:block; /* for use on default inline elements like span */
        margin: 18px 0;
        overflow: hidden;
        background-color: #e5e5e5;
    }
</style>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Cube Summation</a>
        </div>
        <div class="nav navbar-nav navbar-right">
            <li><a href="/">Text Input Implementation</a></li>
            <li><a href="/db">Database Implementation</a></li>
        </div>
    </div>
</nav>

<main>
    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ Session::remove('flash_message') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="container">
        @yield('content')
    </div>
</main>

</body>
</html>
