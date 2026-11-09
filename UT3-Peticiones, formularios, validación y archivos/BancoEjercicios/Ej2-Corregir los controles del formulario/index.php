<form method="POST" action="/libro-crear.php">
    <label for="titulo">Título</label>
    <input id="titulo" name="titulo" type="text"> <!--Le faltaba el name-->
<!--Añadir autor y paginas con sus nombres-->
    <label for="autor">Autor</label>
    <input type="text" name="autor" id="autor">
    <label for="paginas">Paginas</label>
    <input type="text" name="paginas" id="paginas">
    <button type="submit">Guardar</button>
</form>