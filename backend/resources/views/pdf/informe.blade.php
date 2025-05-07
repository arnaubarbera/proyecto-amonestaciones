<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Informe de Amonestaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .resumen {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .resumen h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Informe de Amonestaciones</h1>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    @if(isset($amonestaciones) && count($amonestaciones) > 0)
        <div class="resumen">
            <h2>Resumen</h2>
            <p>Total de Amonestaciones: {{ $resumen['Total Amonestaciones'] }}</p>
            
            <h3>Por Tipo:</h3>
            <ul>
                @foreach($resumen['Por Tipo'] as $tipo => $cantidad)
                    <li>{{ $tipo }}: {{ $cantidad }}</li>
                @endforeach
            </ul>

            <h3>Por Gravedad:</h3>
            <ul>
                @foreach($resumen['Por Gravedad'] as $gravedad => $cantidad)
                    <li>{{ $gravedad }}: {{ $cantidad }}</li>
                @endforeach
            </ul>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Alumno</th>
                    <th>Profesor</th>
                    <th>Motivo</th>
                    <th>Tipo</th>
                    <th>Gravedad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($amonestaciones as $amonestacion)
                    <tr>
                        <td>{{ $amonestacion->fecha_amonestacion->format('d/m/Y') }}</td>
                        <td>{{ $amonestacion->alumno ? $amonestacion->alumno->nombre . ' ' . $amonestacion->alumno->apellidos : 'N/A' }}</td>
                        <td>
                            @if($amonestacion->comiconvi && $amonestacion->comiconvi->profesores && count($amonestacion->comiconvi->profesores) > 0)
                                {{ $amonestacion->comiconvi->profesores[0]->nombre . ' ' . $amonestacion->comiconvi->profesores[0]->apellidos }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $amonestacion->motivo ?? 'N/A' }}</td>
                        <td>{{ $amonestacion->tipo ?? 'N/A' }}</td>
                        <td>{{ $amonestacion->gravedad ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            No hay amonestaciones para mostrar
        </div>
    @endif
</body>
</html> 