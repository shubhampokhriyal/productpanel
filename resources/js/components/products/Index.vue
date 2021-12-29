<template>
  <div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Products</h1>
      <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>
    <div class="row wholeindexrow">
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
          <table class="table table-striped table-responsive">
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
                <th scope="col">Image</th>
                <th scope="col" class="actionth"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(product,index) in products" :key="product.id">
                <td>
                  <input
                    type="checkbox"
                    v-model="selectedProducts"
                    :value="product.id"
                  />
                </td>
                <td>{{ index+1 }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.upc }}</td>
                <td>{{ product.status | statusMap }}</td>
                <td>
                  <div class="col-md-6">
                    <a :href="'../storage/'+product.image" target="_blank"><img v-bind:src="'../storage/'+product.image" width="50" height="50"/></a> 
                  </div>
                </td>
                <td>
                  <router-link
                    :to="{ name: 'ProductEdit', params: { id: product.id } }"
                    class="btn btn-info btn-sm"
                    ><i class="fas fa-edit"></i></router-link
                  >
                  <button class="btn btn-danger btn-sm" @click="deleteProduct(product.id)"><i class="fas fa-trash-alt"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.actionth{
  min-width: 95px;
}
/* .wholeindexrow{
  font-size: small;
} */
</style>

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
  filters: {
    statusMap: function (value) {
      if (value==1) 
      return 'Active'
      return 'Deactive'
    }
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