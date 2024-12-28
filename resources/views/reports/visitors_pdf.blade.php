<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitors Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .arabic-text {
            font-family: 'Amiri', 'Arial', sans-serif; /* Using Amiri with Arial fallback */
            direction: rtl;
            text-align: right;
        }
    </style>
</head>
<body>
<h2>Visitors Report</h2>
<table>
    <thead>
    <tr>
        <th>ID Number</th>
        <th>Name</th>
        <th>Address (Arabic)</th>
        <th>Check-in Time</th>
        <th>Check-out Time</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($visitors as $visitor)
        <tr>
            <td>{{ $visitor->id_number }}</td>
            <td class="arabic-text">{{ $visitor->arabic_full_name }}</td>
            <td class="arabic-text">{{ $visitor->address_arabic }}</td>
            <td>{{ $visitor->checkin_time }}</td>
            <td>{{ $visitor->checkout_time ?? 'Still Checked-in' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
