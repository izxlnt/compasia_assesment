<script setup>
import { ref, onMounted, watch, nextTick } from "vue";
import axios from "axios";
import $ from "jquery";
import "datatables.net-bs5";
import "datatables.net-responsive-bs5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";

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
      searching: true,
      ordering: true,
      lengthMenu: [5, 10, 25, 50],
      columns: [
        { data: null, title: "No.", render: (data, type, row, meta) => meta.row + 1 },
        { data: "id", title: "Product ID" },
        { data: "type", title: "Types" },
        { data: "brand", title: "Brand" },
        { data: "model", title: "Model" },
        { data: "capacity", title: "Capacity" },
        { data: "quantity", title: "Quantity" },
      ],
      language: {
        paginate: {
          previous: '<span class="page-link">Previous</span>',
          next: '<span class="page-link">Next</span>'
        }
      }
    });
  });
};

onMounted(fetchProducts);
watch(products, initializeDataTable);
</script>

<template>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <!-- Upload Section -->
        <div class="d-flex justify-content-between align-items-center mb-3">
          <input type="file" class="form-control w-50" />
          <button class="btn btn-success"><i class="bi bi-upload"></i> Upload</button>
        </div>

        <!-- Product List -->
        <div class="card shadow p-4">
          <h3 class="text-center text-primary mb-3">Product Master List</h3>

          <!-- Search Bar -->
          <div class="d-flex justify-content-end mb-3">
            <input type="text" class="form-control w-25" placeholder="Search..." />
          </div>

          <!-- Table -->
          <div class="table-responsive">
            <table ref="table" class="table table-striped table-hover table-bordered">
              <thead class="table-dark">
                <tr>
                  <th>No.</th>
                  <th>Product ID</th>
                  <th>Types</th>
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
    </div>
  </div>
</template>

<style scoped>
.container {
  max-width: 1200px;
}

.card {
  border-radius: 12px;
  background-color: #f8f9fa;
}

.table th, .table td {
  text-align: center;
}

.table th {
  background-color: #343a40;
  color: white;
}

.page-link {
  color: #007bff;
  cursor: pointer;
}
</style>
