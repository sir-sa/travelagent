<template>
  <div class="accommodation-list">
    <h2>Accommodations</h2>
    <ul>
      <li v-for="accommodation in accommodations" :key="accommodation.id" class="accommodation-item">
        <router-link :to="{ name: 'accommodationDetails', params: { id: accommodation.id }}" class="accommodation-link">
          {{ accommodation.name }}
        </router-link>
      </li>
    </ul>
    <p v-if="error" class="error-message">{{ error }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      accommodations: [],
      error: null,
    };
  },
  mounted() {
    this.fetchAccommodations();
  },
  methods: {
    async fetchAccommodations() {
      try {
        const response = await this.$axios.get('/api/accommodations');
        this.accommodations = response.data.data;
      } catch (error) {
        this.error = 'Error fetching accommodations';
      }
    },
  },
};
</script>

<style scoped>
.accommodation-list {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}

.accommodation-item {
  list-style: none;
  margin-bottom: 10px;
}

.accommodation-link {
  text-decoration: none;
  color: #333;
  font-weight: bold;
  border: 1px solid #ccc;
  padding: 10px;
  display: block;
  transition: background-color 0.3s ease;
}

.accommodation-link:hover {
  background-color: #f0f0f0;
}

.error-message {
  color: #ff0000;
  margin-top: 10px;
}
</style>