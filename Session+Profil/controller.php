<?php
require_once('model.php');

function getAProjetByID($id) {
    return json_encode(getProjetByID($id));
}
?>