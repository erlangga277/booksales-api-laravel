<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penulis - Book Sales</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0;
            font-size: 24px;
            color: #0f172a;
        }

        .nav-link {
            text-decoration: none;
            color: #2563eb;
            font-weight: 600;
            padding: 8px 14px;
            border: 1px solid #2563eb;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background-color: #2563eb;
            color: #ffffff;
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
            vertical-align: middle;
        }

        th {
            background-color: #059669;
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
            background-color: #d1fae5;
            color: #047857;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
        }

        .author-img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Daftar Penulis (Author)</h1>
            <a href="{{ url('/books') }}" class="nav-link">Lihat Daftar Buku &rarr;</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th style="width: 100px;">Photo</th>
                    <th style="width: 250px;">Name</th>
                    <th>Bio</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($authors as $author)
                    <tr>
                        <td><span class="badge">{{ $author->id }}</span></td>
                        <td>
                            <img src="{{ $author->photo }}" alt="{{ $author->name }}" class="author-img">
                        </td>
                        <td><strong>{{ $author->name }}</strong></td>
                        <td>{{ $author->bio }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada data author.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>