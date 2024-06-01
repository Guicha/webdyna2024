<?php

require "verif_session.php";

include "liaison_bdd.php";

$formationId = $_GET['IDformation'];

echo '<form class="row g-3" method="POST" action = "nouveau_projet.php">';

echo '<div class="form-group">';
    echo '<label for="nom">Nom</label>';
    echo '<input type="text" class="form-control" name="nom_de_projet" placeholder="Nom du projet">';
echo '</div>';

echo '<div class="form-group">';
    echo '<label for="description">Description</label>';
    echo '<textarea class="form-control" name="description" rows="3" placeholder="Décrivez le projet"></textarea>';
echo '</div>';

echo '<div class="form-group">';
    echo "<label for='dateDebut'>Date</label>";
    echo '<input type="date" class="form-control" name="date_projet">';
echo '</div>';

echo '<input type="hidden" name="formationID" value='.$formationId.'>';

echo '<button type="submit" name="newprojet" class="btn btn-primary mb-3">Ajouter</button>';
echo '</form>';

