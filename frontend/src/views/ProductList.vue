<script setup>
import { ref, onMounted, nextTick } from "vue";
import axios from "axios";
import $ from "jquery";
import "datatables.net-bs5";
import "datatables.net-responsive-bs5";
import "datatables.net-dt/css/dataTables.dataTables.min.css";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-icons/font/bootstrap-icons.css";

const products = ref([]);
const table = ref(null);
let dataTableInstance = null;

const fetchProducts = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/products");
    products.value = response.data.data;
    await nextTick();
    initializeDataTable();
  } catch (error) {
    console.error("Error fetching products:", error);
  }
};

const initializeDataTable = () => {
  if (dataTableInstance) {
    dataTableInstance.destroy(); // Destroy previous instance to prevent duplication
  }

  dataTableInstance = $(table.value).DataTable({
    responsive: true,
    autoWidth: false,
    paging: true,
    searching: false, // Custom search handled
    ordering: true,
    lengthMenu: [10, 25, 50, 100],
    data: products.value, // Use Vue's data array
    columns: [
      { data: null, title: "No.", render: (data, type, row, meta) => meta.row + 1 },
      { data: "id", title: "Product ID" },
      { data: "type", title: "Type" },
      { data: "brand", title: "Brand" },
      { data: "model", title: "Model" },
      { data: "capacity", title: "Capacity" },
      { data: "quantity", title: "Quantity" },
    ],
  });
};

const searchProduct = async (event) => {
  const query = event.target.value.trim();
  try {
    const response = await axios.get(`http://localhost:8000/api/products?search=${query}`);
    products.value = response.data.data;

    if (dataTableInstance) {
      dataTableInstance.clear().rows.add(products.value).draw();
    }
  } catch (error) {
    console.error("Error searching products:", error);
  }
};

const file = ref(null);
const uploadFile = async () => {
  if (!file.value) {
    alert("Please select a file!");
    return;
  }

  const formData = new FormData();
  formData.append("file", file.value);

  try {
    const response = await axios.post("http://localhost:8000/api/upload", formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });

    alert(response.data.message);
    fetchProducts(); // Reload data after upload
  } catch (error) {
    console.error("Error uploading file:", error);
    alert("File upload failed!");
  }
};

onMounted(fetchProducts);
</script>

<template>
  <div class="container mt-4">
    <!-- Upload Section -->
    <div class="mb-3 d-flex align-items-center">
      <label class="form-label me-2">Upload Excel File</label>
      <input type="file" class="form-control flex-grow-1 me-2" @change="(e) => (file = e.target.files[0])" />
      <button class="btn btn-primary px-4" @click="uploadFile">Upload</button>
    </div>

    <!-- Search Bar -->
    <div class="input-group mb-3">
      <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
      <input type="text" class="form-control border-primary" placeholder="Search by Product ID..." @input="searchProduct" />
    </div>

    <!-- Table -->
    <div class="card shadow-sm p-4">
      <div class="table-responsive">
        <table ref="table" class="table table-striped table-hover table-bordered">
          <thead class="table-dark">
            <tr>
              <th>No.</th>
              <th>Product ID</th>
              <th>Type</th>
              <th>Brand</th>
              <th>Model</th>
              <th>Capacity</th>
              <th>Quantity</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  max-width: 1100px;
}

.card {
  border-radius: 12px;
  background-color: #ffffff;
}

.table th,
.table td {
  text-align: center;
}

.table th {
  background-color: #343a40;
  color: white;
}

.input-group-text {
  border-top-left-radius: 8px;
  border-bottom-left-radius: 8px;
}

.form-control {
  border-top-right-radius: 8px;
  border-bottom-right-radius: 8px;
}
</style>
