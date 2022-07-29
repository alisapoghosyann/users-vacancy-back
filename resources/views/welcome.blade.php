<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin</title>
        <style>
            .antialiased{
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            form{
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: 15px;
                align-items: center;
            }
            input{
                height: 35px;
                border-radius: 5px;
            }
        </style>
    </head>
    <body class="antialiased">
      <form action="/coinValue" method="post">
          @csrf
          <h3>Set coins limit</h3>
          <input name="coins_limit" type="number">
          <button>Send</button>
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
      </form>
    </body>
</html>
