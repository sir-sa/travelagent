<template>
    <div class="booking-form">
      <h2>Booking Form</h2>
      <form @submit.prevent="submitBooking" class="form">
        <label for="bookingDate">Booking Date:</label>
        <input type="date" v-model="bookingDate" required class="form-input">
  
        <label for="guestName">Guest Name:</label>
        <input type="text" v-model="guestName" required class="form-input">
  
        <label for="guestEmail">Guest Email:</label>
        <input type="email" v-model="guestEmail" required class="form-input">
  
        <!-- Add more input fields for booking details -->
  
        <button type="submit" class="form-button">Submit Booking</button>
      </form>
      <p v-if="error" class="error-message">{{ error }}</p>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        bookingDate: '',
        guestName: '',
        guestEmail: '',
        // Add more data properties for booking details
  
        error: null,
      };
    },
    methods: {
      async submitBooking() {
        try {
          const response = await this.$axios.post('/api/contracts/1/bookings', {
            booking_date: this.bookingDate,
            guest_name: this.guestName,
            guest_email: this.guestEmail,
            // Add more properties for booking details
          });
  
          console.log(response.data);
  
          // Reset form fields
          this.bookingDate = '';
          this.guestName = '';
          this.guestEmail = '';
          // Reset other booking details properties
  
          this.error = null;
        } catch (error) {
          this.error = 'Error submitting booking';
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .booking-form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
  }
  
  .form {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
  }
  
  .form-label {
    font-weight: bold;
  }
  
  .form-input {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
  }
  
  .form-button {
    background-color: #007bff;
    color: #fff;
    padding: 10px;
    border: none;
    cursor: pointer;
  }
  
  .form-button:hover {
    background-color: #0056b3;
  }
  
  .error-message {
    color: #ff0000;
    margin-top: 10px;
  }
  </style>