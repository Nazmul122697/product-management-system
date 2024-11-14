<template>
  <div class="max-w-2xl mx-auto p-4">
    <form @submit.prevent="submitForm">
      <!-- Title -->
      <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input
          v-model="product.title"
          type="text"
          id="title"
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
          required
        />
      </div>

      <!-- Image -->
      <div class="mb-4">
        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
        <input
          @change="previewImage"
          type="file"
          id="image"
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
          required
        />
        <div v-if="imagePreview" class="mt-2">
          <img :src="imagePreview" class="w-32 h-32 object-cover rounded-md" alt="Image preview" />
        </div>
      </div>

      <!-- Categories -->
      <div class="mb-4">
        <label for="categories" class="block text-sm font-medium text-gray-700">Categories</label>
        <select
          v-model="selectedCategories"
          id="categories"
          multiple
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
          required
        >
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>

      <!-- Features -->
      <div class="mb-4" v-for="(feature, index) in product.features" :key="index">
        <label :for="'feature' + index" class="block text-sm font-medium text-gray-700">Feature</label>
        <input
          v-model="product.features[index]"
          :name="'features[' + index + ']'"
          :id="'feature' + index"
          type="text"
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
        />
        <button
          v-if="product.features.length > 1"
          @click.prevent="removeFeature(index)"
          class="mt-2 text-red-500 hover:text-red-700"
        >
          Remove Feature
        </button>
      </div>

      <!-- Add More Features Button -->
      <button @click.prevent="addFeature" type="button" class="text-blue-500 hover:underline mb-4">
        Add More Features
      </button>

      <!-- Submit Button -->
      <button type="submit" class="w-full px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
        Save Product
      </button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      product: {
        title: '',
        image: null, // This will store the file object
        features: [''], // Array to hold features
      },
      imagePreview: null,
      categories: [], // Categories will be populated from the API
      selectedCategories: [], // Selected categories by user
    };
  },
  mounted() {
    this.fetchCategories();
  },
  methods: {
    // Fetch categories from the API
    fetchCategories() {
      axios.get('/api/categories').then((response) => {
        this.categories = response.data;
      });
    },

    // Handle image preview
    previewImage(event) {
      const file = event.target.files[0]; // Get the first file
      if (file) {
        this.product.image = file; // Store the file object
        this.imagePreview = URL.createObjectURL(file); // Generate a preview URL
      }
    },

    // Add more features dynamically
    addFeature() {
      this.product.features.push('');
    },

    // Remove a feature
    removeFeature(index) {
      this.product.features.splice(index, 1);
    },

    // Submit form
    submitForm() {
      const formData = new FormData();
      formData.append('title', this.product.title);
      formData.append('image', this.product.image); // Append the file directly
      formData.append('categories', JSON.stringify(this.selectedCategories));
      formData.append('features', JSON.stringify(this.product.features));

      axios
        .post('/api/products', formData)
        .then((response) => {
          alert('Product created successfully!');
          this.resetForm();
        })
        .catch((error) => {
          console.error(error);
        });
    },

    // Reset the form after successful submission
    resetForm() {
      this.product.title = '';
      this.product.image = null;
      this.product.features = [''];
      this.selectedCategories = [];
      this.imagePreview = null;
    },
  },
};
</script>

<style scoped>
/* Add any specific styles you want here */
</style>
