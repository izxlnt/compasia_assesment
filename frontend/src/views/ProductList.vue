<script setup>
import { ref, onMounted, watch, nextTick } from "vue";
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

    await nextTick(); // Ensure DOM updates before initializing DataTable
    initializeDataTable();
  } catch (error) {
    console.error("Error fetching products:", error);
  }
};

const initializeDataTable = () => {
  nextTick(() => {
    if (dataTableInstance) {
      dataTableInstance.destroy(); // Destroy the old instance before reinitializing
    }

    dataTableInstance = $(table.value).DataTable({
      responsive: true,
      autoWidth: false,
      paging: true,
      searching: false, // Search handled manually
      ordering: true,
      lengthMenu: [10, 25, 50, 100],
      columns: [
        { data: null, title: "No.", render: (data, type, row, meta) => meta.row + 1 }, // Auto-numbering
        { data: "id", title: "Product ID" },
        { data: "type", title: "Type" },
        { data: "brand", title: "Brand" },
        { data: "model", title: "Model" },
        { data: "capacity", title: "Capacity" },
        { data: "quantity", title: "Quantity" },
      ],
    });
  });
};

const searchProduct = async (event) => {
  const query = event.target.value.trim();

  try {
    const response = await axios.get(`http://localhost:8000/api/products?search=${query}`);
    products.value = response.data.data; // Vue reactivity updates the table

    // Update DataTable dynamically
    if (dataTableInstance) {
      dataTableInstance.clear().rows.add(products.value).draw();
    }
  } catch (error) {
    console.error("Error searching products:", error);
  }
};

onMounted(fetchProducts);
watch(products, initializeDataTable);
</script>

<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="text-primary">Product Master List</h2>
    </div>

    <!-- Search Bar -->
    <div class="input-group mb-3">
      <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
      <input
        type="text"
        class="form-control border-primary"
        placeholder="Search by Product ID..."
        @input="searchProduct"
      />
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
          <tbody>
            <tr v-for="(product, index) in products" :key="product.id">
              <td class="text-center">{{ index + 1 }}</td>
              <td>{{ product.id }}</td>
              <td>{{ product.type }}</td>
              <td>{{ product.brand }}</td>
              <td>{{ product.model }}</td>
              <td>{{ product.capacity }}</td>
              <td class="text-center">{{ product.quantity }}</td>
            </tr>
          </tbody>
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

.table th, .table td {
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
