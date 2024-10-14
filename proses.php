<?php

if (@$_GET["kirimkan"]) {
  $curl = curl_init();
  $text = htmlspecialchars($_GET["text"]);
  $nomor = htmlspecialchars($_GET["nomor"]);
  $tanggal = htmlspecialchars($_GET["tanggal"]);
  $waktu = htmlspecialchars($_GET["waktu"]);

  $pesan = $text . "\n\npesan ini dikirim melalui chat bot jangan berikan data pribadi anda. jika ingin mecoba chatbot kunjungi link berikut";

  
  if($tanggal != '' && $waktu != '') {
    $datetimeString = $tanggal . ' ' . $waktu;
    $timezone = '+0700';
    $datetimeStringWithTimezone = $datetimeString . $timezone;
    $jadwal= strtotime($datetimeStringWithTimezone);
  } else {
    $jadwal = 0;
  }

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.fonnte.com/send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
      'target' => $nomor,
      'message' => $pesan,
      'url' => 'https://md.fonnte.com/images/wa-logo.png',
      'filename' => 'filename',
      'schedule' => $jadwal,
      'typing' => false,
      'delay' => '2',
      'countryCode' => '62',
      'followup' => 0,
    ),
    CURLOPT_HTTPHEADER => array(
      'Authorization: xFkZ7PB87i8NML7wjqxR'
    ),
  ));

  $response = curl_exec($curl);
  if (curl_errno($curl)) {
    $error_msg = curl_error($curl);
  }
  curl_close($curl);

  if (isset($error_msg)) {
    echo $error_msg;
  }
  echo $response;
}
