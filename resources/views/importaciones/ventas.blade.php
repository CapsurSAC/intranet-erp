<!DOCTYPE html>
<html>
<head>
    <title>Importar ventas</title>
</head>
<body>

<h1>Importar ventas históricas</h1>

<form method="POST" action="/importaciones/ventas/preview" enctype="multipart/form-data">
    @csrf

    <label>Archivo CSV</label><br>
    <input type="file" name="csv" accept=".csv" required><br><br>

    <button type="submit">Cargar archivo</button>
</form>

</body>
</html>
