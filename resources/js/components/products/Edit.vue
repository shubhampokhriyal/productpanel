<template>
  <div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
    </div>
    <div class="row">
      <div class="card col-lg-10">
        <div class="class-header">
          <router-link :to="{ name: 'ProductIndex' }" class="m-3 float-right"
            >Back</router-link
          >
        </div>
        <div class="card-body">
          <form @submit.prevent="updateProduct">
            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end"
                >Name</label
              >

              <div class="col-md-6">
                <input
                  v-model="form.name"
                  id="name"
                  type="text"
                  class="form-control"
                  autocomplete="name"
                  autofocus
                />
              </div>
            </div>
            <div class="row mb-3">
              <label for="price" class="col-md-4 col-form-label text-md-end"
                >Price</label
              >

              <div class="col-md-6">
                <input
                  v-model="form.price"
                  id="price"
                  type="number"
                  min="0"
                  class="form-control"
                  autocomplete="price"
                  autofocus
                />
              </div>
            </div>
            <div class="row mb-3">
              <label for="upc" class="col-md-4 col-form-label text-md-end"
                >UPC</label
              >

              <div class="col-md-6">
                <input
                  v-model="form.upc"
                  id="upc"
                  type="text"
                  class="form-control"
                  autocomplete="upc"
                  autofocus
                />
              </div>
            </div>
            <div class="row mb-3">
              <label for="status" class="col-md-4 col-form-label text-md-end"
                >Status</label
              >

              <div class="col-md-6">
                <input
                  v-model="form.status"
                  id="status"
                  type="text"
                  class="form-control"
                  autocomplete="status"
                  autofocus
                />
              </div>
            </div>
            <div class="row mb-3">
              <label for="image" class="col-md-4 col-form-label text-md-end"
                >Image</label
              >

              <div class="col-md-6">
                <input
                  v-model="form.image"
                  id="image"
                  type="text"
                  class="form-control"
                  autocomplete="image"
                  autofocus
                />
              </div>
            </div>

            <div class="row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: "",
        price: 0,
        upc: "",
        status: "",
        image: "",
      },
    };
  },
  created() {
    this.getProduct();
  },
  methods: {
    getProduct() {
      axios.get("/api/product/" + this.$route.params.id).then((res) => {
        this.form = res.data;
      });
    },
    updateProduct() {
      axios
        .put("/api/product/" + this.$route.params.id, this.form)
        .then((res) => {
          this.$router.push({ name: "ProductIndex" });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style>
</style>