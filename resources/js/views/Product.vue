<template lang="">
    <div>
        
        <div class="container-fluid">
            <h1 class="mt-4 categoryClass">Product</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Product</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    All Products List...
                    <button class="btn btn-primary btn-sm ml-auto float-right" @click="showNewProductModal">
                        <span class="fa fa-plus"></span> Create New</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            class="table table-bordered"
                            id="dataTable"
                            width="100%"
                            cellspacing="0"
                        >
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr v-for="(result, index) in products" :key="result.id" v-if='result'>
                                  
                                      <td>{{ result.id }}</td>
                                      <td>{{ result.name }}</td>
                                      <td>and</td>
                                      <td>
                                          <img :src="`${$store.state.serverPath}/storage/${result.image}`" class="img-fluid rounded" height="60" width="60" alt="">
                                      </td>
                                      <td>
                                          <a name="" id="" class="btn btn-primary" href="#" role="button" @click="editModal(result)">Edit</a>
                                          <a name="" id="" class="btn btn-danger" href="#" v-on:click="deleteModal(result)" role="button">Delete</a>
                                      </td>
                                </tr>
                            </tbody> 
                        </table>
                    </div>
                </div>
            </div>

            <!-- Create Product Modal... -->
            <b-modal ref="newProductModal" centered hide-footer title="Add New Category">
                <div class="d-block">
                    <form v-on:submit.prevent="createProduct">
                        <div class="form-group">
                            <label for="name">Enter Name</label>
                            <input type="text" v-model="productData.name" class="form-control" id="name" placeholder="Enter category name">
                            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
                        </div>
                        <div class="form-group">
                          <label for="">Select Category</label>
                          <select v-model="productData.categoryId" id="categoryId" name="categoryId" class="form-control">
                            <option selected="true">{{ selectOption }}</option>
                            <option v-for="(result, index) in categories" :key="result.id" :value="result.id">{{ result.name }}</option>
                            <div class="invalid-feedback" v-if="errors.categoryId">{{errors.categoryId[0]}}</div>
                          </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Choose an image</label>
                            <div v-if="productData.image.name">
                                <img src="" ref="newProductImageDispaly" width="180" height="80" />
                            </div>
                            <input type="file" v-on:change="attachImage" ref="newProductImage" class="form-control" id="image" />
                            <div class="invalid-feedback" v-if="errors.image">{{errors.image[0]}}</div>
                        </div>

                        <hr>
                        <div class="text-right">
                            <button type="button" class="btn btn-secondary" @click="hideNewProductModal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Save</button>
                        </div>
                    </form>
                </div>
            </b-modal>

            <!-- Update Product Modal... -->
            <b-modal ref="updateProductModal" centered hide-footer title="Update Category">
                <div class="d-block">
                    <form v-on:submit.prevent="updateProduct(productData.id)">
                        <div class="form-group">
                            <label for="name">Enter Name</label>
                            <input type="text" v-model="productData.name" class="form-control" id="name" placeholder="Enter category name">
                            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
                        </div>
                        <div class="form-group">
                          <label for="">Select Category</label>
                          <select v-model="productData.categoryId" id="categoryId" name="categoryId" class="form-control">
                            <option selected>Select One</option>
                            <option v-for="(result, index) in categories" :key="result.id" :value="result.id">{{ result.name }}</option>
                            <div class="invalid-feedback" v-if="errors.categoryId">{{errors.categoryId[0]}}</div>
                          </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Choose an image</label>
                            <div>
                                <img :src="`${$store.state.serverPath}/storage/${productData.image}`" ref="newProductImageDispaly" width="200" height="100" />
                            </div>
                            <input type="file" v-on:change="attachImage" ref="newProductImage" class="form-control" id="image" />
                            <div class="invalid-feedback" v-if="errors.image">{{errors.image[0]}}</div>
                        </div>

                        <hr>
                        <div class="text-right">
                            <button type="button" class="btn btn-secondary" @click="hideEditProductModal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Save</button>
                        </div>
                    </form>
                </div>
            </b-modal>

            <!-- Delete Modal... -->
            <b-modal class="bg-danger" id="deleteModal" ref="deleteProductModal" hide-footer hide-icon title="Delete Category">
                <div class="d-block">
                    <form v-on:submit.prevent="destroyCategory(deleteData.id)">
                        
                        <h5 class="title">Are you sure to delete {{deleteData.name}} ?</h5>
                        <hr>
                        <div class="text-right">
                            <button type="button" class="btn btn-secondary" @click="hideDeleteModal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Yes</button>
                        </div>
                    </form>
                </div>
            </b-modal>
        </div>
    </div>
</template>
<script>
import * as productService from "../services/product_service";
export default {
    name: "Product",
  data() {
    return {
      productData: {
        id: "",
        categoryId: "",
        name: "",
        image: "",
      },
      deleteData: {
        id: "",
        name: "",
      },
      products: {},
      categories: {},
      selectOption: "Select Category",
      errors: {},
    };
  },

  methods: {

        showNewProductModal() {
            this.$refs.newProductModal.show();
            this.productData = {
                name: "",
                image: "",
            };
        },
        
        hideNewProductModal() {
            this.$refs.newProductModal.hide();
        },

        editModal(result) {
            this.$refs.updateProductModal.show();
            this.productData = {
                id: result.id,
                categoryId: result.categoryId,
                name: result.name,
                image: result.image,
            };
        },

        hideEditProductModal() {
            this.$refs.updateProductModal.hide();
        },

        deleteModal(result) {
            this.$refs.deleteProductModal.show();
            this.deleteData.id = result.id;
            this.deleteData.name = result.name;
        },

        hideDeleteModal() {
            this.$refs.deleteProductModal.hide();
        },

        attachImage() {
            this.productData.image = this.$refs.newProductImage.files[0];
            let reader = new FileReader();
            reader.addEventListener("load", function () {
                this.$refs.newProductImageDispaly.src = reader.result;
                }.bind(this),
                false
            );

            reader.readAsDataURL(this.productData.image);
        },

        getProduct: async function () {
            try {
                const response = await productService.getProduct();

                if (response.data.status_code == 201) {
                    this.products = response.data.data.data;
                }
            } catch (error) {
                console.log(error);
                this.$snotify.error(error.response.data.message);
            }
        },
        
        allCategory: async function () {
            try {
                const response = await productService.allCategory();

                if (response.data.status_code == 201) {
                    this.categories = response.data.data;
                    console.log('Category: '+response.data.data);
                }
            } catch (error) {
                this.$snotify.error(error.response.data.message);
            }
        },

        createProduct: async function () {
            let formData = new FormData();
            formData.append("categoryId", this.productData.categoryId);
            formData.append("name", this.productData.name);
            formData.append("image", this.productData.image);
            formData.append("status", 1);

            try {
                const response = await productService.createProduct(formData);
                if (response.data.status_code == 201) {
                    this.products.unshift(response.data.data);
                    this.productData = {
                        categoryId: "",
                        name: "",
                        image: "",
                    };
                    this.$snotify.success(response.data.message);
                    this.hideNewProductModal();
                }
            } catch (error) {
                switch (error.response.status) {
                case 422:
                    this.errors = error.response.data.errors;
                    this.$snotify.error(error.response.data.message);
                    break;
                default:
                    this.$snotify.error(error.response.data.message);
                    break;
                }
            }
        },

        updateProduct: async function (id) {
            try {
                const formData = new FormData();
                formData.append("categoryId", this.productData.categoryId);
                formData.append("name", this.productData.name);
                formData.append("image", this.productData.image);
                formData.append("status", 1);
                formData.append('_method', 'put');

                const response = await productService.updateProduct(id, formData);
                if (response.data.status_code == 201) {
                    this.getProduct();
                    this.productData = {
                        categoryId: "",
                        name: "",
                        image: "",
                    };
                    this.$snotify.success(response.data.message);
                    this.hideEditProductModal();
                }

            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                        this.$snotify.error(error.response.data.message);
                    break;
                    default:
                        this.$snotify.error(error.response.data.message);
                    break;
                }
            }
        },

        destroyCategory: async function (id) {
            try {
                const response = await productService.destroyProduct(id);
                if (response.data.status_code == 201) {
                this.getProduct();
                this.hideDeleteModal();
                this.$snotify.success(response.data.message);
                }
            } catch (error) {
                this.$snotify.error(error.response.data.message);
            }
        },
  },

  created() {
      this.getProduct();
      this.allCategory();
  },
}
</script>
<style>
    
</style>