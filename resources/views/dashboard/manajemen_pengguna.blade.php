<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Pengguna - Dashboard Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f6fa;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #2f3640;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .logout {
            float: right;
            color: white;
            text-decoration: none;
        }

        .container {
            padding: 20px;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        h1 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #40739e;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-buttons a {
            text-decoration: none;
            padding: 6px 12px;
            margin-right: 5px;
            border-radius: 5px;
            color: white;
            font-size: 14px;
        }

        .edit-btn {
            background-color: #f39c12;
        }

        .delete-btn {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="navbar">
        Dashboard Admin - Manajemen Pengguna
        <a href="{{ route('logout') }}" class="logout">Logout</a>
    </div>

    <div class="container">
        <h1>Manajemen Pengguna</h1>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td class="action-buttons">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="edit-btn">Edit</a>
                            <a href="{{ route('admin.users.destroy', $user->id) }}" 
                               class="delete-btn"
                               onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
