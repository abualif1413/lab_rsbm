<p>
    <h3>Hallo, {{ $sebutan }} {{ $nama }}</h3>
    Pemeriksaan laboratorium anda pada RS. Bhayangkara TK II Medan telah selesai.
    Silahkan mengambil spesimen dan hasilnya langsung ke lokasi,
    atau silahkan klik link dibawah untuk mendapatkan soft copy hasil nya<br />
    <a href="{{ $url_cetak }}">{{ $url_cetak }}</a>
</p>
<p>
    Rincian pemeriksaan {{ $sebutan }} adalah sebagai berikut :
    <ul>
        <li>Nama : {{ $nama }}</li>
        <li>Pemeriksaan : {{ $pemeriksaan }}</li>
    </ul>
</p>
<p>
    Dan hasil pemeriksaan adalah sebagai berikut :
    {!! $hasil !!}
</p>