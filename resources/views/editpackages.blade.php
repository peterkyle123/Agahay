<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
</head>
<body>
    <form action="{{ route('admin.booking-packages.update', $package->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Package Name</label>
            <input type="text" id="name" name="name" value="{{ $package->name }}" required>
        </div>

        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description" required>{{ $package->description }}</textarea>
        </div>

        <div>
            <label for="price">Price</label>
            <input type="text" id="price" name="price" value="{{ $package->price }}" required>
        </div>
        <div>
            <label for="number_of_guests">Number of Days</label>
            <input type="number" id="number_of_days" name="number_of_days" value="{{ $package->number_of_days }}" required>
        </div>
        <div>
            <label for="number_of_guests">Number of Guests</label>
            <input type="number" id="number_of_guests" name="number_of_guests" value="{{ $package->number_of_guests }}" required>
        </div>

        <div>
            <button type="submit">Update Package</button>
        </div>
    </form>
</body>
</html>
