<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="width: 350px; text-align: center; border: solid 0px black;">
        KEPOLISIAN NEGARA REPUBLIK INDONESIA<br />
        DAERAH SUMATERA UTARA<br />
        <u>RUMAH SAKIT BHAYANGKARA TK II MEDAN</u>
    </div>
    <br />
    <div style="width: auto; text-align: center; font-weight: bold;">
        PERAWATAN DAN PENGOBATAN PERSONEL SAKIT KRONIS/MENAHUN<br />
        RUMAH SAKIT BHAYANGKARA TK II MEDAN
    </div>
    <br />
    <table width="100%" border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Pangkat / NRP</th>
                <th>Jenis Penyakit / Diagnosa</th>
                <th>Tgl. Pemeriksaan</th>
                <th>Tindak Lanjut</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $dt)
                <tr>
                    <td></td>
                    <td>{{ $dt->nama }}</td>
                    <td>{{ $dt->pangkat }}</td>
                    <td>{{ $dt->diagnosa }}</td>
                    <td>{{ $dt->tgl_pemeriksaan }}</td>
                    <td>{{ $dt->tindak_lanjut }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>