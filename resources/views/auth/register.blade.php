<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Pader Ngopi Adventure</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .form-box {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-box h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #5c4c45;
        }
        .form-box input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-box button {
            width: 100%;
            padding: 12px;
            background-color: #5c4c45;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
        .form-box button:hover {
            background-color: #4a3c37;
        }
        .form-box .link {
            text-align: center;
            margin-top: 15px;
        }
        .form-box .link a {
            color: #5c4c45;
            text-decoration: none;
            font-weight: bold;
        }
        ul {
            padding-left: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-box">
            <h2>Daftar Akun</h2>

            @if($errors->any())
                <ul style="color: red; margin-bottom: 15px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="text" name="name" placeholder="Nama" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
                <button type="submit">Daftar</button>
            </form>

            <div class="link">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </div>

</body>
</html>
