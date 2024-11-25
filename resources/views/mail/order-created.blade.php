<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="max-w-2xl mx-auto p-8 bg-white my-8 rounded-lg shadow-sm">
        <!-- Logo Placeholder -->
        <div class="flex justify-center mb-8">
            <div class="w-12 h-12 bg-orange-500 rotate-45"></div>
        </div>

        <!-- Main Content -->
        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            Hi! {{ $firstName }} {{ $lastName }}. Thanks for your order.
        </h1>

        <p class="text-gray-600 mb-6">
            This email is a receipt for your order ID #{{ $orderNumber }}. You do not need to make any further payment in relation to this order.
        </p>

        <div class="mb-6">
            <p class="font-semibold text-gray-800">Order ID #{{ $orderNumber }}</p>
            <p class="text-blue-600">Status: {{ $status }}</p>
        </div>

        <!-- Order Items -->
        <div class="border-t border-gray-200 py-4 mb-6">
            <table class="w-full">
                <thead>
                    <tr class="text-left">
                        <th class="pb-4 text-gray-600">Item</th>
                        <th class="pb-4 text-gray-600 text-right">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td class="py-2 text-gray-800">{{ $item['name'] }}</td>
                        <td class="py-2 text-gray-800 text-right">{{ Number::currency($item['unit_amount'], 'IDR') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Action Button -->
        <div class="mb-8">
            <a href="{{ $orderUrl }}" 
               class="inline-block bg-blue-500 text-white px-6 py-3 rounded-md font-semibold hover:bg-blue-600 transition-colors">
                VIEW ORDER DETAILS
            </a>
        </div>

        <!-- Footer Information -->
        <div class="border-t border-gray-200 pt-6 text-gray-600 text-sm">
            <p class="mb-4">
                Want a full VAT invoice for your records? 
                <a href="{{ $invoiceUrl }}" class="text-blue-600 hover:underline">Download PDF invoice</a>
            </p>

            <p>
                This order will appear as "{{ $companyName }}" on your statement from your payment provider. 
                <a href="{{ $updateUrl }}" class="text-blue-600 hover:underline">Click here</a> 
                to update your delivery or payment details.
            </p>
        </div>
    </div>
</body>
</html>