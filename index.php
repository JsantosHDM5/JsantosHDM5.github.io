<?php
require 'db.php';

// Crear cita
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crear"])) {
    $cliente = $_POST["cliente"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $servicio = $_POST["servicio"];

    $conn->query("INSERT INTO citas (cliente, fecha, hora, servicio)
                  VALUES ('$cliente', '$fecha', '$hora', '$servicio')");
    header("Location: index.php");
    exit;
}

// Eliminar cita
if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];
    $conn->query("DELETE FROM citas WHERE id = $id");
    header("Location: index.php");
    exit;
}

// Editar cita
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar"])) {
    $id = $_POST["id"];
    $cliente = $_POST["cliente"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $servicio = $_POST["servicio"];

    $conn->query("UPDATE citas SET cliente='$cliente', fecha='$fecha', hora='$hora', servicio='$servicio'
                  WHERE id=$id");
    header("Location: index.php");
    exit;
}

$citas = $conn->query("SELECT * FROM citas");
$editando = false;
$citaEditar = null;

if (isset($_GET["editar"])) {
    $editando = true;
    $idEditar = $_GET["editar"];
    $res = $conn->query("SELECT * FROM citas WHERE id=$idEditar");
    $citaEditar = $res->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Barber Soft - Citas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Barber Soft</h1>
    <p>Sistema CRUD de Citas</p>
</header>

<main>
    <section class="formulario">
        <h2><?= $editando ? 'Editar Cita' : 'Agregar Nueva Cita' ?></h2>
        <form method="post">
            <?php if ($editando): ?>
                <input type="hidden" name="id" value="<?= $citaEditar['id'] ?>">
            <?php endif; ?>
            <input type="text" name="cliente" placeholder="Nombre del cliente" required value="<?= $editando ? $citaEditar['cliente'] : '' ?>">
            <input type="date" name="fecha" required value="<?= $editando ? $citaEditar['fecha'] : '' ?>">
            <input type="time" name="hora" required value="<?= $editando ? $citaEditar['hora'] : '' ?>">
            <input type="text" name="servicio" placeholder="Servicio" required value="<?= $editando ? $citaEditar['servicio'] : '' ?>">
            <button type="submit" name="<?= $editando ? 'editar' : 'crear' ?>">
                <?= $editando ? 'Actualizar' : 'Guardar' ?>
            </button>
        </form>
    </section>

    <section class="tabla">
        <h2>Lista de Citas</h2>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Servicio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $citas->fetch_assoc()): ?>
                    <tr>
                        <td><?= $fila['cliente'] ?></td>
                        <td><?= $fila['fecha'] ?></td>
                        <td><?= $fila['hora'] ?></td>
                        <td><?= $fila['servicio'] ?></td>
                        <td>
                            <a href="?editar=<?= $fila['id'] ?>">Editar</a> |
                            <a href="?eliminar=<?= $fila['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>

    <section class="dashboard">
        <h2>Estadísticas de Citas por Mes</h2>
        <canvas id="citasChart" width="400" height="200"></canvas>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="script.js"></script>
</body>
</html>
