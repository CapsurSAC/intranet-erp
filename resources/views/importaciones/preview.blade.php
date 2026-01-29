<!DOCTYPE html>
<html>
<head>
    <title>Vista previa CSV</title>
</head>
<body>

<h1>Vista previa del archivo</h1>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            @foreach ($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $row)
            <tr>
                @foreach ($row as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Archivo cargado:</strong> {{ $path }}</p>

</body>
</html>
