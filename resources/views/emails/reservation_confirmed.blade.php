<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бронирование подтверждено</title>
</head>
<body>
    <h1>Ваше бронирование подтверждено!</h1>
    <p>Здравствуйте, {{ $reservation->user->name }}.</p>
    <p>Ваше бронирование для объявления "{{ $reservation->ad->title }}" успешно подтверждено.</p>
    <p>Даты пребывания: с {{ $reservation->arrival_date }} по {{ $reservation->depart_date }}</p>
    <p>Количество ночей: {{ $reservation->nights_num }}</p>
    <p>Общая стоимость: {{ $reservation->total_cost }}₴</p>
</body>
</html>
