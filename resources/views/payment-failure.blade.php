<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-danger shadow">
                    <div class="card-body text-center">
                        <h1 class="display-4 text-danger mb-3">
                            <i class="bi bi-x-circle-fill"></i>
                            Payment Failed
                        </h1>
                        @if (session('message') ?? (isset($message) && $message))
                        <div class="alert alert-danger">
                            {{ session('message') ?? $message }}
                        </div>
                        @endif
                        <p class="lead">Unfortunately, your payment could not be processed.</p>
                        <p>Please try again or contact support if the problem persists.</p>
                        <a href="/" class="btn btn-primary mt-3">Return to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>

</html>
