<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Payment Method</title>
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
  <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <h1 class="text-2xl font-bold mb-4">Edit Payment Method</h1>

  @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('payment_methods.update', $paymentMethod) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-4">
      <label class="block mb-2">Payment Method</label>
      <input type="text" name="name" value="{{ $paymentMethod->name }}" class="w-full p-2 border rounded" required>
    </div>
    <div class="mb-4">
      <label class="block mb-2">Account Number</label>
      <input type="text" name="account_number" value="{{ $paymentMethod->account_number }}" class="w-full p-2 border rounded" required>
    </div>
    <div class="mb-4">
      <label class="block mb-2">Account Name</label>
      <input type="text" name="account_name" value="{{ $paymentMethod->account_name }}" class="w-full p-2 border rounded" required>
    </div>
    <div class="mb-4">
      <label class="block mb-2">QR Code Image (optional)</label>
      <input type="file" name="qr_code_image" class="w-full p-2 border rounded" accept="image/*">
      @if($paymentMethod->qr_code_image)
        <div class="mt-2">
          <img src="{{ asset('storage/' . $paymentMethod->qr_code_image) }}" alt="QR Code" class="w-32 h-auto">
        </div>
      @endif
    </div>
    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Update Payment Method</button>
  </form>
</body>
</html>
