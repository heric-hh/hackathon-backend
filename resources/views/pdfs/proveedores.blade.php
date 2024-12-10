<!DOCTYPE html>
<html>
<head>
    <title>Proveedores Autorizados</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Listado de Proveedores Autorizados</h1>
    <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Proveedor</th>
                <th>Medio De Contacto</th>
                <th>Nombre del Contacto</th>
                <th>Clasificación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proveedores as $proveedor)
            <tr>
                <td>{{ $proveedor->id }}</td>
                <td>{{ $proveedor->proveedor }}</td>
                <td>{{ $proveedor->medio_de_contacto }}</td>
                <td>{{ $proveedor->nombre_del_contacto }}</td>
                <td>{{ $proveedor->clasificacion}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>