<?php
session_start();

require_once(__DIR__ . '/views/head.php'); 
?>
<html>
<body>
<?php
    include_once(__DIR__ . '/views/header.php');
    include_once(__DIR__ . '/views/dashboard.php');
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>  
</body>
</html>