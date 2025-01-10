<?php

$url = 'https://jsonplaceholder.typicode.com/todos';

// Inicializa una sesión cURL
$ch = curl_init($url);

// Configura las opciones de cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
// Desactiva la verificación del certificado SSL

// Ejecuta la solicitud
$response = curl_exec($ch);

// Verifica si hay un error en la solicitud.
if ($response === false) {
    echo 'Error en la solicitud: ' . curl_error($ch);
    exit();
}

// Cierra la sesión cURL
curl_close($ch);

// Decodifica la respuesta JSON.
$posts = json_decode($response, true);

// Verifica si la decodificación fue exitosa.
if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'Error al decodificar JSON: ' . json_last_error_msg();
    exit();
}

// Limita el número de tareas a mostrar a 10.
$posts = array_slice($posts, 0, 10);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Tareas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5 text-center">Tareas</h1>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th class ="text-center">Título</th>
                <th>Completado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($post['id']); ?></td>
                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                        <td><?php echo htmlspecialchars($post['completed'] ? 'Sí' : 'No'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No se encontraron tareas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>