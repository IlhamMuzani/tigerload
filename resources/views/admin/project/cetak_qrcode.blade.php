<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>

    <style type="text/css">
        /* Reset all margins and padding */
        * {
            margin: 0;
            padding: 0;
        }

        .box1 {
            margin-left: 6px;
            margin-top: 6px;
        }

        .text-container {
            position: relative;
            margin-top: 8px;

        }

        .text {
            font-size: 13px;
            margin-left: 2px;
            /* margin-top: 5px */
        }

        .bold-text {
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif
        }
    </style>

</head>

<body>
    <div>
        {{-- @foreach ($bans as $ban) --}}
        {{-- <div class="text-container" style="page-break-after: always;"> --}}
        <div class="text-container">
            <table>
                <td>
                    <div class="box1">
                        <table>
                            <td>
                                <div style="display: inline-block;">
                                    {!! DNS2D::getBarcodeHTML("$projects->qrcode_project", 'QRCODE', 3.4, 3.4) !!}
                                </div>
                            </td>
                            <td>
                                <div class="text" style="font-size: 16px; margin-left:8px">
                                    <p class="bold-text">
                                        {{ $projects->kode_project }}
                                    </p>
                                    <p class="bold-text">
                                        @if ($projects->perintah_kerja)
                                            {{ \Illuminate\Support\Str::limit($projects->perintah_kerja->spk->surat_penawaran->typekaroseri->nama_karoseri, 20) }}
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
                                            {{ $projects->perintah_kerja->dokumen_project->first()->no_mesin }}
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
                            </td>
                        </table>
                    </div>
                </td>
            </table>
        </div>
        {{-- @endforeach --}}
    </div>
</body>


</html>
