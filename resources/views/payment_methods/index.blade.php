<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Methods</title>
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
  <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-center">Payment Methods</h1>

    @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 max-w-lg mx-auto">
          {{ session('success') }}
      </div>
    @endif

    <div class="flex justify-end mb-4">
      <a href="{{ route('payment_methods.create') }}" class="bg-blue-500 text-white px-5 py-2 rounded-md shadow hover:bg-blue-600 transition">
          Add Payment Method
      </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="py-3 px-5 text-left text-sm font-medium text-gray-700">Name</th>
            <th class="py-3 px-5 text-left text-sm font-medium text-gray-700">Account Number</th>
            <th class="py-3 px-5 text-left text-sm font-medium text-gray-700">Account Name</th>
            <th class="py-3 px-5 text-left text-sm font-medium text-gray-700">Display Status</th>
            <th class="py-3 px-5 text-center text-sm font-medium text-gray-700">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach ($paymentMethods as $method)
            <tr>
              <td class="py-4 px-5 whitespace-nowrap">{{ $method->name }}</td>
              <td class="py-4 px-5 whitespace-nowrap">{{ $method->account_number }}</td>
              <td class="py-4 px-5 whitespace-nowrap">{{ $method->account_name }}</td>
              <td class="py-4 px-5 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $method->display ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                  {{ $method->display ? 'Display' : "Don't Display" }}
                </span>
              </td>
              <td class="py-4 px-5 whitespace-nowrap text-center">
                <div class="flex items-center justify-center space-x-2">
                  <a href="{{ route('payment_methods.edit', $method) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition">
                    Edit
                  </a>
                  <form action="{{ route('payment_methods.destroy', $method) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition" onclick="return confirm('Are you sure?')">
                      Delete
                    </button>
                  </form>
                  <form action="{{ route('payment_methods.toggleDisplay', $method) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition">
                      {{ $method->display ? 'Hide' : 'Display' }}
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
