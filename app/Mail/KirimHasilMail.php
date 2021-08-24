<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KirimHasilMail extends Mailable
{
    use Queueable, SerializesModels;

    private $sebutan;
    private $nama;
    private $pemeriksaan;
    private $hasil;
    private $url_cetak;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sebutan, $nama, $pemeriksaan, $hasil, $url_cetak)
    {
        $this->sebutan = $sebutan;
        $this->nama = $nama;
        $this->pemeriksaan = $pemeriksaan;
        $this->hasil = $hasil;
        $this->url_cetak = $url_cetak;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->subject('Hasil Pemeriksaan Lab')
                    ->view('email_hasil')
                    ->with(
                    [
                        'sebutan' => $this->sebutan,
                        'nama' => $this->nama,
                        'pemeriksaan' => $this->pemeriksaan,
                        'hasil' => $this->hasil,
                        'url_cetak' => $this->url_cetak,
                    ]);
    }
}
