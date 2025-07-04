<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .error-icon {
            font-size: 3rem;
            color: #dc3545;
            margin-bottom: 20px;
        }
        .error-message {
            color: #333;
            margin-bottom: 25px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon">
            ⚠️
        </div>

        <div class="error-message">
            @if(session('error'))
                {{ session('error') }}
            @elseif(session('message'))
                {{ session('message') }}
            @else
                An error occurred. Please try again.
            @endif
        </div>

        <a href="{{ route('home') }}" class="btn btn-primary">
            Go Home
        </a>
    </div>
</body>
</html> 