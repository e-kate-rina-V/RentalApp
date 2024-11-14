
<!-- @extends('layouts.main')
@section('content') 
@endsection -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <div>
            <nav>
                <ul>
                    <li><a href="{{route('user.index')}}">User</a></li>
                    <li><a href="#">Another</a></li>
                </ul>
            </nav>
        </div>
        @yield('content')
    </div>
</body>

</html>