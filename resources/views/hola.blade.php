<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
</head>
<body>
    <h1>{{ $titulo }}</h1>

    @forelse ($proyectos as $proyecto)
        <article>
            <h2>{{ $proyecto->titulo }}</h2>
            <p>{{ $proyecto->stack }} — {{ $proyecto->estado }}</p>
            <p>{{ $proyecto->resumen }}</p>
        </article>
    @empty
        <p>Aún no hay proyectos.</p>
    @endforelse
</body>
</html>