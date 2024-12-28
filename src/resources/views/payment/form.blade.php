<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
</head>
<body>
    <h1>Make a Payment</h1>
    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <button type="submit">Proceed to Payment</button>
    </form>
</body>
</html>