<!DOCTYPE html>
<html lang="pl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Faktura nr {{ $order->id }}/{{ date('Y') }}</title>
    <style>
        /* Шрифт DejaVu Sans обязателен для польских симвоłów (ą, ę, ś, ć) */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
        }

        /* Общие стили для таблиц */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        /* Таблицы без рамок (для шапки и подвала) */
        .no-border td {
            border: none;
            padding: 5px 0;
            vertical-align: top;
        }

        /* Основная таблица с товарами */
        .items-table th,
        .items-table td {
            border: 1px solid #000;
            /* Черные тонкие рамки как на фото */
            padding: 6px;
            text-align: right;
            /* Числа равняем по правому краю */
        }

        .items-table th {
            background-color: #e0e0e0;
            /* Серый фон заголовков */
            text-align: center;
            font-weight: bold;
        }

        .items-table td.text-left {
            text-align: left;
        }

        /* Заголовки разделов */
        h1 {
            font-size: 28px;
            margin: 0;
            color: #444;
            /* Цвет логотипа */
        }

        .invoice-title {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
            display: inline-block;
            width: 100%;
        }

        /* Итоговые суммы */
        .total-box {
            width: 40%;
            float: right;
        }

        .big-total {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Подписи */
        .signatures {
            margin-top: 50px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 80%;
            margin: 0 auto;
            padding-top: 5px;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <table class="no-border">
        <tr>
            <td width="50%">
                <div
                    style="background-color: #e0e0e0; color: #000000; padding: 10px; display: inline-block; font-weight: bold; font-size: 24px;">
                    TEppLE
                </div>
            </td>
            <td width="50%" align="right">
                <div class="invoice-title">Faktura nr: FV/{{ $order->id }}/{{ $order->created_at->format('Y') }}</div>
                <div style="color: rgb(0, 0, 0); font-weight: bold;">Oryginał</div>
                <br>
                Miejscowość: <strong>Warszawa</strong><br>
                Data wystawienia: {{ $order->created_at->format('d.m.Y') }}<br>
                Termin zapłaty: {{ $order->created_at->format('d.m.Y') }}
            </td>
        </tr>
    </table>

    <table class="no-border" style="margin-top: 20px;">
        <tr>
            <td width="50%" style="padding-right: 20px;">
                <div class="section-title">Sprzedawca</div>
                <strong>TEppLE Sp. z o.o.</strong><br>
                ul. Elektroniczna 15<br>
                00-001 Warszawa<br>
                NIP: 123-456-78-90<br>
                BDO: 000012345
            </td>
            <td width="50%" style="padding-left: 20px;">
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
                    <td style="text-align: center;">{{ $counter++ }}</td>
                    <td class="text-left">{{ $item->product->name ?? 'Produkt' }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: center;">szt.</td>
                    <td>{{ number_format($priceNetto, 2, ',', ' ') }}</td>
                    <td>{{ number_format($valueNetto, 2, ',', ' ') }}</td>
                    <td style="text-align: center;">23%</td>
                    <td style="font-weight: bold;">{{ number_format($valueBrutto, 2, ',', ' ') }}</td>
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
                        <th style="background-color: #fff; border: none;"></th>
                        <th>Wartość netto</th>
                        <th>VAT</th>
                        <th>Wartość brutto</th>
                    </tr>
                    <tr style="background-color: #eee; font-weight: bold;">
                        <td style="border: none; background: #fff; text-align: right; padding-right: 10px;">RAZEM:</td>
                        <td>{{ number_format($totalNetto, 2, ',', ' ') }}</td>
                        <td>{{ number_format($totalVat, 2, ',', ' ') }}</td>
                        <td>{{ number_format($order->total_price, 2, ',', ' ') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="margin-top: 20px;">
        <div class="big-total">
            Razem do zapłaty: {{ number_format($order->total_price, 2, ',', ' ') }} PLN
        </div>

        <div style="margin-top: 10px;">
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
                <div style="height: 30px;">
                </div>
                <div class="signature-line">
                    Wystawił(a)
                </div>
            </td>
            <td width="50%" align="center">
                <div style="height: 30px;"></div>
                <div class="signature-line">
                    Odebrał(a)
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
