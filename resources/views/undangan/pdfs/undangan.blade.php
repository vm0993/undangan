<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }} - Voucher</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta id="token" name="token" value="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style-undangan.css') }}" media="all" />
    <link rel="stylesheet" href="{{ asset('css/style-new.css') }}" media="all" />
</head>
    <body>
        <header>
            <div class="logo">
              <span class="laura">N</span>
              <span class="ampersand">&</span>
              <span class="javery">N</span>
              <date>27.05.2021</date>
            </div>
        </header>
        <header class="clearfix">
            <div class="logo">
                <span class="laura">N</span>
                <span class="ampersand">&</span>
                <span class="javery">N</span>
                <date>27.05.2021</date>
              </div>
            <div id="company">
                <img src="data:image/png;base64, {{ base64_encode( QrCode::format('png')->size(80)->generate('ABC Alkaline')) }} ">
            </div>
        </header>
        <main>
        </main>
    </body>
</html>