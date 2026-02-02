<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            size: auto;
            margin: 0mm;
        }
    </style>
</head>

<body>

    <div class="container" style="font-size: 15px;">
        <div style=" margin: auto;
    width: 50%;
    padding: 10px;">
            <?php
            $logoPath = public_path('assets/bahanSertifikat/logoSuratPenerimaan.png');
            $logoBase64 = '';
            if (file_exists($logoPath)) {
                $logoData = file_get_contents($logoPath);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
            }
            ?>
            <img src="{{ $logoBase64 }}" alt="Logo"
                style=" display: block; margin-left: 50px; width: 250px; height: 90px;">

        </div>
        <div style="width: 85%;">
            <?php
            function formatDate($inputDate)
            {
                $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
                $dateParts = explode('-', $inputDate);
                $year = $dateParts[0];
                $month = $months[(int) $dateParts[1] - 1];
                $day = $dateParts[2];
            
                return $day . ' ' . $month . ' ' . $year;
            }
            ?>

            <div class="" style="display: flex; flex: 1; margin-top: 20px;">
                <div style=" margin-left: 100px;">
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                Nomor : <?= $data->nomor_surat_balasan ?>
                            </td>
                            <td style="text-align: right;">
                                Majalengka, <?= formatDate($data->tanggal_surat_balasan) ?>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>

            <br>
            <div style="margin-left: 100px; line-height: 1.5;">
                <div>
                    Kepada Yth.
                </div>
                <div style="">
                    <b>
                        <?= $data->asal_sekolah_pemohon ?>
                    </b>
                </div>
                <div style="">
                    Di Tempat
                </div>
                <div style="margin-top: 6px; margin-left: 45px;">
                    Perihal : <b> Izin Prakter Kerja Lapangan (PKL) </b>
                </div>
                <p style="margin-top: 10px; text-align: justify; line-height: 1.5;">
                    Dengan Hormat, <br>
                    Merujuk Surat Permohonan <b><?= $data->nomor_surat_pengantar ?></b> tanggal
                    <?= $data->tanggal_surat_pengantar ?>,
                    terkait Permohonan Praktik Kerja Lapangan (PKL) di PT Wijaya Karya Industri & Kontruksi Pabrikasi
                    Baja Majalengka terhadap Siswa/i atau Mahasiswa/i yang namanya tercantum di bawah ini: <br>

                </p>
                <table style="border-collapse: collapse; text-align: center; width: 100%;" border="1">
                    <thead>
                        <tr>
                            <th style="width: 10%;">NO</th>
                            <th style="width: 30%;">Nama</th>
                            <th style="width: 25%;">Nim</th>
                            <th style="width: 30%;">Jurusan / Kompetensi</th>
                            <th style="width: 30%;">Penempatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->pemohon as $q => $p)
                        <tr>
                            <td>{{$q+1}}</td>
                            <td>{{$p->nama_pemohon}}</td>
                            <td>{{$p->nim}}</td>
                            <td>{{$p->jurusan->jurusan}}</td>
                            <td>{{$p->divisi->divisi}}</td>
                        </tr>
                        @endForeach
                    </tbody>
                </table>

                <p style="margin-top: 10px;  text-align: justify; line-height: 1.5;">
                    Bersama dengan ini kami sampaikan bahwa permohonan tersebut <b><?= $data->status_surat == 3 ? 'Belum bisa kami terima' : 'Telah kami terima'; ?></b> untuk
                    melaksanakan Praktik Kerja Lapangan di Pabrikasi Baja Majalengka, PT Wijaya Karya Industri &
                    Kontruksi. Selanjutnya Praktik Kerja Lapangan dilaksanakan dengan ketentuan sebagai berikut:
                </p>

                <div style=" margin-top: 10px;">
                    <table>
                        <tr>
                            <td>Waktu Pelaksanaan</td>
                            <td> : </td>
                            <td> <?= $data->periode_awal ?> s.d <?= $data->periode_akhir ?> </td>
                        </tr>
                        <tr>
                            <td>Pembimbing</td>
                            <td> : </td>
                            <td> <?= $data->pembimbing ?></td>
                        </tr>
                    </table>
                </div>

                <p style="margin-top: 10px;  text-align: justify; line-height: 1.5;">
                    Mohon melakukan konfirmasi maksimal H-3 sebelum waktu pelaksanaan pada kontak dibawah ini :
                </p>

                <div style=" margin-top: 10px;">
                    <table>
                        <tr>
                            <td>Personalia</td>
                            <td> : </td>
                            <td> Jagat Giyana C. </td>
                        </tr>
                        <tr>
                            <td>Kontak Person</td>
                            <td> : </td>
                            <td> 0822 4291 0617 </td>
                        </tr>
                    </table>
                </div>

                <p style="margin-top: 10px;  text-align: justify; line-height: 1.5;">
                    Demikian surat ini disampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.
                </p>

                <!-- TTD -->
                <div style=" margin-top: 20px;">
                    <table style="margin-left: auto; line-height: 1.3;">
                        <tr>
                            <td>Hormat Kami,</td>
                        </tr>
                        <tr>
                            <td style="text-decoration: underline;">
                                PT. Wijaya Karya Industri & Kontruksi
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Pabrikasi Baja Majalengka
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                $ttdPath = public_path('storage/' . $data->ttd_digital);
                                $ttdBase64 = '';
                                if (file_exists($ttdPath) && $data->ttd_digital) {
                                    $ttdData = file_get_contents($ttdPath);
                                    $mimeType = mime_content_type($ttdPath);
                                    $ttdBase64 = 'data:' . $mimeType . ';base64,' . base64_encode($ttdData);
                                }
                                ?>
                                @if($ttdBase64)
                                <img src="{{ $ttdBase64 }}" alt="" style="max-width: 150px; max-height: 100px;">
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; text-decoration: underline; line-height: 1;">
                                Titan Rifesha
                            </td>
                        </tr>
                        <tr>
                            <td style="line-height: 1;">
                                Kasir Keuangan & Personalia
                            </td>
                        </tr>
                    </table>
                </div>

            </div>




        </div>

</body>

</html>
