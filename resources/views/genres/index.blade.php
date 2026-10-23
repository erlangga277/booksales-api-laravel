<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Genre - Book Sales</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px;
            background-color: #f8fafc;
            color: #1e293b;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #0f172a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background-color: #3b82f6;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        tr:hover {
            background-color: #f1f5f9;
        }

        .badge {
            background-color: #e0f2fe;
            color: #0284c7;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <h1>Daftar Genre Buku</h1>
    <table>
        <thead>
            <tr>
                <th style="width: 80px;">ID</th>
                <th style="width: 250px;">Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($genres as $genre)
                <tr>
                    <td><span class="badge">{{ $genre['id'] }}</span></td>
                    <td><strong>{{ $genre['name'] }}</strong></td>
                    <td>{{ $genre['description'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">Tidak ada data genre.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
