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
    private $url_cetak;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sebutan, $nama, $url_cetak)
    {
        $this->sebutan = $sebutan;
        $this->nama = $nama;
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
                    ->view('email_hasil')
                    ->with(
                    [
                        'sebutan' => $this->sebutan,
                        'nama' => $this->nama,
                        'url_cetak' => $this->url_cetak,
                    ]);
    }
}
