<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perhitungan Pengambilan Bahan Baku</title>
    <style>
        html,
        body {
            font-family: 'Times New Roman', Times, serif;
            color: black;
            padding: 0px;
            margin:0px;
        }

        .pdf-container {
            width: 100%;
            height: 100vh;
            /* Set height to full viewport height */
        }

        .pdf-container embed {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <table width="100%">
        <tr>
            <td style="width: 100%; text-align: center;">
                <div class="pdf-container">
                    <embed src="{{ asset('storage/uploads/' . $inquery->gambar_pajak) }}" type="application/pdf" />
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
