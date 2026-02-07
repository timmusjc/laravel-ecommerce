<!DOCTYPE html>
<html lang="pl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Faktura nr {{ $order->id }}/{{ date('Y') }}</title>
    <link rel="stylesheet" href="{{ public_path('build/assets/app.css') }}">
</head>

<body class="pdf-order">

    <table class="no-border">
        <tr>
            <td width="50%">
                <div class="pdf-logo">
                    TEppLE
                </div>
            </td>
            <td width="50%" align="right">
                <div class="invoice-title">Faktura nr: FV/{{ $order->id }}/{{ $order->created_at->format('Y') }}</div>
                <div class="pdf-original-label">Oryginał</div>
                <br>
                Miejscowość: <strong>Warszawa</strong><br>
                Data wystawienia: {{ $order->created_at->format('d.m.Y') }}<br>
                Termin zapłaty: {{ $order->created_at->format('d.m.Y') }}
            </td>
        </tr>
    </table>

    <table class="no-border u-margin-top-20">
        <tr>
            <td width="50%" class="u-padding-right-20">
                <div class="section-title">Sprzedawca</div>
                <strong>TEppLE Sp. z o.o.</strong><br>
                ul. Elektroniczna 15<br>
                00-001 Warszawa<br>
                NIP: 123-456-78-90<br>
                BDO: 000012345
            </td>
            <td width="50%" class="u-padding-left-20">
                <div class="section-title">Nabywca</div>
                <strong>{{ $order->user->name }}</strong><br>
                {{ $order->address }}<br>
                {{ $order->phone }}<br>
                {{ $order->user->email }}<br>
                @if (isset($order->user->nip))
                    NIP: {{ $order->user->nip }}
                @endif
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th width="5%">Lp.</th>
                <th width="35%">Nazwa towaru lub usługi</th>
                <th width="8%">Ilość</th>
                <th width="7%">J.m.</th>
                <th width="12%">Cena netto</th>
                <th width="12%">Wartość netto</th>
                <th width="8%">VAT</th>
                <th width="13%">Wartość brutto</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalNetto = 0;
                $totalVat = 0;
                $counter = 1;
            @endphp

            @foreach ($order->items as $item)
                @php
                    // Расчеты (Предполагаем, что цена в базе - BRUTTO)
                    $priceBrutto = $item->price;
                    $vatRate = 0.23; // 23% VAT

                    // Математика: Netto = Brutto / 1.23
                    $priceNetto = $priceBrutto / (1 + $vatRate);
                    $valueNetto = $priceNetto * $item->quantity;
                    $valueBrutto = $priceBrutto * $item->quantity;
                    $valueVat = $valueBrutto - $valueNetto;

                    // Суммируем общие итоги
                    $totalNetto += $valueNetto;
                    $totalVat += $valueVat;
                @endphp
                <tr>
                    <td class="pdf-text-center">{{ $counter++ }}</td>
                    <td class="text-left">{{ $item->product->name ?? 'Produkt' }}</td>
                    <td class="pdf-text-center">{{ $item->quantity }}</td>
                    <td class="pdf-text-center">szt.</td>
                    <td>{{ number_format($priceNetto, 2, ',', ' ') }}</td>
                    <td>{{ number_format($valueNetto, 2, ',', ' ') }}</td>
                    <td class="pdf-text-center">23%</td>
                    <td class="pdf-bold">{{ number_format($valueBrutto, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="no-border">
        <tr>
            <td width="60%"></td>
            <td width="40%">
                <table class="items-table">
                    <tr>
                        <th class="pdf-header-cell"></th>
                        <th>Wartość netto</th>
                        <th>VAT</th>
                        <th>Wartość brutto</th>
                    </tr>
                    <tr class="pdf-summary-row">
                        <td class="pdf-summary-cell">RAZEM:</td>
                        <td>{{ number_format($totalNetto, 2, ',', ' ') }}</td>
                        <td>{{ number_format($totalVat, 2, ',', ' ') }}</td>
                        <td>{{ number_format($order->total_price, 2, ',', ' ') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="u-margin-top-20">
        <div class="big-total">
            Razem do zapłaty: {{ number_format($order->total_price, 2, ',', ' ') }} PLN
        </div>

        <div class="u-margin-top-10">
            Sposób zapłaty: <strong>
                @if ($order->payment_method == 'blik')
                    BLIK
                @elseif($order->payment_method == 'card')
                    Karta płatnicza
                @else
                    Przelew
                @endif
            </strong>
        </div>

        @if ($order->payment_method == 'transfer')
            <div>Numer rachunku: <strong>49 1020 2892 0000 0002 1234 5678</strong> (PKO BP)</div>
        @endif
    </div>

    <table class="no-border signatures">
        <tr>
            <td width="50%" align="center">
                <div class="u-height-30">
                </div>
                <div class="signature-line">
                    Wystawił(a)
                </div>
            </td>
            <td width="50%" align="center">
                <div class="u-height-30"></div>
                <div class="signature-line">
                    Odebrał(a)
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
