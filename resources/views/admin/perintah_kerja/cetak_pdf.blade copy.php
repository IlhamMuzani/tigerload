<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Perintah Kerja</title>
    <style>
    .b {
        border: 1px solid black;
    }

    .table,
    .td {
        /* border: 1px solid black; */
    }

    .table,
    .tdd {
        border: 1px solid white;
    }

    html,
    body {
        margin: 20px;
        padding: 10px;
    }

    span.h2 {
        font-size: 24px;
        font-weight: 500;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .tdd td {
        border: none;
    }

    .faktur {
        text-align: center
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 7rem;
    }

    .rotate {
        transform: rotate(90deg);
        max-width: 100%;
        height: auto;
    }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <div class="container">
        <img src="{{ asset('storage/uploads/' . $cetakpdf->typekaroseri->gambar_skrb) }}"
            alt="{{ $cetakpdf->typekaroseri->nama_karoseri }}" class="rotate" alt="Logo Tigerload">
    </div>
</body>

</html>