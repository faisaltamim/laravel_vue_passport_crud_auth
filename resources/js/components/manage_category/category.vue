<template>
    <div>
        <div id="categoryComponent" class="pt-5 px-4">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 mb-5">
                    <div class="card dataTableCard">
                        <div class="card-header" style="background: #1b262d">
                            <h3
                                class="d-inline-block card-title text-light mt-3"
                                style="font-size: 25px"
                            >
                                Category Management
                            </h3>
                            <b-button
                                v-b-modal.modal-1
                                style="margin-top: 12px"
                                class="float-right btn addbtn CustomBootsrpVueBtn"
                            >
                                <i class="fas fa-plus-circle mr-2"></i>
                                Add Category
                            </b-button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="background: #22313a">
                            <div
                                id="example1_wrapper"
                                class="dataTables_wrapper dt-bootstrap4"
                            >
                                <table
                                    id=""
                                    class="table table-bordered table-striped dtr-inline"
                                    role="grid"
                                    aria-describedby="example1_info"
                                >
                                    <thead>
                                        <tr role="row">
                                            <th
                                                class="sorting_asc"
                                                tabindex="0"
                                                aria-controls="example1"
                                                rowspan="1"
                                                colspan="1"
                                                aria-sort="ascending"
                                                aria-label="Rendering engine: activate to sort column descending"
                                            >
                                                SL
                                            </th>
                                            <th
                                                class="sorting"
                                                tabindex="0"
                                                aria-controls="example1"
                                                rowspan="1"
                                                colspan="1"
                                                aria-label="Browser: activate to sort column ascending"
                                            >
                                                Name
                                            </th>
                                            <th
                                                class="sorting"
                                                tabindex="0"
                                                aria-controls="example1"
                                                rowspan="1"
                                                colspan="1"
                                                aria-label="Browser: activate to sort column ascending"
                                            >
                                                Image
                                            </th>
                                            <th
                                                class="sorting"
                                                tabindex="0"
                                                aria-controls="example1"
                                                rowspan="1"
                                                colspan="1"
                                                aria-label="Browser: activate to sort column ascending"
                                            >
                                                Status
                                            </th>
                                            <th
                                                class="sorting"
                                                tabindex="0"
                                                aria-controls="example1"
                                                rowspan="1"
                                                colspan="1"
                                                aria-label="CSS grade: activate to sort column ascending"
                                            >
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(category,
                                            index) in getCategories"
                                            :key="index"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td style="word-break: break-word;">
                                                {{
                                                    category.name
                                                        | CapitalizeLetter
                                                }}
                                            </td>
                                            <td>
                                                <img
                                                    v-if="category.image != ''"
                                                    style="width: 60px; height: 40px; border-radius: 50px"
                                                    class="img img-fluid"
                                                    :src="
                                                        'storage/category_images/' +
                                                            category.image
                                                    "
                                                    :alt="category.name"
                                                />
                                                <span v-else>N/A</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="statusActiveInactive"
                                                    v-if="
                                                        category.status === '1'
                                                    "
                                                    >Active</span
                                                >
                                                <span
                                                    v-else
                                                    class="statusActiveInactive bg-danger"
                                                    >Inactive</span
                                                >
                                            </td>
                                            <td>
                                                <button
                                                    style="color: #ffffff !important; background: #008cff"
                                                    class="btn btn-sm"
                                                    @click="editCat(category)"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button
                                                    @click="
                                                        deleteCat(category.id)
                                                    "
                                                    style="color: #ffffff !important"
                                                    class="btn btn-sm btn-danger mySweetAlertDeleteWithoutPost"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <tr
                                            v-if="
                                                this.$store.state.loading === 0
                                            "
                                        >
                                            <td colspan="5">
                                                <h2 class="text-center">
                                                    <img
                                                        style="width: 35px; margin-top: -5px"
                                                        class="img img-fluid"
                                                        src="site/site_reusable_images/loader/loader4.gif"
                                                        alt=""
                                                    />
                                                    Please wait ....
                                                </h2>
                                            </td>
                                        </tr>
                                        <tr
                                            v-if="
                                                getCategories.length === 0 &&
                                                    this.$store.state.loading !=
                                                        0
                                            "
                                        >
                                            <td colspan="5">
                                                <h2 class="text-center">
                                                    Data Not Found
                                                </h2>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>

        <!-- create category modal start -->
        <!-- ei b-modal use korte hole age bootstrap-vue er documentation e giye bootstrap vue install kore nite hobe -->
        <b-modal
            ref="newCategoryModal"
            id="modal-1"
            hide-footer
            @hidden="ifModalHide"
            title="Add New Category"
        >
            <form
                @submit.prevent="addCategory"
                enctype="multipart/form-data"
                method="POST"
                action="./api/post"
                ref="resetForm"
            >
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input
                            :class="{ borderError: errors.name != null }"
                            class="form-control"
                            type="text"
                            name="name"
                            :disabled="addCategoryForm.lodingBeforeSubmit != ''"
                            id="name"
                            placeholder="Category Name"
                            v-model="addCategoryForm.name"
                        />
                        <strong class="text-danger" v-if="errors.name">{{
                            errors.name[0]
                        }}</strong>
                    </div>

                    <div class="form-group">
                        <div class="imageWithpreview">
                            <label for="image">Category Image</label>
                            <div>
                                <input
                                    :class="{
                                        borderError: errors.image != null
                                    }"
                                    class="form-control"
                                    :disabled="
                                        addCategoryForm.lodingBeforeSubmit != ''
                                    "
                                    ref="imgFile"
                                    type="file"
                                    name="image"
                                    @change="selectedImage($event)"
                                    id="image"
                                    placeholder="Category Image"
                                />
                            </div>
                            <div
                                v-if="addCategoryForm.preview_image != ''"
                                class="text-center py-2"
                                :class="{ borderError: errors.image != null }"
                                style="background: #1b262d"
                            >
                                <img
                                    style="width: 90px; height: 90px; border-radius: 50px"
                                    class="img img-fluid"
                                    :src="addCategoryForm.preview_image"
                                    alt="Preview Image"
                                    id="previewImg"
                                />
                            </div>
                        </div>

                        <strong
                            class="text-danger d-block"
                            v-if="errors.image"
                            >{{ errors.image[0] }}</strong
                        >
                    </div>

                    <div class="form-group">
                        <strong style="cursor: pointer">Category Status</strong>
                        <div
                            :class="{ borderError: errors.status != null }"
                            style="background: #1b262d"
                            class="mt-2"
                        >
                            <label for="catStatusActive" class="mt-2 ml-3">
                                <input
                                    class=""
                                    type="radio"
                                    name="status"
                                    :disabled="
                                        addCategoryForm.lodingBeforeSubmit != ''
                                    "
                                    id="catStatusActive"
                                    value="1"
                                    v-model="addCategoryForm.status"
                                />
                                Active</label
                            >
                            <label for="catStatusInactive" class="mt-2 ml-3">
                                <input
                                    class=""
                                    :disabled="
                                        addCategoryForm.lodingBeforeSubmit != ''
                                    "
                                    type="radio"
                                    name="status"
                                    id="catStatusInactive"
                                    value="0"
                                    v-model="addCategoryForm.status"
                                />
                                Inactive</label
                            >
                        </div>
                        <strong class="text-danger" v-if="errors.status">{{
                            errors.status[0]
                        }}</strong>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button
                        :disabled="addCategoryForm.lodingBeforeSubmit != ''"
                        type="button"
                        class="btn btn-sm btn-danger"
                        @click="hideAddCatModal"
                    >
                        Close
                    </button>

                    <button
                        type="submit"
                        :disabled="addCategoryForm.lodingBeforeSubmit != ''"
                        class="btn btn-sm btn-success"
                    >
                        <span v-if="addCategoryForm.lodingBeforeSubmit === ''"
                            >Save Category</span
                        >
                        <span v-if="addCategoryForm.lodingBeforeSubmit != ''"
                            >Saving
                            <img
                                style="width: 15px; margin-top: -3px"
                                class="img img-fluid"
                                src="site/site_reusable_images/loader/loader4.gif"
                                alt=""
                        /></span>
                    </button>
                </div>
            </form>
        </b-modal>
        <!-- create category modal end -->

        <!-- edit category modal start -->
        <b-modal
            ref="editCategoryModal"
            id="modal-2"
            hide-footer
            @hidden="ifEditModalHide"
            title="Edit Category"
        >
            <form
                @submit.prevent="updateCategory"
                enctype="multipart/form-data"
                method="POST"
                action="./api/post"
                ref="resetForm"
            >
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input
                            class="form-control"
                            type="text"
                            name="name"
                            id="name"
                            placeholder="Category Name"
                            v-model="editCategroy.name"
                        />
                        <!-- error message -->
                    </div>

                    <div class="form-group">
                        <div class="imageWithpreview">
                            <label for="image">Category Image</label>
                            <div>
                                <input
                                    class="form-control"
                                    ref="editImgFile"
                                    type="file"
                                    name="image"
                                    @change="selectedEditImage($event)"
                                    id="image"
                                    placeholder="Category Image"
                                />
                            </div>
                            <div
                                class="text-center py-2"
                                style="background: #1b262d"
                            >
                                <img
                                    style="width: 90px; height: 90px; border-radius: 50px"
                                    class="img img-fluid"
                                    :src="editCategroy.preview_image"
                                    alt="Preview Image"
                                    id="previewImg"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <strong style="cursor: pointer">Category Status</strong>
                        <div style="background: #1b262d" class="mt-2">
                            <label for="catStatusActive" class="mt-2 ml-3">
                                <input
                                    class=""
                                    type="radio"
                                    name="status"
                                    id="catStatusActive"
                                    value="1"
                                    v-model="editCategroy.status"
                                />
                                Active</label
                            >
                            <label for="catStatusInactive" class="mt-2 ml-3">
                                <input
                                    class=""
                                    type="radio"
                                    name="status"
                                    id="catStatusInactive"
                                    value="0"
                                    v-model="editCategroy.status"
                                />
                                Inactive</label
                            >
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button
                        type="button"
                        class="btn btn-sm btn-danger"
                        @click="hideEditCatModal"
                    >
                        Close
                    </button>

                    <button type="submit" class="btn btn-sm btn-success">
                        <span>Update Category</span>
                        <!-- <span v-if="addCategoryForm.lodingBeforeSubmit != ''"
              >Saving
              <img
                style="width: 15px; margin-top: -3px"
                class="img img-fluid"
                src="site/site_reusable_images/loader/loader4.gif"
                alt=""
            /></span> -->
                    </button>
                </div>
            </form>
        </b-modal>
        <!-- edit category modal end -->
    </div>
</template>

<script>
export default {
    name: "category",
    mounted() {
        this.$store.dispatch("appsCategories");
        // uporer vuex er function ta mount holei first e vuex er moddhe [ this.$store.state.loadingCat ] ei data ta loading hisabe newa hoise jodi data ta vuex e 0 hoy taile loading hobe and axios action complete houar por data tar value 1 hoye jabe then ar loading ta show korbe na
        //  this.$store.state.loadingCat eitar value niye loading e condition newa hoise
    },

    computed: {
        getCategories() {
            return this.$store.getters.categories; //categories function er moddhe return kora hoise this diye then app.js er vuex er call kora store ke $ sign diye then store.js file er getters er vitore test function ke call kora hoise ar evabei value pawa gese
        }
    },
    watch: {},
    data() {
        return {
            addCategoryForm: {
                name: "",
                preview_image: "", //eita holo preview image er jonno property
                upload_image: "", //eita holo server upload image er jonno property
                status: "",
                lodingBeforeSubmit: ""
            },
            errors: {},
            categories: [], //all categories will be push here
            editCategroy: {}
        };
    },

    methods: {
        hideEditCatModal() {
            this.$refs.editCategoryModal.hide(); //hide modal using this code
        },
        hideAddCatModal() {
            this.$refs.newCategoryModal.hide(); //hide modal using this code

            this.addCategoryForm.name = "";
            this.addCategoryForm.preview_image = "";
            this.addCategoryForm.upload_image = "";
            this.addCategoryForm.status = "";
            this.errors = "";
            this.addCategoryForm.lodingBeforeSubmit = "";
            this.$refs.resetForm.reset();
        },
        showAddCatModal() {
            this.$refs.newCategoryModal.show();
        },
        selectedImage(anyEvent) {
            this.addCategoryForm.preview_image = ""; //eta dewa hoise jate image preview tao na show kore tai
            let loadUpfile = anyEvent.target.files[0];

            this.addCategoryForm.imageValidation = "";
            this.addCategoryForm.upload_image = this.$refs.imgFile.files[0]; //eivabe $refs er maddhome file ta dhora jei kotha abar event er maddome anyEvent.target.files[0]; dhorao same kotha
            let myFilereader = new FileReader();
            myFilereader.onload = anyEvent => {
                this.addCategoryForm.preview_image = anyEvent.target.result;
            };
            myFilereader.readAsDataURL(loadUpfile);
        },
        ifEditModalHide() {
            // this.addCategoryForm.preview_image = "";
        },
        ifModalHide() {
            // this.addCategoryForm.preview_image = "";
        },
        addCategory() {
            this.addCategoryForm.lodingBeforeSubmit = "Loding";
            // niceher new form niye form submit eivabeo kora jay abar direct data thekeo niye add kora jay
            //nicher ei from er append er moddhe jai name use korbo ta dhore next e controller e kaaj korte hobe form er name baad hobe
            let addCatFormData = new FormData();
            addCatFormData.append("name", this.addCategoryForm.name);
            addCatFormData.append("image", this.addCategoryForm.upload_image);
            addCatFormData.append("status", this.addCategoryForm.status);

            const config = {
                headers: { "content-type": "multipart/form-data" }
            };
            axios
                .post(this.$store.state.apiURL + "category", addCatFormData)
                .then(response => {
                    //handle success
                    this.addCategoryForm.name = "";
                    this.addCategoryForm.preview_image = "";
                    this.addCategoryForm.upload_image = "";
                    this.addCategoryForm.status = "";
                    this.errors = "";
                    this.$refs.resetForm.reset(); //image ta reset korar jonno form ke reset kora hoise action success houwar por
                    this.$store.dispatch("appsCategories");
                    //   this.$refs.newCategoryModal.hide();  if you wanna close modal after add category then use this line of codes

                    iziToast.success({
                        title: "Success",
                        message: response.data.succMsg,
                        backgroundColor: "rgb(7 83 44)",
                        icon: "fas fa-check-circle"
                        // eta bootstrap er icon class
                    });
                })
                .catch(e => {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }

                    if (e.response.status === 500) {
                        iziToast.error({
                            title: "Error",
                            message: e.response.data.errorMsg,
                            backgroundColor: "rgb(103 0 0)",
                            icon: "fas fa-times-circle"
                            // eta bootstrap er icon class
                        });
                    }
                })
                .finally(() => {
                    this.addCategoryForm.lodingBeforeSubmit = "";
                });
        },
        deleteCat(id) {
            this.loadingDlt = 1;
            let deleteId = id;

            //niche callbackResult eta es6 er niyome function likha hoise amra 'function callbackResult(){}' eivabeo function likhte partam
            this.sweetDelete(callbackResult => {
                axios
                    .delete(this.$store.state.apiURL + "category/" + deleteId)
                    .then(res => {
                        this.$store.dispatch("appsCategories"); //mounted er moddhe  jei dispatch vuex er property ta call kora hoise oitai eikhane call hobe refresh without reaload houar jonno
                        iziToast.success({
                            title: "Success",
                            message: res.data.msg,
                            backgroundColor: "rgb(7 83 44)",
                            icon: "fas fa-check-circle"
                            // eta bootstrap er icon class
                        });
                    })
                    .catch(function(errordata) {
                        iziToast.error({
                            title: "Error",
                            message:
                                "Maybe category deleted,Please refresh browser!",
                            backgroundColor: "rgb(103 0 0)",
                            icon: "fas fa-times-circle"
                            // eta bootstrap er icon class
                        });
                    });
            });
        },
        editCat(category) {
            this.$refs.editCategoryModal.show(); //show modal using this code its default rule to show code
            this.editCategroy = category;
        }
    }
};
</script>
<style scope>
.borderError {
    border: 1px solid red !important;
    border-radius: 3px !important;
}
.hideData {
    display: none;
}
</style>
