<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Vacaciones Declinada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container py-4">
        <div class="card shadow-sm border-danger"> {{-- Borde rojo para indicar declinación --}}
            <div class="card-body">
                <h1 class="card-title text-center text-danger mb-4">Solicitud de Vacaciones Declinada 😞</h1> {{-- Título y emoji de decepción --}}
                <hr class="mb-4">
                <h2 class="text-center text-secondary mb-4">Notificación de {{ env('APP_NAME') }}</h2>

                <p class="lead text-dark mb-4">
                    ¡Hola <span class="text-primary fw-bold">{{ $data['name'] }}</span>!
                </p>
                <p class="text-dark mb-4">
                    Lamentamos informarte que tu solicitud de vacaciones para el día
                    <strong class="text-danger">{{ $data['day'] }}</strong> ha sido <span class="badge bg-danger fs-5">DECLINADA</span>.
                </p>

                {{-- Aquí puedes añadir el motivo de la declinación si lo tienes en $data --}}
                @if (isset($data['reason']))
                    <p class="text-dark mb-4">
                        <strong>Motivo de la declinación:</strong> <span class="text-muted">{{ $data['reason'] }}</span>
                    </p>
                @endif

                <p class="mb-2"><strong>Fecha de solicitud original:</strong> <span class="badge bg-info text-dark">{{ $data['day'] }}</span></p>
                <p class="mb-2"><strong>Tu email registrado:</strong> <span class="text-muted">{{ $data['email'] }}</span></p>

                <p class="text-center text-muted mt-5">
                    Te invitamos a ponerte en contacto con tu supervisor o el departamento de RRHH para discutir opciones o presentar una nueva solicitud.
                </p>

                <div class="text-center mt-4">
                    {{-- Puedes añadir un botón para contactar o ver la política de vacaciones --}}
                    <a href="#" class="btn btn-outline-secondary">Contactar a RRHH</a>
                    <a href="#" class="btn btn-outline-info ms-2">Ver Política de Vacaciones</a>
                </div>
            </div>
        </div>
    </div>

    {{-- El script de Bootstrap no es necesario para los estilos CSS en emails y se recomienda omitirlo. --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
</body>
</html>
