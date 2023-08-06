<template>
  <div class="container">
    <form @submit.prevent="generatePayments">
      <div class="input-container">
        <input
          type="text"
          id="generateCommand"
          :value="generateCommand"
          readonly
          class="generate-command"
        />
        <input
          type="text"
          id="outputFile"
          v-model="outputFile"
          required
          @keyup.enter="generatePayments"
          class="styled-input"
          placeholder="Output File Path (e.g. csv_file directory is mandatory for this version, csv_file/OutPutPaymentDates.csv)"
        />
      </div>
     
    </form>

    <div v-if="generatedData"  class="output-container">
      <pre>{{ generatedData }}</pre>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'GeneratePayments',

  data() {
    return {
      outputFile: 'csv_file/OutPutPaymentDates.csv', // Default output file path
      generatedData: null,
    };
  },

  computed: {
    generateCommand() {
      return 'php bin/console app:generate-sales-payments';
    },
  },

  methods: {
    async generatePayments() {
      try {
        const response = await axios.post('http://localhost:8000/api/generate-sales-payments', {
  outputFile: this.outputFile,
}, {
  headers: {
    'Content-Type': 'application/json', 
  },
});
        this.generatedData = response.data.output;
      } catch (error) {
        console.error('Error generating payments:', error);
        this.generatedData = 'Error generating payments:', error;
      }
    },
  },
};
</script>

<style>
.container {
  text-align: left;
  background-color: black;
  padding: 20px;
  border-radius: 4px;
}

.input-container {
  display: flex;
  align-items: center;
}

.generate-command {
  background-color: black;
  color: white;
  border: none;
  padding: 5px 10px;
  border-radius: 4px;
  width: 500px;
  font-family: monospace;
}

.styled-input {
  background-color: black;
  color: white;
  border: none;
  padding: 5px 10px;
  border-radius: 4px;
  width: 100%;
}

.output-container {
  margin-top: 20px;
  background-color: #f0f0f0;
  padding: 10px;
  border-radius: 4px;
}
</style>
