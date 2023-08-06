<template>
  <div class="container">
    <h2>Generate Sales Payments</h2>
    <form @submit.prevent="generatePayments">
      <label for="outputFile">Payment Output File Path:</label>
      <input
        type="text"
        id="outputFile"
        v-model="outputFile"
        required
        @keyup.enter="generatePayments"
      />
      <button type="submit">Generate Payments </button>
    </form>
<br>
    <div class="console-wrapper">
      <div class="console-output" v-if="generatedData">
        <pre>{{ generatedData }}</pre>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'GeneratePayments',

  data() {
    return {
      outputFile: 'default-output.csv', // Default output file path
      generatedData: null,
    };
  },
  methods: {
    async generatePayments() {
      try {
        const response = await axios.post('http://localhost:8000/api/generate-sales-payments', {
        
          outputFile: this.outputFile});
        this.generatedData = response.data.output;
      } catch (error) {
        console.error('Error generating payments:', error);
      }
    },
  },
};
</script>

<style scoped>
.console-wrapper {
  background-color: #000;
  color: #00ff00; /* Green text */
  padding: 10px;
  font-family: monospace;
  overflow: auto;
  max-height: 400px;
  border-radius: 5px;
  text-align: left;
}

.console-output {
  background-color: #000;
  color: #00ff00; /* Green text */
  font-family: monospace;
  white-space: pre-wrap;
  word-wrap: break-word;
  overflow-x: auto;
  margin: 10px 0;
  text-align: left;
}
</style>
