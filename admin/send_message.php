<?php
include '../db.php';

$conn->query("INSERT INTO messages (sender_id,receiver_id,message)
              VALUES (1,$_POST[employee_id],'$_POST[message]')");
