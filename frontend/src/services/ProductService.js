import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api/products';

export default {
  getProducts(page = 1) {
    return axios.get(`${API_URL}?page=${page}`);
  },
  uploadFile(formData) {
    return axios.post('http://127.0.0.1:8000/api/upload', formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
  }
};
