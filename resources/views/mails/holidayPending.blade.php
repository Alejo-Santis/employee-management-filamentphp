<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Vacaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title text-center text-primary mb-4">Solicitud de Vacaciones</h1>
                <hr class="mb-4">
                <h2 class="text-center text-secondary mb-4">{{ env('APP_NAME') }}</h2>

                <p class="mb-2"><strong>Solicitud realizada el día:</strong> <span
                        class="badge bg-info text-dark">{{ $data['day'] }}</span></p>
                <p class="mb-2"><strong>Empleado:</strong> <span class="fw-bold">{{ $data['name'] }}</span></p>
                <p class="mb-4"><strong>Email:</strong> <span class="text-muted">{{ $data['email'] }}</span></p>

                <p class="lead text-dark mb-4">El empleado <span class="text-primary fw-bold">{{ $data['name'] }}</span>
                    con email <span class="text-muted">{{ $data['email'] }}</span>, ha realizado una solicitud de
                    vacaciones para el día <strong class="text-danger">{{ $data['day'] }}</strong>.</p>

                <p class="text-center text-muted mb-4">Por favor, revise la solicitud y apruebe o rechace la solicitud.
                </p>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="#" class="btn btn-success btn-lg">Aprobar Solicitud</a>
                    <a href="#" class="btn btn-danger btn-lg">Rechazar Solicitud</a>
                </div>
            </div>
        </div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script> --}}
</body>

</html>
