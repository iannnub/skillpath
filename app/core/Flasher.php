<?php

class Flasher {
    public static function setFlash($pesan, $aksi, $tipe) {
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'aksi'  => $aksi,
            'tipe'  => $tipe // success, error, warning, info
        ];
    }

    public static function flash() {
        if (isset($_SESSION['flash'])) {
            $pesan = $_SESSION['flash']['pesan'];
            $aksi = $_SESSION['flash']['aksi'];
            $tipe = $_SESSION['flash']['tipe'];

            echo "<script>
                Swal.fire({
                    title: '{$pesan}',
                    text: '{$aksi}',
                    icon: '{$tipe}',
                    confirmButtonColor: '#3085d6'
                });
            </script>";
            
            unset($_SESSION['flash']);
        }
    }
}