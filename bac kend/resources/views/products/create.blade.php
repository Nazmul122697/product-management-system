<!-- resources/views/products/create.blade.php -->

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="space-y-4">
        <!-- Title Field -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required>
        </div>

        <!-- Image Field -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
            <input type="file" name="image" id="image" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" onchange="previewImage(event)" required>
            <img id="image-preview" class="mt-2 w-32 h-32 object-cover hidden" alt="Image preview">
        </div>

        <!-- Categories Selection -->
        <div>
            <label for="categories" class="block text-sm font-medium text-gray-700">Categories</label>
            <select name="categories[]" id="categories" multiple class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Features Fields (Add More Feature) -->
        <div id="features-section">
            <div class="feature">
                <label for="feature" class="block text-sm font-medium text-gray-700">Feature</label>
                <input type="text" name="features[]" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
            </div>
        </div>

        <!-- Add More Button -->
        <button type="button" id="add-feature" class="text-blue-500">Add More Features</button>

        <!-- Submit Button -->
        <button type="submit" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-md">Save Product</button>
    </div>
</form>

<script>
    function previewImage(event) {
        const preview = document.getElementById('image-preview');
        preview.src = URL.createObjectURL(event.target.files[0]);
        preview.classList.remove('hidden');
    }

    document.getElementById('add-feature').addEventListener('click', function() {
        const featureSection = document.getElementById('features-section');
        const newFeature = document.createElement('div');
        newFeature.classList.add('feature');
        newFeature.innerHTML = `
            <label for="feature" class="block text-sm font-medium text-gray-700">Feature</label>
            <input type="text" name="features[]" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
        `;
        featureSection.appendChild(newFeature);
    });
</script>
