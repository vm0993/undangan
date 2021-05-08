<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }} - Voucher</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta id="token" name="token" value="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style-invoice.css') }}" media="all" />
</head>
    <body>
        <header class="clearfix">
            <div id="logo">
                @if($setting->image)
                <img src="{{ asset('images/'.$setting->image) }}" style="width:90%; max-width:120px;">
                @else
                <img src="" style="width:100%; max-width:260px;">
                @endif
            </div>
            <div id="company">
                <h2 class="name">{{ $setting->name }}</h2>
                <div>{!! $setting->address !!}</div>
                <div> {{ $setting->city }}, {{ $setting->profience }} {{ $setting->postal_code }}</div>
                <div><a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a></div>
            </div>
        </header>
        <main>
            <div id="details" class="clearfix">
                <div id="client">
                    <div class="to">JOURNAL VOUCHER</div>
                    <h2 class="name" style="width: auto;">{!! $jurnal->jurnal_no !!}</h2>
                    <div class="date">Date : {{ \Carbon\Carbon::parse($jurnal->jurnal_date)->format('d.m.Y') }}</div>
                    <div class="address">Description : {!! $jurnal->jurnal_description !!}</div>
                </div>
            </div>
            <table border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th class="no" id="no">#</th>
                        <th class="desc" id="desc">DESCRIPTION</th>
                        <th class="unit" id="unit">DEBET</th>
                        <th class="qty" id="qty">CREDIT</th>
                        <th class="total" id="total">MEMO</th>
                    </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                    @foreach ($jurnal->jurnalDetail as $index => $jurnalDetail)
                    <tr>
                        <td class="no">{{ $i }}</td>
                        <td class="desc">{{ $jurnalDetail->account->account_name }}</td>
                        <td class="unit">{{ number_format($jurnalDetail->debet) }}</td>
                        <td class="qty">{{ number_format($jurnalDetail->credit) }}</td>
                        <td class="desc">{{ $jurnalDetail->memo }}</td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">TOTAL</td>
                        <td><strong>{{ number_format($jurnal->jurnalDetail->sum('debet'),0) }}</strong></td>
                        <td><strong>{{ number_format($jurnal->jurnalDetail->sum('credit'),0) }}</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </main>
    </body>
</html>