<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <link rel="stylesheet" href="{{ asset('falcon/style.css') }}"> --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Qr Code Project</title>

    <style type="text/css">
    /* Reset all margins and padding */
    * {
        margin: 0;
        padding: 0;
    }

    .box1 {
        margin-left: 17px;
        margin-top: 15px;
    }

    .text-container {
        position: relative;
        width: 200px;
        /* Set an appropriate width */
        height: 68px;
        /* Set an appropriate height */
        transform: rotate(90deg);
    }

    .text {
        white-space: nowrap;
        position: absolute;
        margin-left: 68px;
        margin-top: 11px;
        font-size: 18px;
        top: 0;
        /* Adjust the top position as needed */
        left: 8;
        /* Adjust the left position as needed */
    }

    .bold-text {
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif
    }
    </style>

</head>

<body>
    <div>
        <div class="box1">
            {!! DNS2D::getBarcodeHTML("$projects->qrcode_project", 'QRCODE', 3.5, 3.5) !!}
        </div>
        <div class="text-container">
            <div class="text">
                <p class="bold-text">
                    @if ($projects->perintah_kerja)
                    {{ $projects->perintah_kerja->kode_perintah }}
                    @else
                    @endif
                </p>
                <p class="bold-text">
                    @if ($projects->perintah_kerja)
                    {{ $projects->perintah_kerja->spk->surat_penawaran->typekaroseri->nama_karoseri }}
                    @else
                    @endif
                </p>
                <p class="bold-text">
                    @if ($projects->perintah_kerja->dokumen_project->first())
                    {{ $projects->perintah_kerja->dokumen_project->first()->tahun }}
                    @else
                    @endif
                </p>
                <p class="bold-text">
                    @if ($projects->perintah_kerja->dokumen_project->first())
                    {{ $projects->perintah_kerja->dokumen_project->first()->no_serut }}
                    @else
                    @endif
                </p>
                <p class="bold-text">
                    @if ($projects->perintah_kerja->dokumen_project->first())
                    {{ $projects->perintah_kerja->dokumen_project->first()->no_rangka }}
                    @else
                    @endif
                </p>
            </div>
        </div>
    </div>
</body>

</html>