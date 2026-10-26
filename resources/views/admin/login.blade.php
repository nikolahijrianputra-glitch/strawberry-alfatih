<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>Masuk Admin — Strawberry Alfatih</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="login-bg">
<form class="login" method="POST" action="{{ route('admin.login.submit') }}">
  @csrf
  <img src="{{ asset('assets/img/brand/logo-circle.jpg') }}" alt="Logo Strawberry Alfatih" width="84" height="84">
  <h1>Masuk Admin</h1>
  @if(session('status'))<div class="flash ok">{{ session('status') }}</div>@endif
  @if($errors->any())<div class="flash err" role="alert">{{ $errors->first() }}</div>@endif
  <label>Email<input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"></label>
  <label>Password<input type="password" name="password" required autocomplete="current-password"></label>
  <label class="check"><input type="checkbox" name="remember" value="1"> Ingat saya</label>
  <button class="btn" type="submit">Masuk</button>
</form>
</body>
</html>
