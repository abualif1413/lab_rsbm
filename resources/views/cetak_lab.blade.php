<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Hasil Pemeriksaan</title>
    <style>
        body {
            padding: 0;
            margin: 0;
            font-family: sans-serif;
            font-size: 80%;
        }

        @page {
            margin: 0px 0px;
            size: A4;
        }
    </style>
</head>
<body>
    {!! $kop_surat_hijau !!}
    <br />
    <div style="padding: 5px 50px;">
        {!! $informasi_pasien !!}

        <div style="padding: 5px 50px;">
            {!! $isi !!}
            <br />
            <br />
            {!! $ttd !!}
        </div>
    </div>
</body>
</html>