<?php


function createQuery() {
    $query = "";
    $query = "SELECT * FROM transactions ORDER BY transactionDate DESC";
    return $query;
}

function sumQuery() {
    $query = "";
    $query = "SELECT SUM(transactionAmount) FROM transactions";
    return $query;
}

?>