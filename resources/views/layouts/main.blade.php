<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    {{-- <script src="vendor/mark.js/dist/mark.min.js"></script> --}}
    <title>Document</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .material-symbols-outlined {
          font-variation-settings:
          'FILL' 0,
          'wght' 400,
          'GRAD' 0,
          'opsz' 48
        }
        </style>
</head>
<body>

            <header class="bg-white w-100">
                <div class="container">
                    <div class="row">
                        <nav class="navbar navbar-expand-md navbar-light absolute-top">
                            <a class="navbar-brand mx-auto order-1 order-md-3" href="">TestWork</a>


                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupporte" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse order-4 order-md-4"  id="navbarSupporte">

                            <ul class="dropdown navbar-nav ms-auto">
                                <li class="nav-item" >
                                    <a class="nav-link" href="{{route('todo.index')}}">Мои списки</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('todo.create')}}">Создать список</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('account')}}">Профиль</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('users.index')}}">Другие пользователи</a>
                                </li>
                            </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </header>

      <main class="main">
        <div class="container">
            @yield('content')
        </div>
      </main>


    {{-- Bootstrap --}}
    {{-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
