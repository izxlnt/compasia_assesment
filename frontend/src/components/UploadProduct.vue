<script setup>
import { ref } from "vue";
import axios from "axios";

const file = ref(null);
const message = ref("");

const handleFileChange = (event) => {
  file.value = event.target.files[0];
};

const uploadProduct = async () => {
  if (!file.value) {
    message.value = "Please select a file!";
    return;
  }

  const formData = new FormData();
  formData.append("file", file.value);

  try {
    const response = await axios.post("http://localhost:8000/api/upload", formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });
    message.value = "Upload successful!";
  } catch (error) {
    message.value = "Upload failed!";
    console.error(error);
  }
};
</script>

<template>
  <div>
    <h2>Upload Product</h2>
    <p v-if="message">{{ message }}</p>
    <input type="file" @change="handleFileChange" class="form-control" />
    <button @click="uploadProduct" class="btn btn-primary">Upload</button>
  </div>
</template>

<style scoped>
.form-control {
  margin-bottom: 10px;
}
</style>
