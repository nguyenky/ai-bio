<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="login-body">
    <div class="container py-5">
        @include('partials.flash')

        <div class="login-card card border-0 shadow-lg mx-auto">
            <div class="card-body p-4 p-md-5">
                <p class="eyebrow">Admin access</p>
                <h1 class="display-6 mb-3">Sign in to manage your site</h1>
                <p class="text-secondary mb-4">Use the admin account defined in your environment settings or database seeder.</p>

                <form method="POST" action="{{ route('admin.login.store') }}" class="row g-3">
                    @csrf
                    <div class="col-12">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control form-control-lg" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control form-control-lg" id="password" name="password" type="password" required>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1" @checked(old('remember'))>
                            <label class="form-check-label" for="remember">Keep me signed in</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-dark btn-lg rounded-pill w-100" type="submit">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
