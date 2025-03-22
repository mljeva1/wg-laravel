<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">World of Tanks</a>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center">Dobrodošli, {{ $nickname }}</h1>
    <p class="text-center">Vaš ID računa: {{ $account_id }}</p>

    <h2 class="mt-5 text-center">Top 20 Igrača (Prosječni XP)</h2>
    
    @if (!empty($players))
        <table class="table table-dark table-striped mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nadimak</th>
                    <th>Prosječni XP</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($players as $index => $player)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $player['nickname'] ?? 'Nepoznato' }}</td>
                        <td>{{ number_format($player['value'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center">Nema rezultata za prikaz.</p>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>