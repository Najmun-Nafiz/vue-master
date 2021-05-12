<template lang="">
    <div>
        <div class="container-fluid">
            <h1 class="mt-4 categoryClass">Category</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Category</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    All Category List...
                    <button class="btn btn-primary btn-sm ml-auto float-right" @click="showNewCategoryModal">
                        <span class="fa fa-plus"></span> Create New</button>
                </div>
                  <div class="row mt-2 mb-4">
                    <div class="col-md-3 position-absolute m-0 p-0" style="right:20px;">
                      <input v-model="query" type="text" class="form-control float-right" placeholder="Search">
                    </div>
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
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr v-for="(result, index) in categories" :key="result.id" v-if='result'>
                                  
                                      <td>{{ result.id }}</td>
                                      <td>{{ result.name }}</td>
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

                        <Pagination v-if="pagination.last_page > 1" 
                                
                                :pagination="pagination"
                                :offset="5"
                                @paginate="query === '' ? getCategory() : searchData()"
                                
                            ></Pagination>

                    </div>
                </div>
            </div>

            <!-- Create Category Modal... -->
            <b-modal ref="newCategoryModal" centered hide-footer title="Add New Category">
                <div class="d-block">
                    <form v-on:submit.prevent="createCategory">
                        <div class="form-group">
                            <label for="name">Enter Name</label>
                            <input type="text" v-model="categoryData.name" class="form-control" id="name" placeholder="Enter category name">
                            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
                        </div>
                        <div class="form-group">
                            <label for="image">Choose an image</label>
                            <div v-if="categoryData.image.name">
                                <img src="" ref="newCategoryImageDispaly" width="150" height="200" />
                            </div>
                            <input type="file" v-on:change="attachImage" ref="newCategoryImage" class="form-control" id="image" />
                            <div class="invalid-feedback" v-if="errors.image">{{errors.image[0]}}</div>
                        </div>

                        <hr>
                        <div class="text-right">
                            <button type="button" class="btn btn-secondary" @click="hideNewCategoryModal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Save</button>
                        </div>
                    </form>
                </div>
            </b-modal>
            
            <!-- Update Category Modal... -->
            <b-modal ref="updateCategoryModal" centered hide-footer title="Update Category">
                <div class="d-block">
                    <form v-on:submit.prevent="updateCategory(categoryData.id)">
                        <div class="form-group">
                            <label for="name">Enter Name</label>
                            <input type="text" v-model="categoryData.name" class="form-control" id="name" placeholder="Enter category name">
                            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
                        </div>
                        <div class="form-group">
                            <label for="image">Choose an image</label>
                            <div>
                                <img :src="`${$store.state.serverPath}/storage/${categoryData.image}`" ref="newCategoryImageDispaly" width="200" height="100" />
                            </div>
                            <input type="file" v-on:change="attachImage" ref="newCategoryImage" class="form-control" id="image" />
                            <div class="invalid-feedback" v-if="errors.image">{{errors.image[0]}}</div>
                        </div>

                        <hr>
                        <div class="text-right">
                            <button type="button" class="btn btn-secondary" @click="hideEditCategoryModal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Save</button>
                        </div>
                    </form>
                </div>
            </b-modal>

            <!-- Delete Modal... -->
            <b-modal class="bg-danger" id="deleteModal" ref="deleteCategoryModal" hide-footer hide-icon title="Delete Category">
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
import Pagination from './partials/Pagination';
import * as categoryService from "../services/category_service";
export default {
  name: "category",
  data() {
    return {
      categoryData: {
        id: "",
        name: "",
        image: "",
      },
      deleteData: {
        id: "",
        name: "",
      },
      categories: {},
      errors: {},

      query: "",
      queryField: "name",
      pagination: {
        current_page: 1,
      },
    };
  },

  components: {
        Pagination
    },

  watch: {
    query: function (newQ, old) {
      if (newQ === "") {
        this.getCategory();
      } else {
        this.searchData();
      }
    },
  },

  methods: {
    hideNewCategoryModal() {
      this.$refs.newCategoryModal.hide();
    },

    showNewCategoryModal() {
      this.$refs.newCategoryModal.show();
      this.categoryData = {
        name: "",
        image: "",
      };
    },

    editModal(result) {
      this.$refs.updateCategoryModal.show();
      this.categoryData = {
        id: result.id,
        name: result.name,
        image: result.image,
      };
    },

    hideEditCategoryModal() {
      this.$refs.updateCategoryModal.hide();
    },

    deleteModal(result) {
      this.$refs.deleteCategoryModal.show();
      this.deleteData.id = result.id;
      this.deleteData.name = result.name;
    },

    hideDeleteModal() {
      this.$refs.deleteCategoryModal.hide();
    },

    attachImage() {
      this.categoryData.image = this.$refs.newCategoryImage.files[0];
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.$refs.newCategoryImageDispaly.src = reader.result;
        }.bind(this),
        false
      );

      reader.readAsDataURL(this.categoryData.image);
    },

    getCategory: async function () {
      try {
        var page = this.pagination.current_page;
        const response = await categoryService.getCategory(page);

        if (response.data.status_code == 201) {
          this.categories = response.data.data.data;
          this.pagination=response.data.data;
          console.log("Category: " + response.data.data.data);
        }
      } catch (error) {
        console.log(error);
        // this.$snotify.error(error.response.data.message);
      }
    },

    createCategory: async function () {
      let formData = new FormData();
      formData.append("name", this.categoryData.name);
      formData.append("image", this.categoryData.image);

      try {
        const response = await categoryService.createCategory(formData);
        if (response.data.status_code == 201) {
          this.categories.unshift(response.data.data);
          this.categoryData = {
            name: "",
            image: "",
          };
          this.$snotify.success(response.data.message);
          this.hideNewCategoryModal();
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

    updateCategory: async function (id) {
      try {
        const formData = new FormData();
        formData.append("name", this.categoryData.name);
        formData.append("image", this.categoryData.image);
        formData.append("_method", "put");

        const response = await categoryService.updateCategory(id, formData);
        if (response.data.status_code == 201) {
          this.getCategory();
          this.categoryData = {
            name: "",
            image: "",
          };
          this.$snotify.success(response.data.message);
          this.hideEditCategoryModal();
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
        const response = await categoryService.destroyCategory(id);
        if (response.data.status_code == 201) {
          this.getCategory();
          this.hideDeleteModal();
          this.$snotify.success(response.data.message);
        }
      } catch (error) {
        this.$snotify.error(error.response.data.message);
      }
    },

    searchData: async function() {

        try {
          var queryField = this.queryField;
          var query = this.query;
          var page = this.pagination.current_page;
          const response = await categoryService.searchCategory(queryField, query, page);
          if (response.data.status_code == 201) {
            this.categories = response.data.data.data;
            this.pagination = response.data.data;
          }
        } catch (error) {
          this.$snotify.error(error.response.data.message);
        }
    },
  },

  created() {
    this.getCategory();
    this.$store.dispatch("isCategory", true);
  },
};
</script>
<style>
</style>