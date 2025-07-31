<?php

$statut = 0;
$getData = $connexion->prepare("SELECT * FROM `annees` ORDER BY id LIMIT 1;");
$getData->execute();
