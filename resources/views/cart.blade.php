<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .cart-container {
            max-width: 1000px;
            margin: 40px auto;
        }

        .summary-table {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .proceed-btn {
            width: 100%;
        }
    </style>
</head>

<body>
    @php
        $products = [
            [
                'name' => 'Product 1',
                'description' => 'Description for product 1',
                'price' => 100,
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description for product 2',
                'price' => 200,
            ],
            [
                'name' => 'Product 3',
                'description' => 'Description for product 3',
                'price' => 300,
            ],
        ];
    @endphp
    <div class="container cart-container">
        <div class="row">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="col-md-7">
                <h2>Your Cart</h2>
                <div class="list-group mb-4">
                    @foreach ($products as $product)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">{{ $product['name'] }}</h5>
                                <p class="mb-1 text-muted">{{ $product['description'] }}</p>
                            </div>
                            <span class="fw-bold">{{ $product['price'] }} EGY</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-5">
                <div class="summary-table p-4">
                    <h4 class="mb-3">Summary</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-end">Price (EGY)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td class="text-end">{{ $product['price'] }}</td>
                                </tr>
                                @php $total += $product['price']; @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th class="text-end">{{ $total }} EGY</th>
                            </tr>
                        </tfoot>
                    </table>

                    <form action="{{ route('order.create') }}" method="POST">
                        @csrf
                        <!-- Create Order Section -->
                        <div class="mt-4">

                            <div class="mb-3">
                                <label for="order_description" class="form-label">Order Description</label>
                                <textarea class="form-control" id="order_description" name="description" rows="3" readonly>@php
                                    $description = 'Order containing: ';
                                    foreach ($products as $index => $product) {
                                        $description .= $product['name'] . ' (EGY ' . $product['price'] . ')';
                                        if ($index < count($products) - 1) {
                                            $description .= ', ';
                                        }
                                    }
                                    echo $description;
                                @endphp</textarea>
                            </div>
                            <input type="hidden" name="total_amount" value="{{ $total }}">

                            <button type="submit" class="btn btn-success w-100">Create Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
