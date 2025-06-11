<?php
require 'db.php';

$sql = "SELECT MONTH(fecha) AS mes, COUNT(*) AS total FROM citas GROUP BY mes ORDER BY mes";
$result = $conn->query($sql);

$datos = [];
while ($row = $result->fetch_assoc()) {
    $datos[] = [
        "mes" => $row['mes'],
        "total" => $row['total']
    ];
}
echo json_encode($datos);
?>
