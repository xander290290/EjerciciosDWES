<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario basico</title>
</head>
<body>
    <form method="post" action="./Ej1.php">
        <label for="titulo">Título</label>
        <input id="titulo" name="titulo" type="text"><br>
        <label for="autor">Autor</label>
        <input id="autor" name="Autor" type="text"><br>
        <label for="paginas">páginas</label>
        <input id="paginas" name="paginas" type="text"><br>
        <label for="genero">genero</label>
        <input id="genero" name="genero" type="text"><br>
        <label for="fechaAlta">fechaAlta</label>
        <input id="fechaAlta" name="fechaAlta" type="text"><br>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>