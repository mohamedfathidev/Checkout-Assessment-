<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .checkout-container {
            max-width: 700px;
            margin: 40px auto;
        }

        .form-section {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 32px;
        }
    </style>
    <script>
        function removeShippingDev(checkbox) {
            var div = document.getElementById('shipping-div');
            var shippingFields = div.querySelectorAll('input');
            if (checkbox.checked) {
                div.style.display = 'none';
                shippingFields.forEach(function(input) {
                    input.removeAttribute('required');
                });
            } else {
                div.style.display = 'block';
                shippingFields.forEach(function(input) {
                    input.setAttribute('required', 'required');
                });
            }
        }
    </script>
</head>

<body>
    <div class="container checkout-container">
        <h2 class="mb-4">Checkout - Billing & Shipping Information</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('checkout', $orderId) }}">
            @csrf
            <div class="form-section mb-4">
                <h4>Billing Information</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="billing_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="billing_name" name="billing[name]" >
                    </div>
                    <div class="col-md-6">
                        <label for="billing_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="billing_email" name="billing[email]" >
                    </div>
                    <div class="col-md-6">
                        <label for="billing_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="billing_phone" name="billing[phone]" >
                    </div>
                    <div class="col-md-6">
                        <label for="billing_street1" class="form-label">Street 1</label>
                        <input type="text" class="form-control" id="billing_street1" name="billing[street1]"
                            required>
                    </div>
                    <div class="col-md-4">
                        <label for="billing_city" class="form-label">City</label>
                        <input type="text" class="form-control" id="billing_city" name="billing[city]" >
                    </div>
                    <div class="col-md-4">
                        <label for="billing_state" class="form-label">State</label>
                        <input type="text" class="form-control" id="billing_state" name="billing[state]" >
                    </div>
                    <div class="col-md-4">
                        <label for="billing_country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="billing_country" name="billing[country]"
                            required>
                    </div>
                    <div class="col-md-4">
                        <label for="billing_zip" class="form-label">ZIP</label>
                        <input type="text" class="form-control" id="billing_zip" name="billing[zip]">
                    </div>
                </div>
            </div>
            <div class="form-check mb-3">
                <input type="hidden" name="same_as_billing" value="0">
                <input class="form-check-input" name="same_as_billing" type="checkbox"  value="1" id="sameAsBilling"
                    onclick="removeShippingDev(this)">
                <label class="form-check-label" for="sameAsBilling">
                    Shipping details same as billing
                </label>
            </div>
            <div class="form-section mb-4" id="shipping-div">
                <h4>Shipping Information</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="shipping_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="shipping_name" name="shipping[name]" required>
                    </div>
                    <div class="col-md-6">
                        <label for="shipping_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="shipping_email" name="shipping[email]" required>
                    </div>
                    <div class="col-md-6">
                        <label for="shipping_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="shipping_phone" name="shipping[phone]" required>
                    </div>
                    <div class="col-md-6">
                        <label for="shipping_street1" class="form-label">Street 1</label>
                        <input type="text" class="form-control" id="shipping_street1" name="shipping[street1]" required>
                    </div>
                    <div class="col-md-4">
                        <label for="shipping_city" class="form-label">City</label>
                        <input type="text" class="form-control" id="shipping_city" name="shipping[city]" required>
                    </div>
                    <div class="col-md-4">
                        <label for="shipping_state" class="form-label">State</label>
                        <input type="text" class="form-control" id="shipping_state" name="shipping[state]" required>
                    </div>
                    <div class="col-md-4">
                        <label for="shipping_country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="shipping_country" name="shipping[country]" required>
                    </div>
                    <div class="col-md-4">
                        <label for="shipping_zip" class="form-label">ZIP</label>
                        <input type="text" class="form-control" id="shipping_zip" name="shipping[zip]" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success w-100">Submit & Proceed to Payment</button>
        </form>
    </div>
</body>

</html>
