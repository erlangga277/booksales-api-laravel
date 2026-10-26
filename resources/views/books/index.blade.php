<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Book Sales</title>
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
            color: #059669;
            font-weight: 600;
            padding: 8px 14px;
            border: 1px solid #059669;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background-color: #059669;
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
            background-color: #2563eb;
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
            background-color: #dbeafe;
            color: #1d4ed8;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
        }

        .badge-stock {
            background-color: #fef3c7;
            color: #b45309;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .book-cover {
            width: 50px;
            height: 70px;
            border-radius: 4px;
            object-fit: cover;
            border: 1px solid #cbd5e1;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .price {
            font-weight: bold;
            color: #059669;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Daftar Buku (Book)</h1>
            <a href="{{ url('/authors') }}" class="nav-link">&larr; Lihat Daftar Penulis</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th style="width: 80px;">Cover</th>
                    <th style="width: 200px;">Judul Buku</th>
                    <th style="width: 160px;">Penulis (Author)</th>
                    <th>Deskripsi</th>
                    <th style="width: 120px;">Harga</th>
                    <th style="width: 80px;">Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    <tr>
                        <td><span class="badge">{{ $book->id }}</span></td>
                        <td>
                            @if ($book->cover_photo)
                                <img src="{{ $book->cover_photo }}" alt="{{ $book->title }}" class="book-cover">
                            @else
                                <span style="color: #94a3b8; font-size: 12px;">No Cover</span>
                            @endif
                        </td>
                        <td><strong>{{ $book->title }}</strong></td>
                        <td>
                            @if ($book->author)
                                <span>{{ $book->author->name }}</span>
                            @else
                                <span style="color: #94a3b8;">-</span>
                            @endif
                        </td>
                        <td><small>{{ $book->description }}</small></td>
                        <td class="price">Rp {{ number_format($book->price, 0, ',', '.') }}</td>
                        <td><span class="badge-stock">{{ $book->stock }} pcs</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Tidak ada data buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>