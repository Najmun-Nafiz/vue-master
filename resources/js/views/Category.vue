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
                                <tr>
                                    <td>Donna Snider</td>
                                    <td>Customer Support</td>
                                    <td>New York</td>
                                    <td>27</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

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
                        <button type="button" class="btn btn-default" @click="hideNewCategoryModal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Save</button>
                    </div>
                </form>
            </div>
        </b-modal>
        </div>
    </div>
</template>
<script>
import * as categoryService from "../services/category_service";
export default {
  name: "category",
  data() {
    return {
      categoryData: {
        name: "",
        image: "",
      },
      categories: {},
      errors: {},
    };
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

    createCategory: async function () {
      let formData = new FormData();
      formData.append("name", this.categoryData.name);
      formData.append("image", this.categoryData.image);

      try {
        const response = await categoryService.createCategory(formData);
        if (response.data.status_code == 201) {
            this.categories = response.data.data;
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
  },

  created() {
    //
  },
};
</script>
<style lang="">
</style>