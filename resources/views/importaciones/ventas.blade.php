@extends('layouts.app')

@section('content')
    <h1>Importar ventas históricas</h1>

    <form>
        <label>Archivo CSV</label><br>
        <input type="file" accept=".csv"><br><br>

        <button type="button">Cargar archivo</button>
    </form>
@endsection
