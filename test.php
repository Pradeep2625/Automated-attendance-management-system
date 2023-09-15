<?php
$db = new SQLite3('D:\project\face_reco_attendance\attendancedb.db');

$results = $db->query('SELECT count(*) FROM "16471a05l8"');
$row = $results->fetchArray();
  echo $row[0];
?>