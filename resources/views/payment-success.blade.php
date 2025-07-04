<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .success-icon {
            width: 60px;
            height: 60px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 30px;
        }
    </style>
</head>

<body>
    <div class="success-container">
        <div class="success-icon">
            ✓
        </div>
        @if (session('message') ?? (isset($message) && $message))
            <div class="alert alert-info">
                {{ session('message') ?? $message }}
            </div>
        @endif

        <h3 class="text-success mb-3">Transaction Successful!</h3>
        <p class="text-muted mb-4">Your transaction has been processed successfully.</p>

        @if(isset($id))
        <a href="{{ route('payment.refund', $id) }}" class="btn btn-warning">Refund</a>
        @endif
        <a href="/" class="btn btn-primary">Back to Home</a>
    </div>
</body>

</html>
