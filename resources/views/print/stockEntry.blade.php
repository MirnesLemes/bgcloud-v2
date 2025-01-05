<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Ulazna kalkulacija</title>
</head>
<style type="text/css">
    @font-face {
        font-family: 'CourierPrime';
        src: url('{{ storage_path('fonts/CourierPrime-Regular.ttf') }}') format('truetype');
        font-weight: normal;
    }

    @font-face {
        font-family: 'CourierPrime';
        src: url('{{ storage_path('fonts/CourierPrime-Bold.ttf') }}') format('truetype');
        font-weight: bold;
    }

    body {
        font-family: "CourierPrime";
        font-size: 10px;
    }

    .header-table {
        border: solid 0px #DDEEEE;
        border-collapse: collapse;
        border-spacing: 0;
        table-layout: fixed;
        width: 100%;
    }

    .header-table thead th {
        background-color: #f8f9f9;
        border: solid 0px #DDEEEE;
        padding: 5px;
    }

    .header-table tbody td {
        border: solid 0px #DDEEEE;
        padding: 5px;
        vertical-align: top;
    }

    .items-table {
        border: solid 0px #DDEEEE;
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
    }

    .items-table thead th {
        background-color: #f8f9f9;
        border: solid 1px #DDEEEE;
        padding: 5px;
    }

    .items-table tbody td {
        border: solid 1px #DDEEEE;
        padding: 5px;
    }
</style>

<body>
    <table class="header-table">
        <tbody>

            <tr style="vertical-align: middle;">
                <td>
                    <span>Društvo za proizvodnju, trgovinu i usluge</span><br />
                    <span><strong>Baltic Group d.o.o. Visoko</strong></span><br />
                    <span>Čajengradska bb, 71300 Visoko, Bosna i Hercegovina</span>
                </td>
                <td style="text-align: center;">
                    <span
                        style="font-size: 18px; text-align:center;"><strong>{{ $entry->StockEntryDocType->type_name }}</strong></span>
                </td>
                <td style="text-align: right; ">
                    <span>Skladište: <strong>{{ $entry->entry_warehouse }} -
                            {{ $entry->StockEntryWarehouse->warehouse_name }}</strong></span><br />
                    <span>Broj: <strong>{{ $entry->entry_index }}</strong></span><br />
                    <span>Datum: <strong>{{ formatDate($entry->entry_date) }}</strong></span>
                </td>
            </tr>
        </tbody>
    </table>
    <p><strong>A. Stavke kalkulacije:</strong></p>
    <table class="items-table">
        <thead>
            <tr>
                <th style="text-align: center;"><span>Rb</span></th>
                <th style="text-align: left;"><span>Šifra</span><br /><span>Naziv proizvoda</span></th>
                <th style="text-align: center;"><span>Jm</span><br /><span>Pak</span></th>
                <th style="text-align: right;"><span>Količina</span></th>
                <th style="text-align: right;"><span>Fakturna cijena</span><br /><span>Fakturna vrijednost</span></th>
                <th style="text-align: right;"><span>Jedinični troškovi</span><br /><span>Iznos troškova</span></th>
                <th style="text-align: right;"><span>Nabavna cijena</span><br /><span>Nabavna vrijednost</span></th>
            </tr>
        </thead>
        <tbody>
            @php($rb = 1)
            @forelse ($items as $item)
                <tr style="border: solid 1px #d0d3d4">
                    <td style="text-align: center;">
                        <span>{{ $rb }}</span>
                    </td>
                    <td style="text-align: left;">
                        <span><strong>{{ $item->EntryItemVariant->variant_code }}</strong></span><br />
                        <span>{{ $item->EntryItemVariant->variant_name }}</span>
                    </td>
                    <td style="text-align: center;">
                        <span><strong>{{ $item->EntryItemVariant->variant_packing }}</strong></span><br />
                        <span>{{ $item->EntryItemVariant->uom_quantity }}{{ $item->EntryItemVariant->variant_uom }}</span>
                    </td>
                    <td style="text-align: right;">
                        <span>{{ number_format($item->item_quantity, 2, ',', '.') }}</span>
                    </td>
                    <td style="text-align: right;">
                        <span><strong>{{ number_format($item->item_converted_price, 6, ',', '.') }}</strong></span><br />
                        <span>{{ number_format($item->item_converted_amount, 2, ',', '.') }}</span>
                    </td>
                    <td style="text-align: right;">
                        <span><strong>{{ number_format($item->item_costs, 6, ',', '.') }}</strong></span><br />
                        <span>{{ number_format($item->item_cost_amount, 2, ',', '.') }}</span>
                    </td>
                    <td style="text-align: right;">
                        <span><strong>{{ number_format($item->item_purchase_price, 6, ',', '.') }}</strong></span><br />
                        <span>{{ number_format($item->item_purchase_amount, 2, ',', '.') }}</span>
                    </td>
                </tr>
                @php($rb = $rb + 1)
            @empty
            @endforelse
            <tr style="border: solid 1px #b3b6b7">
                <td colspan="4" style="text-align: left;">
                    <span><strong>UKUPNO:</strong></span>
                </td>
                <td style="text-align: right;">
                    <span><strong>{{ number_format($entry->entry_converted_amount, 2, ',', '.') }}</strong></span>
                </td>
                <td style="text-align: right;">
                    <span><strong>{{ number_format($entry->entry_cost_amount, 2, ',', '.') }}</strong></span><br />
                </td>
                <td style="text-align: right;">
                    <span><strong>{{ number_format($entry->entry_purchase_amount, 2, ',', '.') }}</strong></span><br />
                </td>
            </tr>
        </tbody>
    </table>
    <p><strong>B. Troškovi kalkulacije:</strong></p>
    <table class="items-table">
        <thead>
            <tr>
                <th style="text-align: center;"><span>Rb</span></th>
                <th style="text-align: center;"><span>Šifra</span></th>
                <th style="text-align: left;"><span>Naziv partnera</span></th>
                <th style="text-align: left;"><span>Opis troška</span></th>
                <th style="text-align: right;"><span>Iznos troška</span></th>
            </tr>
        </thead>
        <tbody>
            @php($rb = 1)
            @forelse ($costs as $cost)
                <tr style="border: solid 1px #d0d3d4">
                    <td style="text-align: center;">
                        <span>{{ $rb }}</span>
                    </td>
                    <td style="text-align: center;">
                        <span>{{ $cost->EntryCostPartner->partner_index }}</span>
                    </td>
                    <td style="text-align: left;">
                        <span>{{ $cost->EntryCostPartner->partner_name }}</span>
                    </td>
                    <td style="text-align: left;">
                        <span>{{ $cost->cost_description }}</span>
                    </td>
                    <td style="text-align: right;">
                        <span>{{ number_format($cost->cost_converted_amount, 2, ',', '.') }}</span>
                    </td>
                </tr>
                @php($rb = $rb + 1)
            @empty
            @endforelse
            <tr style="border: solid 1px #b3b6b7">
                <td colspan="4" style="text-align: left;">
                    <span><strong>UKUPNO:</strong></span>
                </td>
                <td style="text-align: right;">
                    <span><strong>{{ number_format($entry->entry_cost_amount, 2, ',', '.') }}</strong></span><br />
                </td>
            </tr>
        </tbody>
    </table>
    <br />
    <span>Kalkulaciju izradio: <strong>{{ $entry->StockEntryAuthor->user_name }}</strong>, </span>
    <span>Identifikator dokumenta: <strong>{{ $entry->entry_id }}</strong></span>

</html>
