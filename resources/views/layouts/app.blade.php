<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'PADER NGOPI ADVENTURE')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
      <style>
        body {
            margin: 0;
            padding-top: 60px;
            background-image: url('../images/ngopi.jpeg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: rgb(13, 14, 13)
        }
        h3 {
            color: white
        }
        
        h2 {
            color: white
            }
        
        label {
            color: white
        }
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
        width: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }

        .container {
            position: relative;
            z-index: 1;
        }
        .container table {
            color: white
            
        
        }
        
        
        h1 {
           color: white
        }
        li {
           color: white
        }
        p  {
           color: rgb(17, 16, 16)
        }

        .navbar-brand {
            font-weight: bold;
        }
    </style>
<body>
    <!-- Navbar -->
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" >PaderNgopiAdventure</a>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    {{-- <div class="d-flex align-items-center gap-2">
    <a href="{{ route('barang.user') }}" class="btn btn-primary">
        <i class="bi bi-box-seam"></i> Lihat Produk
    </a>
</div> --}}

{{--  
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-flex" role="form">
                        @csrf
                        <button type="submit" class="btn btn-outline-light">Logout</button>
                    </form>
                </li>
            </ul>
        </div> --}}
    </div>
</nav>

    <!-- Main Content -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Footer -->
   

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>