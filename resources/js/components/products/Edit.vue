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
                <select id="status" v-model="form.status" class="form-control">
                  <option value="1">Active</option>
                  <option value="0">Deactive</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <label for="image" class="col-md-4 col-form-label text-md-end"
                >Image</label
              >

              <div class="col-md-6">
                <input type="file" id="image" class="form-control-file" @change="onFileChange">
              </div>
              <div class="col-md-6">
                <img v-bind:src="imagePreview" width="100" height="100" v-show="showPreview"/> 
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
      imagePreview: null,
      showPreview: false,
    };
  },
  created() {
    this.getProduct();
  },
  methods: {
    getProduct() {
      axios.get("/api/product/" + this.$route.params.id).then((res) => {
        this.form = res.data;
        this.imagePreview = '../storage/'+res.data.image
        this.showPreview= true
      });
    },
    updateProduct() {
      let formData = new FormData()
      formData.append("name", this.form.name);
      formData.append("price", this.form.price);
      formData.append("upc", this.form.upc);
      formData.append("status", this.form.status);
      formData.append("image", this.form.image);
      axios
        .post("/api/product/" + this.$route.params.id, formData)
        .then((res) => {
          this.$router.push({ name: "ProductIndex" });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    onFileChange(event){
      /*
      Set the local file variable to what the user has selected.
      */
      this.form.image = event.target.files[0];

      /*
      Initialize a File Reader object
      */
      let reader  = new FileReader();

      /*
      Add an event listener to the reader that when the file
      has been loaded, we flag the show preview as true and set the
      image to be what was read from the reader.
      */
      reader.addEventListener("load", function () {
          this.showPreview = true;
          this.imagePreview = reader.result;
      }.bind(this), false);

      /*
      Check to see if the file is not empty.
      */
      if( this.form.image ){
          /*
              Ensure the file is an image file.
          */
          if ( /\.(jpe?g|png|gif|webp)$/i.test( this.form.image.name ) ) {

              console.log("here");
              /*
              Fire the readAsDataURL method which will read the file in and
              upon completion fire a 'load' event which we will listen to and
              display the image in the preview.
              */
              reader.readAsDataURL( this.form.image );
          }
      }
      else{
        this.showPreview = false;

      }
    }
  },
};
</script>

<style>
</style>