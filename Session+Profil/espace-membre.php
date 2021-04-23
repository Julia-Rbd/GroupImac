<?php
session_start();
if (!isset($_SESSION['infoMembre'])) {header ('Location: index.html');exit();}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />    
<title>Espace membre</title>
<meta name="robots" content="noindex, nofollow">
</head>
<body>
<p><strong>ESPACE MEMBRES</strong><br/>
Bienvenue <?php echo $_SESSION['infoMembre']['prenom']; ?> !<br/>
<a href="deconnexion.php">Déconnexion</a>
</p>
</body>
</html>
