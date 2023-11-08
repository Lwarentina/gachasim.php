<?php
// Sertakan file koneksi database
include('connecc.php');

// Ambil data dari formulir
if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $currency = $_POST['currency'];
    $bayar = $currency * 5000;
    $date = date(date(" Y-m-d H:i:s"));
    if (empty($username)) {
        echo "<script>alert('Username tidak boleh kosong');location.href='transaksi.php';</script>";
    } elseif (empty($password)) {
        echo "<script>alert('Password tidak boleh kosong');location.href='transaksi.php';</script>";
    } else {
        include "connecc.php";
            $qry_login = mysqli_query($conn, "select * from user where username = '" . $username . "' and password = '" . md5($password) . "'");
            if (mysqli_num_rows($qry_login) > 0) {
                $qry_transs = mysqli_query($conn, "select saldo from user where username = '" . $username . "' and password = '" . md5($password) . "'");
                $rows = mysqli_fetch_assoc($qry_transs);
                $saldo = $rows['saldo'];
                $qry_transc = mysqli_query($conn, "select currency from user where username = '" . $username . "' and password = '" . md5($password) . "'");
                $rowc = mysqli_fetch_assoc($qry_transc);
                $currentc = $rowc['currency'] + $currency;
                if ($qry_transs and $qry_transc){
                    if($saldo >= $bayar){
                        $saldo -= $bayar;
                        $qry_apdets = mysqli_query($conn, "update user set saldo = '".$saldo."' where username = '" . $username . "' and password = '" . md5($password) . "'");
                        $qry_apdetc = mysqli_query($conn, "update user set currency = '".$currentc."' where username = '" . $username . "' and password = '" . md5($password) . "'");
                        $qry_histo = mysqli_query($conn, "insert into transaksi (username, password, currency, saldo, tgl_topup) values ('" . $username . "','" . md5($password) . "','" . ($currentc) . "','" . ($saldo) . "','" . ($date) . "')");
                        $dt_login = mysqli_fetch_array($qry_login);
                        echo "<script>alert('Top up successful');location.href='transaksi.php';</script>";
                        session_start();
                        $_SESSION['username'] = $dt_login['username'];
                        $_SESSION['password'] = $dt_login['password'];
                        $_SESSION['saldo'] = $dt_login['saldo'];
                        $_SESSION['currency'] = $dt_login['currency'];
                        header("location: wish.php");
                    }
                    else {
                        echo "<script>alert('saldo tidak cukup');location.href='transaksi.php'</script>";
                    }
                } 
                else {
                    echo "<script>alert('saldo habis');location.href='transaksi.php'</script>";
                }
            }
            else {
                echo "<script>alert('Username dan Password tidak benar');location.href='transaksi.php';</script>";
            }
    }
}
?>