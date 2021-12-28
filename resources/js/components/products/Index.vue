<template>
  <div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Products</h1>
      <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>
    <div class="row">
      <div class="card card-mx">
        <div v-if="showMessage" class="m-2">
          <div class="alert alert-success">
            {{ message }}
            <span
              class="float-right"
              @click="showMessage = !showMessage"
              style="cursor: pointer"
              >x</span
            >
          </div>
        </div>
        <div class="class-header">
          <router-link
            :to="{ name: 'ProductCreate' }"
            class="btn btn-info btn-sm m-2 float-right"
            >Create</router-link
          >
          <button
            v-if="selectedProducts.length > 0"
            class="btn btn-danger btn-sm m-2 float-right"
            @click="bulkDelete"
          >
            Delete selected products
          </button>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">
                  <input type="checkbox" v-model="selectAllCheckbox" />
                </th>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">UPC</th>
                <th scope="col">Status</th>
                <th scope="col">Img</th>
                <th scope="col"></th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products" :key="product.id">
                <td>
                  <input
                    type="checkbox"
                    v-model="selectedProducts"
                    :value="product.id"
                  />
                </td>
                <td>{{ product.id }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.upc }}</td>
                <td>{{ product.status }}</td>
                <td>{{ product.image }}</td>
                <td>
                  <router-link
                    :to="{ name: 'ProductEdit', params: { id: product.id } }"
                    class="btn btn-info btn-sm"
                    >Edit</router-link
                  >
                </td>
                <td>
                  <button
                    class="btn btn-danger btn-sm"
                    @click="deleteProduct(product.id)"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      products: [],
      productCount: 0,
      showMessage: false,
      message: "",
      selectAllCheckbox: false,
      selectedProducts: [],
    };
  },
  created() {
    this.getProducts();
  },
  methods: {
    getProducts() {
      axios
        .get("/api/get-products")
        .then((res) => {
          this.products = res.data;
          this.productCount = res.data.length;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteProduct(id) {
      axios
        .delete("/api/product/" + id)
        .then((res) => {
          (this.showMessage = true),
            (this.message = res.data),
            this.resetData();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    bulkDelete() {
      axios
        .post("/api/delete/bulk-products", this.selectedProducts)
        .then((res) => {
          (this.showMessage = true),
            (this.message = res.data),
            this.resetData();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    resetData() {
      this.getProducts();
      this.selectedProducts = [];
    },
  },
  watch: {
    selectAllCheckbox: function (val) {
      if (!val) {
        if (this.selectedProducts.length == this.productCount) {
          this.selectedProducts = [];
        }
      } else {
        this.selectedProducts = [];
        this.products.forEach((element) => {
          this.selectedProducts.push(element.id);
        });
      }
    },
    selectedProducts: function (val) {
      if (val.length == this.productCount) {
        this.selectAllCheckbox = true;
      } else {
        this.selectAllCheckbox = false;
      }
    },
  },
};
</script>

<style>
</style>