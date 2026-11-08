<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de la biblioteca</title>
    <link rel="stylesheet" href="style/estilos.css">
</head>
<body>
    <h1>Catálogo de la biblioteca</h1>

    <form action="index.php" method="get">
        <p>
            <label for="q">Título o autor</label>
            <input type="text" id="q" name="q">
        </p>
        <p>
            <label for="genero">Género</label>
            <select id="genero" name="genero">
                <option value="">Todos</option>
                <option value="ciencia">Ciencia</option>
                <option value="fantasia">Fantasía</option>
                <option value="terror">Terror</option>
            </select>
        </p>
        <p>
            <label for="tipo">Tipo de libro</label>
            <select id="tipo" name="tipo">
                <option value="">Todos</option>
                <option value="papel">Papel</option>
                <option value="digital">Digital</option>
            </select>
        </p>
        <p>
            <input type="checkbox" id="destacados" name="destacados" value="1">
            <label for="destacados">Solo destacados</label>
        </p>
        <button type="submit">Buscar</button>
    </form>

    <h2>Resultados</h2>
    <?php require __DIR__ . '/tabla.php'; ?>

    <p><a href="alta.php">Dar de alta un libro</a></p>
    <p><a href="index.php">Recuperar catálogo inicial</a></p>
</body>
</html>
