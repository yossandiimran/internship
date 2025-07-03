
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        

    @page { size: auto;  margin: 0mm; }
    @media print {
  .idUserKirim {
    display: none;
  }
}
    @media print {


    tr.bg1 {
            background-color: #66ccff !important;
            -webkit-print-color-adjust: exact; 
        }
    tr.bg2 {
            background-color: #daeef3 !important;
            -webkit-print-color-adjust: exact; 
        }
    .bgTopRight{
        z-index: -1;
    }
    .logoRight{
        z-index: 1;
    }
    }

    @font-face /*perintah untuk memanggil font eksternal*/
    {
        font-family: 'OldEnglish'; /*memberikan nama bebas untuk font*/
        src: url('../assets/font/Monotype.ttf');/*memanggil file font eksternalnya di folder nexa*/
    }
    @font-face
    {
        font-family: 'Algerian'; /*memberikan nama bebas untuk font*/
        src: url('../assets/font/Algerian.ttf');/*memanggil file font eksternalnya di folder nexa*/
    }

    </style>
</head>
<body>
<!-- Sertifikat -->
<?php
    function formatDate($inputDate) {
            $months = [
                'Januari', 'Februari', 'Maret', 'April',
                'Mei', 'Juni', 'Juli', 'Agustus',
                'September', 'Oktober', 'November', 'Desember'
        ];

        $dateParts = explode('-', $inputDate);
        $year = $dateParts[0];
        $month = $months[(int)$dateParts[1] - 1];
        $day = $dateParts[2];

        return $day . ' ' . $month . ' ' . $year;
    } 
?>
<?php foreach ($query as $data) { ?>
        <!-- Kondisi Keterangan -->
        <?php 
            function predikat($nilai) {
                $predikatNilai = "";
            
                if ($nilai >= 3.5 && $nilai <= 4) {
                    $predikatNilai = "Sangat Baik";
                } elseif ($nilai >= 3.0 && $nilai < 3.5) {
                    $predikatNilai = "Baik";
                } elseif ($nilai >= 2.5 && $nilai < 3.0) {
                    $predikatNilai = "Cukup";
                } elseif ($nilai >= 2.0 && $nilai < 2.5) {
                    $predikatNilai = "Kurang";
                } else {
                    $predikatNilai = "Sangat Kurang";
                }
            
                return $predikatNilai;
            }

            $jumlah = $data->kedisiplinan + $data->tanggung_jawab + $data->kerapihan + $data->komunikasi + $data->pemahaman_pekerjaan + $data->manajemen_waktu + $data->kerjasama_tim;

            $rata = ($jumlah / 7);
            $rataRataNilai = floor($rata * 100) / 100;
            
        ?>
        
    <?php } ?>
        <!-- Kondisi Keterangan -->
       
<div style="height: 100vh;">
    <img src="<?= base_url(); ?>assets/img/bahanSertifikat/logo.png" style="width: 1000px; margin: 7% 4.1%;  opacity: 0.2; z-index: -1; position: absolute;">
    <div style="margin-top: -10px;">
        <table class="" style="width: 100%; align:center;">
                <tr>
                    <input type="text" class="idUserKirim" id="idUserKirim" value="<?= $data->idUser ?>" style="opacity: .1; border: 0; position: absolute; margin-top: 60px; padding-left: 200px;">
                    <td style="width: 200px; text-align: center;">
                        <img src="<?= base_url(); ?>assets/img/bahanSertifikat/sertifikat/industriLogo.png" alt="" width="350">
                    </td>

                    <td style="" colspan="2" style="width: 400px; text-align: center;">
                        
                    </td>
                    <td style="width: 200px; text-align: center;">
                        <img src="<?= base_url(); ?>assets/img/bahanSertifikat/sertifikat/LogoSertifikat.png" alt="" width="250">
                    </td>
                </tr>

            </table>
            <h1 style="font-family: OldEnglish; text-align: center; margin-top: -30px; font-size: 90px; color: #00022F;">
                Sertifikat
            </h1>
            <h3 style="text-align: center; margin-top: -75px; font-size: 30px;  font-weight: bold; text-decoration: underline; color: #00022F;">
                PRAKTIK KERJA INDUSTRI
            </h3>
            <h5 style="text-align: center; margin-top: -30px; font-size: 20px;  font-weight: bold; color: #00022F;">
                Nomor : <?php foreach ($query as $data) { ?> 
                                <?= $data->no_surat_penilaian ?>
                        <?php } ?>
            </h5>
            <div style="text-align: center; margin-top: -60px; color: #00022F;">
                <h1>
                    Diberikan Kepada :
                </h1>
                <h1 style="font-family: Algerian; font-size: 50px; font-weight: lighter; margin-top: -10px; color: #00022F; text-decoration: underline;">
                    <?php foreach ($query as $data) { ?>
                        
                        <?= $data->namaLengkap; ?>
                </h1>
                <h1 style="color: #00022F; margin-top: -30px;">
                <?= $data->asalSekolah; ?>
                </h1>
                <?php }?>
                <div>
                    <p style="margin-top: 20px; color: #00022F; text-align: center; width: 70%; font-size: 25px; font-weight: bold; margin: auto; margin-bottom: 10px;">
                        Telah melaksanakan Praktik Kerja Industri pada <br>
                        PT. WIKA Industri & Konstruksi Pabrikasi Baja Majalengka Terhitung <br>
                        mulai tanggal <span id="serti_tgl_mulai"></span> s.d <span id="serti_tgl_akhir"></span> dengan hasil <br>
                        “<span id="predikat_jumlah">
                            <?= predikat($rataRataNilai); ?>
                        </span>”
                    </p>
                </div>
            </div>
            <!-- TTD -->
            <div style=" padding-left: 750px;">
                <div style="  width: 70%; margin: auto;">
                    <table style="line-height: 1.3; width: 100%; text-align: center;">
                        <tr>
                        <?php foreach ($query as $data) { ?>
                            <td style="">
                            Majalengka,  <?= formatDate($data->tgl_dibuat) ?> <br>
                            PT WIKA Industri & Konstruksi <br>
                                Pabrikasi Baja Majalengka
                            </td>
                            <?php } ?>
                        </tr>
                        <tr >
                            <td style="">
                            <img src="<?= base_url(); ?>assets/img/QrCode/Personalia.png" alt="QR Code" width="80">
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; line-height: 1; ">
                                Titan Rifesha
                            </td>
                        </tr>
                        <tr>
                            <td style="line-height: 1;">
                                Head of HC & Finance Department
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
</div>

<!-- Penilaian -->
<div class="" style="">
  <?php foreach ($query as $data) { 
    
    ?>
    <div class="" style=" margin: auto;
    width: 100%;">
        <table class="" style="width: 100%; align:center;">
            <tr>
                <td style="width: 200px; text-align: center;">
                    <img src="<?= base_url(); ?>assets/img/bahanSertifikat/logo.png" alt="" width="250">
                </td>

                <td style="" colspan="2" style="width: 400px; text-align: center;">
                    <div style="text-align: center; margin-top: 40px; font-size: 17px;  padding-left: 50px;">
                        <p >
                            <span style="font-weight: bold; ">
                                PENILAIAN PRAKTIK KERJA LAPANGAN
                            </span> <br>
                            
                            Nomor : <?= $data->no_surat_penilaian ?>
                            
                        </p>
                    </div>
                </td>
                <td style="width: 200px; text-align: center; z-index: 5;" class="logoRight">
                    <img src="<?= base_url(); ?>assets/img/bahanSertifikat/akhlak.png" alt="" width="150">
                </td>
            </tr>
        </table>
        <div id="backgroundKanan" style=" position: absolute; right: 0; top: 0; z-index: -5;" class="bgTopRight">
            <img src="<?= base_url(); ?>assets/img/bahanSertifikat/kanan.png" alt="" width="500" height="500">
        </div>
        <div id="backgroundKiri" style="margin-top: 180px; position: absolute; left: 0; z-index: -1;">
            <img src="<?= base_url(); ?>assets/img/bahanSertifikat/kiri.png" alt="" width="500" height="420">
        </div>

        <!-- Biodata -->
        
        <div style="margin-top: -20px; margin-left: 60px;">
            <table>
                <tr>
                    <td width="130">Nama Siswa</td>
                    <td width="10"> : </td>
                    <td> <?= $data->namaLengkap ?> </td>
                </tr>
                <tr>
                    <td width="130">Nomor Induk</td>
                    <td width="10"> : </td>
                    <td> <?= $data->nim ?> </td>
                </tr>
                <tr>
                    <td width="130">Program Studi</td>
                    <td width="10"> : </td>
                    <td> <?= $data->jurusan ?> </td>
                </tr>
                <tr>
                    <td width="130">Sekolah </td>
                    <td width="10"> : </td>
                    <td> <?= $data->asalSekolah ?> </td>
                </tr>
            </table>
        </div>

        <!-- <input type="text" id="predikat_jumlah"  value=""> -->
        <!-- Nilai -->
        <div style="margin-top: 20px; margin-left: 60px;">
            <table border="1" style="border-collapse: collapse; width: 90%;">
                <tr id="bg1" class="bg1" style="background-color: #66ccff">
                    <th style="font-weight: bold; padding: 5px;">No</th>
                    <th style="font-weight: bold; padding: 5px;">FAKTOR KOMPETENSI</th>
                    <th style="font-weight: bold; padding: 5px;">BOBOT</th>
                    <th style="font-weight: bold; padding: 5px;">NILAI</th>
                    <th style="font-weight: bold; padding: 5px;">KETERANGAN</th>
                </tr>
                <tr class="bg2" style="font-weight: bold; background-color: #daeef3;">
                    <th style="font-weight: bold; padding: 5px; text-align: left; padding-left: 10px;" colspan="2">KEPRIBADIAN DAN PERILAKU</th>
                    <th style="font-weight: bold; padding: 5px;"></th>
                    <th style="font-weight: bold; padding: 5px;"></th>
                    <th style="font-weight: bold; padding: 5px;"></th>
                </tr>
               
                <tr style="">
                    <th style="padding: 5px; font-weight: normal;">3</th>
                    <th style="padding: 5px; text-align: left; font-weight: normal;">Kedisiplinan</th>
                    <!-- Bobot -->
                    <th style="padding: 5px; font-weight: normal;">20%</th>
                    <!-- Nilai -->
                    <th style="padding: 5px; font-weight: normal;">
                        <?= $data->kedisiplinan ?>
                    </th>
                    <!-- Keterangan -->
                    <th style="padding: 5px; font-weight: normal;"><?= predikat( $data->kedisiplinan) ?></th>
                </tr>
                <tr style="">
                    <th style="padding: 5px; font-weight: normal;">1</th>
                    <th style="padding: 5px; text-align: left; font-weight: normal;">Tanggung Jawab</th>
                    <!-- Bobot -->
                    <th style="padding: 5px; font-weight: normal;">20%</th>
                    <!-- Nilai -->
                    <th style="padding: 5px; font-weight: normal;">
                        <?= $data->tanggung_jawab ?>
                    </th>
                    <!-- Keterangan -->
                    <th style="padding: 5px; font-weight: normal;"><?= predikat( $data->tanggung_jawab) ?></th>
                </tr>
                <tr style="">
                    <th style="padding: 5px; font-weight: normal;">2</th>
                    <th style="padding: 5px; text-align: left; font-weight: normal;">Kerapihan</th>
                    <!-- Bobot -->
                    <th style="padding: 5px; font-weight: normal;">15%</th>
                    <!-- Nilai -->
                    <th style="padding: 5px; font-weight: normal;">
                        <?= $data->kerapihan ?>
                    </th>
                    <!-- Keterangan -->
                    <th style="padding: 5px; font-weight: normal;"><?= predikat( $data->kerapihan) ?></th>
                </tr>
                <tr style="">
                    <th style="padding: 5px; font-weight: normal;">4</th>
                    <th style="padding: 5px; text-align: left; font-weight: normal;">Komunikasi</th>
                    <!-- Bobot -->
                    <th style="padding: 5px; font-weight: normal;">15%</th>
                    <!-- Nilai -->
                    <th style="padding: 5px; font-weight: normal;">
                        <?= $data->komunikasi ?>
                    </th>
                    <!-- Keterangan -->
                    <th style="padding: 5px; font-weight: normal;"><?= predikat( $data->komunikasi) ?></th>
                </tr>
                <!-- Proses Kerja -->
                <tr class="bg2" style="font-weight: bold; background-color: #daeef3;">
                    <th style="font-weight: bold; padding: 5px; text-align: left; padding-left: 10px;" colspan="2">PROSES KERJA</th>
                    <th style="font-weight: bold; padding: 5px;"></th>
                    <th style="font-weight: bold; padding: 5px;"></th>
                    <th style="font-weight: bold; padding: 5px;"></th>
                </tr>
                <tr style="">
                    <th style="padding: 5px; font-weight: normal;">1</th>
                    <th style="padding: 5px; text-align: left; font-weight: normal;">Pemahaman Pekerjaan</th>
                    <!-- Bobot -->
                    <th style="padding: 5px; font-weight: normal;">10%</th>
                    <!-- Nilai -->
                    <th style="padding: 5px; font-weight: normal;">
                        <?= $data->pemahaman_pekerjaan ?>
                    </th>
                    <!-- Keterangan -->
                    <th style="padding: 5px; font-weight: normal;"><?= predikat( $data->pemahaman_pekerjaan) ?></th>
                </tr>
                <tr style="">
                    <th style="padding: 5px; font-weight: normal;">2</th>
                    <th style="padding: 5px; text-align: left; font-weight: normal;">Manajemen Waktu</th>
                    <!-- Bobot -->
                    <th style="padding: 5px; font-weight: normal;">10%</th>
                    <!-- Nilai -->
                    <th style="padding: 5px; font-weight: normal;">
                        <?= $data->manajemen_waktu ?>
                    </th>
                    <!-- Keterangan -->
                    <th style="padding: 5px; font-weight: normal;"><?= predikat( $data->manajemen_waktu) ?></th>
                </tr>
                <tr style="">
                    <th style="padding: 5px; font-weight: normal;">3</th>
                    <th style="padding: 5px; text-align: left; font-weight: normal;">Kerjasama Dalam Kerja </th>
                    <!-- Bobot -->
                    <th style="padding: 5px; font-weight: normal;">10%</th>
                    <!-- Nilai -->
                    <th style="padding: 5px; font-weight: normal;">
                        <?= $data->kerjasama_tim ?>
                    </th>
                    <!-- Keterangan -->
                    <th style="padding: 5px; font-weight: normal;"><?= predikat( $data->kerjasama_tim) ?></th>
                </tr>
                <tr class="bg2" style="font-weight: bold; background-color: #daeef3;">
                    <th style="font-weight: bold; padding: 5px; text-align: center;" colspan="2"> NILAI AKHIR</th>
                    <th style="font-weight: bold; padding: 5px;"></th>
                    <th style="font-weight: bold; padding: 5px;">
                        <?= $rataRataNilai ?>
                    </th>
                    <th style="font-weight: bold; padding: 5px;"></th>
                </tr>
            </table>


           <div style=" display: grid;
           width: 90%;
                        grid-template-columns: auto auto auto;
                        ">
            <table style="margin-top: 20px; grid-column: span 2;">
                    <tr style="text-align: left;">
                        <th>
                            Keterangan Nilai : 
                        </th>
                    </tr>
                    <tr>
                        <td>
                        
                        </td>
                    </tr>
                    <tr>
                        <td>
                            3.5 - 4.0  &nbsp; : Sangat Baik
                        </td>
                    </tr>
                    <tr>
                        <td>
                        
                        </td>
                    </tr>
                    <tr>
                        <td>
                            3.0 - 3.5  &nbsp; : Baik
                        </td>
                    </tr>
                    <tr>
                        <td>
                        
                        </td>
                    </tr>
                    <tr>
                        <td>
                            2.5 - 3.0  &nbsp; : Cukup
                        </td>
                    </tr>
                    <tr>
                        <td>
                        
                        </td>
                    </tr>
                    <tr>
                        <td>
                            2.0 - 2.5  &nbsp; : Kurang
                        </td>
                    </tr>
                    <tr>
                        <td>
                        
                        </td>
                    </tr>
                    <tr>
                        <td>
                            1.0 - 2.0  &nbsp; : Sangat Kurang
                        </td>
                    </tr>
            </table>
           
            <!-- TTD -->
            <div style="margin-top: -217px;">
                <table style="line-height: 1.3; width: 100%; text-align: right;">
                    <tr>
                        <td style="padding-right: 25px;">
                            Majalengka, <?= formatDate($data->tgl_dibuat) ?>
                            <input type="text" id="idUserGet" style="display: none;" value="<?= $data->idUser ?>"></input>
                            
                        </td>
                    </tr>
                    <tr >
                        <td style="padding-right: 155px;">
                        <img src="<?= base_url(); ?>assets/img/QrCode/Personalia.png" alt="QR Code" width="80">
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; line-height: 1; padding-right: 140px;">
                            Titan Rifesha
                        </td>
                    </tr>
                    <tr>
                        <td style="line-height: 1; padding-right: 3px;">
                            Head of HC & Finance Department
                        </td>
                    </tr>
                </table>
            </div>
           </div>


        </div>
        <!-- Nilai -->

   </div>
  <?php } ?>
</div>
<script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script>


function formatDate(inputDate) {
        const months = [
        'Januari', 'Februari', 'Maret', 'April',
        'Mei', 'Juni', 'Juli', 'Agustus',
        'September', 'Oktober', 'November', 'Desember'
        ];
        const dateParts = inputDate.split('-');
        const year = dateParts[0];
        const month = months[parseInt(dateParts[1]) - 1];
        const day = dateParts[2];
        const keluaran = day + ' ' + month + ' ' + year;
        return keluaran;
    }

    // Fungsi untuk menghasilkan nomor surat
    function generateNomorSurat(divisi, bulan, tanggal, perusahaan, hurufAbjad, lokasiPerusahaan, jenisSurat, jumlahSurat, tahunSekarang) {
        // Format nomor surat sesuai dengan parameter yang diberikan
        var nomorSurat = divisi + "." +
            bulan + "." +
            tanggal + "/" +
            perusahaan + "." +
            hurufAbjad + "." +
            lokasiPerusahaan + "." +
            jenisSurat + "." +
            jumlahSurat.toString().padStart(5, '0') + "/" +
            tahunSekarang;
        return nomorSurat;
    }

    function singkatanDariKata(kata) {
        var kataArray = kata.split(" ");
        var singkatan = "";
        for (var i = 0; i < kataArray.length; i++) {
            var kata = kataArray[i];
            if (/[A-Z]/.test(kata.charAt(0))) {
                var hurufBesar = kata.charAt(0);
                singkatan += hurufBesar;
            }
        }
        return singkatan;
    }
    
    $(document).ready(function() {
       

        var id = document.getElementById('idUserKirim').value;
        var idUser = {idUser : id };
                    console.log(id);
        
        $.ajax({  
            type: "POST", 
            data: idUser,
            url: "<?php echo base_url('SertifikatController/getTanggal'); ?>",
            success: function(response){
                console.log("Get Tgl Surat", response.getTanggal);

            // $('#noSertiBaru').text(formatDate(response.getTanggal.nomorSuratBalasan));
            $('#serti_tgl_mulai').text(formatDate(response.getTanggal.tglMulai));
            $('#serti_tgl_akhir').text(formatDate(response.getTanggal.tglAkhir));

            }
        });

    });

</script>

</body>
</html>