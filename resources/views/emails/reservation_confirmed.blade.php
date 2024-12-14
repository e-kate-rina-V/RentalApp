<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Ваше бронювання підтверджено!</h1>
    <p>Добрий день, {{ $reservation->user->name }}.</p>
    <p>Ваше бронювання для оголошення "{{ $reservation->ad->title }}" успішно підтверджено.</p>
    <p>Дати перебування з {{ $reservation->arrival_date }} по {{ $reservation->depart_date }}</p>
    <p>Кількість ночей: {{ $reservation->nights_num }}</p>
    <p>Загальна вартість: {{ $reservation->total_cost }}₴</p>
</body>
</html>
