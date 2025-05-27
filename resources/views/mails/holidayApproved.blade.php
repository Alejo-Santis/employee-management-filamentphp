<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Vacaciones Aprobadas!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container py-4">
        <div class="card shadow-sm border-success"> {{-- Borde verde para indicar éxito --}}
            <div class="card-body">
                <h1 class="card-title text-center text-success mb-4">¡Vacaciones Aprobadas! 🎉</h1> {{-- Título y emoji de celebración --}}
                <hr class="mb-4">
                <h2 class="text-center text-secondary mb-4">Notificación de {{ env('APP_NAME') }}</h2>

                <p class="lead text-dark mb-4">
                    ¡Hola <span class="text-primary fw-bold">{{ $data['name'] }}</span>!
                </p>
                <p class="text-dark mb-4">
                    Nos complace informarte que tu solicitud de vacaciones para el día
                    <strong class="text-success">{{ $data['day'] }}</strong> ha sido <span class="badge bg-success fs-5">APROBADA</span>.
                </p>

                <p class="mb-2"><strong>Fecha de solicitud original:</strong> <span class="badge bg-info text-dark">{{ $data['day'] }}</span></p>
                <p class="mb-2"><strong>Tu email registrado:</strong> <span class="text-muted">{{ $data['email'] }}</span></p>

                <p class="text-center text-muted mt-5">
                    ¡Que disfrutes mucho tus vacaciones!
                </p>

                <div class="text-center mt-4">
                    {{-- Puedes añadir un botón para ver el calendario de vacaciones o políticas, si aplica --}}
                    <a href="#" class="btn btn-outline-primary">Ver Calendario de Vacaciones</a>
                </div>
            </div>
        </div>
    </div>

    {{-- El script de Bootstrap no es necesario para los estilos CSS en emails y se recomienda omitirlo. --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
</body>
</html>
