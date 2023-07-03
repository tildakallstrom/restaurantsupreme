<?php
include("includes/config.php");
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if ($db->connect_errno > 0) {
    die('Fel vid anslutning [' . $db->connect_error . ']');
}
$sql = "DROP TABLE IF EXISTS courses;
CREATE TABLE `courses` (
    `id` int(2) PRIMARY KEY AUTO_INCREMENT,
    `title` varchar(50) NOT NULL,
    `content` varchar(50) NOT NULL,
    `author` varchar(50) NOT NULL,
    `date` timestamp NOT NULL DEFAULT current_timestamp()
  );";

echo "<pre>$sql</pre>";
if ($db->multi_query($sql)) {
    echo "<p>The tables was installed.</p>";
} else {
    echo "<p class='error'>Something went wrong.</p>";
}