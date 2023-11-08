<?php
if($_POST){
    $username=$_POST['username'];
    $password= $_POST['password'];
    
    if(empty($username)){
        echo "<script>alert('username tidak boleh kosong');location.href='signup_user.php';</script>";
    } elseif(empty($password)){
        echo "<script>alert('password tidak boleh kosong');location.href='signup_user.php';</script>";
    } else {
        include "connecc.php";
        $insert=mysqli_query($conn,"insert into user (username, password) value ('".$username."','".md5($password)."')") or die(mysqli_error($conn));
        if($insert){
            echo "<script>alert('Sign up successful');location.href='signup_user.php';</script>";
        } else {
            echo "<script>alert('Sign up failed');location.href='signup_user.php';</script>";
        }
    }
}
?>
