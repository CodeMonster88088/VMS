<!-- Check-ins -->
<h2 class="text-lg font-bold mb-4">Check-ins</h2>
<table class="min-w-full bg-white shadow-md rounded">
    <thead>
    <tr>
        <th>ID Number</th>
        <th>Name</th>
        <th>Check-in Time</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($checkins as $checkin)
        <tr>
            <td>{{ $checkin->id_number }}</td>
            <td>{{ $checkin->arabic_full_name }}</td>
            <td>{{ $checkin->checkin_time }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Checkouts -->
<h2 class="text-lg font-bold mb-4">Checkouts</h2>
<table class="min-w-full bg-white shadow-md rounded">
    <thead>
    <tr>
        <th>ID Number</th>
        <th>Name</th>
        <th>Check-out Time</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($checkouts as $checkout)
        <tr>
            <td>{{ $checkout->id_number }}</td>
            <td>{{ $checkout->arabic_full_name }}</td>
            <td>{{ $checkout->checkout_time }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
