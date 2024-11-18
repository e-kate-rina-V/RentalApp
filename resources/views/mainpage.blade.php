<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MainPage</title>
</head>

<body>
    <ul>
        @guest()
        <li> <a href="{{route('login')}}">Логін</a></li>
        <li> <a href="{{route('register')}}">Реєстрація</a></li>
        @endguest

        @auth()
        <li>
            <a href="{{route('logout')}}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
        @endauth
    </ul>
</body>

</html>