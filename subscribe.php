<?php
require 'config.php';
$email = strip_tags($_POST['email']);

if (isset($_POST['submit'])) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $checkemail = $conn->prepare('SELECT email FROM subscribers WHERE email = :email');
        $checkemail->bindParam(':email', $email);
        $checkemail->execute();
        if ($checkemail->rowCount() > 0) {
            echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('Email Already Subscribed');
        window.location.replace(\"index.html\");
        </SCRIPT>";
        } else {
            $subscribe = $conn->prepare('INSERT INTO subscribers (email) 
        VALUES (:email)');
            $subscribe->bindParam(':email', $email);
            //execute
            $subscribe->execute();

            echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('Thank you for subscribing');
        window.location.replace(\"index.html\");
        </SCRIPT>";
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
$conn = null;
