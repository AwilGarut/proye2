<!DOCTYPE html>
<html>
<head>
    <title>Register - Pader Ngopi Adventure</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins :wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: url('../images/ngopi.jpeg');no-repeat center center fixed; /* Ganti dengan path gambar kamu */
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Hitam transparan */
            z-index: -1;
        }

        .register-box {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #343434;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #555555;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .register-box {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Daftar Akun</h2>
        @if($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif
        <form method="POST" action="/register">
            @csrf
            <input type="text" name="name" placeholder="Nama" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
            <button type="submit">Daftar</button>
        </form>
        <a class="login-link" href="{{ route('login') }}">Sudah punya akun? Login</a>
    </div>
</body>
</html>