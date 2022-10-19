<?php
$conn = mysqli_connect("localhost", "root", "", "absen_qr_code");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
