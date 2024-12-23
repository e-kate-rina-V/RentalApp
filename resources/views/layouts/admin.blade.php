<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Адміністративна панель</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body id="admin-panel-body">
    <div id="app" class="d-flex">
        <nav class="bg-dark text-white p-3" style="min-width: 200px;">
            <h2 class="text-center">Admin Panel</h2>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('ads.index') }}" class="nav-link text-white">Оголошення</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('reservations.index') }}" class="nav-link text-white">Бронювання</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link text-white">Користувачі</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button id="admin-exit-btn" type="submit" class="btn btn-link text-white">Вийти</button>
                    </form>
                </li>
            </ul>
        </nav>

        <main class="p-4 w-100">
            <div class="container">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
