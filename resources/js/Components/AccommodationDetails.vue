<template>
    <div class="accommodation-details">
      <h2>{{ accommodation.name }}</h2>
      <p class="description">{{ accommodation.description }}</p>
      <p class="price">Price: {{ accommodation.price_per_night }}</p>
      <!-- Add more details as needed -->
      <p v-if="error" class="error-message">{{ error }}</p>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        accommodation: {},
        error: null,
      };
    },
    mounted() {
      this.fetchAccommodationDetails();
    },
    methods: {
      async fetchAccommodationDetails() {
        try {
          const response = await this.$axios.get(`/api/accommodations/${this.$route.params.id}`);
          this.accommodation = response.data.data;
        } catch (error) {
          this.error = 'Error fetching accommodation details';
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .accommodation-details {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
  }
  
  .description {
    font-style: italic;
    color: #555;
  }
  
  .price {
    font-weight: bold;
    color: #008000;
  }
  
  .error-message {
    color: #ff0000;
    margin-top: 10px;
  }
  </style>