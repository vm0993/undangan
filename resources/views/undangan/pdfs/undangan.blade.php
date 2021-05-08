<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }} - Voucher</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta id="token" name="token" value="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <link rel="stylesheet" href="{{ asset('css/style-undangan.css') }}">
    <style>@page { size: A5 landscape }</style>
</head>
    <body class="A5 landscape">
        <section class="sheet padding-10mm" style="padding-top: 25mm;">
            <div class="clearfix">
                <div class="logo">
                    <span class="laura">{{ \Illuminate\Support\Str::substr($invitation->wedding->pengantin_pria,0,1) }}</span>
                    <span class="ampersand">&</span>
                    <span class="javery">{ \Illuminate\Support\Str::substr($invitation->wedding->pengantin_wanita,0,1) }}</span>
                    <date>{{ \Carbon\Carbon::parse($invitation->wedding->wedding_date)->format('d.m.Y') }}</date>
                  </div>
                <div id="company" style="text-align: center;margin-top:40px;">
                    <img src="data:image/png;base64, {{ base64_encode( QrCode::format('png')->size(240)->generate($invitation->id)) }} ">
                </div>
            </div>
        </section>
    </body>
</html>