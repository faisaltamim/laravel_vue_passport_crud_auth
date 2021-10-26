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

                            <div
                                style="margin-top: 12px"
                                class="float-right mr-2 addbtnForCheckboxBtn"
                                v-if="checkboxOption.selected.length >= 2"
                            >
                                <div
                                    class="CheckboxShowBtn"
                                    style="display: block !important; width: 100%"
                                >
                                    <button
                                        @click="deleteAll()"
                                        title="Delete All"
                                        class="btn btn-sm btn-dark"
                                    >
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                    <button
                                        @click="activeAllStts()"
                                        title="Active All"
                                        class="btn btn-sm btn-dark"
                                    >
                                        <i
                                            class="fas fa-circle text-success"
                                        ></i>
                                    </button>
                                    <button
                                        @click="inactiveAllStts()"
                                        title="Inactive All"
                                        class="btn btn-sm btn-dark"
                                    >
                                        <i
                                            class="fas fa-circle text-danger"
                                        ></i>
                                    </button>
                                </div>
                            </div>
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
                                            <th>
                                                <input
                                                    :disabled="
                                                        this.getCategories
                                                            .length === 0
                                                    "
                                                    type="checkbox"
                                                    name="selectAll"
                                                    id="selectAll"
                                                    v-model="
                                                        checkboxOption.selectedAll
                                                    "
                                                    @click="selectAllFucn()"
                                                />
                                            </th>
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
                                            <td>
                                                <input
                                                    type="checkbox"
                                                    name="select"
                                                    id="select"
                                                    :value="category.id"
                                                    v-model="
                                                        checkboxOption.selected
                                                    "
                                                />
                                            </td>
                                            <td>{{ index + 1 }}</td>
                                            <td style="word-break: break-word">
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
                                                        '/storage/category_images/' +
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
                                            <td colspan="6">
                                                <h2 class="text-center">
                                                    <img
                                                        style="width: 35px; margin-top: -5px"
                                                        class="img img-fluid"
                                                        src="/site/site_reusable_images/loader/loader4.gif"
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
                                            <td colspan="6">
                                                <h2 class="text-center">
                                                    Data Not Found
                                                </h2>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-if="getCategories.length !== 0 " class="loadMoreData text-center">
                                    <!-- vuetify pagination start -->
                                    <div class="text-center">
                                        <el-pagination
                                        background
                                        :page-size="getCategoriesForLoadMore.per_page"
                                        @current-change="handleCurrentChange"
                                        :current-page.sync="currentPage"
                                        layout="prev, pager, next"
                                        :total="getCategoriesForLoadMore.total">
                                        </el-pagination>

                                    </div>
                                    <!-- vuetify pagination end -->
                                </div>
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
                                src="/site/site_reusable_images/loader/loader4.gif"
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
                            :class="{ borderError: editErrors.name != null }"
                            class="form-control"
                            type="text"
                            :disabled="lodingBeforeUpdate !== ''"
                            name="name"
                            id="name"
                            placeholder="Category Name"
                            v-model="editCategroy.name"
                        />
                        <strong class="text-danger" v-if="editErrors.name">{{
                            editErrors.name[0]
                        }}</strong>
                    </div>

                    <div class="form-group">
                        <div class="imageWithpreview">
                            <label for="image">Category Image</label>
                            <div>
                                <input
                                    :class="{
                                        borderError: editErrors.image != null
                                    }"
                                    :disabled="lodingBeforeUpdate !== ''"
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
                                    :src="
                                        '/storage/category_images/' +
                                            editCategroy.image
                                    "
                                    alt="Preview Image"
                                    ref="editImgFilePreview"
                                    id="previewImg"
                                />
                            </div>
                            <strong
                                class="text-danger"
                                v-if="editErrors.image"
                                >{{ editErrors.image[0] }}</strong
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <strong style="cursor: pointer">Category Status</strong>
                        <div
                            :class="{ borderError: editErrors.status != null }"
                            style="background: #1b262d"
                            class="mt-2"
                        >
                            <label for="catStatusActive" class="mt-2 ml-3">
                                <input
                                    :disabled="lodingBeforeUpdate !== ''"
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
                                    :disabled="lodingBeforeUpdate !== ''"
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
                        <strong class="text-danger" v-if="editErrors.status">{{
                            editErrors.status[0]
                        }}</strong>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button
                        :disabled="lodingBeforeUpdate !== ''"
                        type="button"
                        class="btn btn-sm btn-danger"
                        @click="hideEditCatModal"
                    >
                        Close
                    </button>

                    <button type="submit" class="btn btn-sm btn-success">
                        <span v-if="lodingBeforeUpdate === ''"
                            >Update Category</span
                        >
                        <span v-if="lodingBeforeUpdate !== ''"
                            >Updating
                            <img
                                style="width: 15px; margin-top: -3px"
                                class="img img-fluid"
                                src="/site/site_reusable_images/loader/loader4.gif"
                                alt=""
                        /></span>
                    </button>
                </div>
            </form>
        </b-modal>
        <!-- edit category modal end -->
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    name: "category",

    mounted() {
        this.$store.dispatch("appsCategories",this.currentPage); //ei function er moddhe peram hisabe data pass korte hole just comma diye then data pass korte hobe
        // uporer vuex er function ta mount holei first e vuex er moddhe [ this.$store.state.loadingCat ] ei data ta loading hisabe newa hoise jodi data ta vuex e 0 hoy taile loading hobe and axios action complete houar por data tar value 1 hoye jabe then ar loading ta show korbe na
        //  this.$store.state.loadingCat eitar value niye loading e condition newa hoise
    },
  

    computed: {
        //eivabeo mapGetters use kore getters theke data eikhane show korano jay
        // ...mapGetters({
        //   getCategories: "categories",
        // }),
        getCategories() {
            return this.$store.getters.categories; //categories function er moddhe return kora hoise this diye then app.js er vuex er call kora store ke $ sign diye then store.js file er getters er vitore test function ke call kora hoise ar evabei value pawa gese
        },
        // getCategoriesForLoadMore() {
        //     return this.$store.getters.categoriesLoadMore; //categories function er moddhe return kora hoise this diye then app.js er vuex er call kora store ke $ sign diye then store.js file er getters er vitore test function ke call kora hoise ar evabei value pawa gese
        // },
        getCategoriesForLoadMore() {
            return this.$store.getters.categoriesLoadMore;
        },

        selectedVal() {
            return this.checkboxOption.selected;
        }
    },
    watch: {
        //data property er vitore selected object ta ekta opject er vitore ase ar watch property te function likhar age == checkboxOption.selected:fucntion(){} == eivabe likha jay na tai computed er moddhe selectedVal ta return kore eikhane likhsi ekhon kaaj korbe ar jodi data property er vitore checkboxOption object na theke direct selected object ta thakto taile ar computed property er kaj kora lagto na taile emnei direct call kore dilei hoto
        selectedVal: function(myvalue) {
            let comperisonVal = myvalue.length === this.getCategories.length; //my value mane this.select jodi posts length er soman hoy taile porer if else e dekhano hoise
            if (comperisonVal == true) {
                this.checkboxOption.selectedAll = true; //ekhane selectAll value er maan true kore dewa ache
            } else {
                this.checkboxOption.selectedAll = false; //ekhane selectAll value er maan false kore dewa ache
            }
        }
    },
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

            //edit section
            editCategroy: {},
            edit_image_upload: "",
            editErrors: {},
            lodingBeforeUpdate: "",

            // select / deselect checkbox
            checkboxOption: {
                selected: [],
                selectedAll: false
            },
            currentPage:1,
        };
    },

    methods: {
        handleCurrentChange(){
            this.$store.dispatch("appsCategories",this.currentPage);
            this.checkboxOption.selected = [];
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
                    this.errors = {};
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
                    this.checkboxOption.selected = [];
                    this.currentPage = 1;
                    this.$store.dispatch("appsCategories",this.currentPage);
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
                        // this.$store.dispatch("appsCategories"); //mounted er moddhe  jei dispatch vuex er property ta call kora hoise oitai eikhane call hobe refresh without reaload houar jonno
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
                    })
                    .finally(() => {
                         this.$store.dispatch("appsCategories",this.currentPage);
                        this.checkboxOption.selected = [];
                    });
            });
        },

        ///////////////////////////
        // start edit methods area
        //////////////////////////
        hideEditCatModal() {
            this.$refs.editCategoryModal.hide(); //hide modal using this code
            this.$store.dispatch("appsCategories");
        },
        showEditCatModal() {
            this.$refs.editCategoryModal.show(); //hide modal using this code
        },
        editCat(category) {
            this.showEditCatModal(); //show modal using this code its default rule to show code
            this.editCategroy = { ...category };
            // this.editCategroy = category;//eivabe dile v-model e value ta all category te show korbe
            //{...category} rule :- uporer category er value gula pass kora hoise this.editCategory er moddhe but extra {...category} na diye just function er parameter category dileo hoto but jodi just category dewa hoto taile value edit korar somoy v-model theke edit value tao set hoye jeto input er value but {... } eta use koray ar value ta auto set hobe na etar maddhome value take atkiye rakha hobe....erpor o confusion thakle just {...} eita uthiye just category pass kore dekhte paro bro
        },
        selectedEditImage(anyEvent) {
            this.edit_image_preview = ""; //eta dewa hoise jate image preview tao na show kore tai
            let loadUpfile = anyEvent.target.files[0];

            this.edit_image_upload = this.$refs.editImgFile.files[0]; //eivabe $refs er maddhome file ta dhora jei kotha abar event er maddome anyEvent.target.files[0]; dhorao same kotha
            let myFilereader = new FileReader();
            myFilereader.onload = anyEvent => {
                this.$refs.editImgFilePreview.src = anyEvent.target.result;
            };
            myFilereader.readAsDataURL(loadUpfile);
        },
        updateCategory() {
            this.lodingBeforeUpdate = "Loding";

            let formDta = new FormData();
            formDta.append("name", this.editCategroy.name);
            formDta.append("image", this.edit_image_upload);
            formDta.append("status", this.editCategroy.status);
            formDta.append("_method", "put");

            let catId = this.editCategroy.id;

            const config = {
                headers: { "content-type": "multipart/form-data" }
            };
            axios
                .post(this.$store.state.apiURL + "category/" + catId, formDta)
                .then(response => {
                    (this.editErrors = {}), this.$refs.editCategoryModal.hide(); //  if you wanna close modal after add category then use this line of codes
                    iziToast.success({
                        title: "Success",
                        message: response.data.message,
                        backgroundColor: "rgb(7 83 44)",
                        icon: "fas fa-check-circle"
                        // eta bootstrap er icon class
                    });
                })
                .catch(e => {
                    if (e.response.status === 422) {
                        this.editErrors = e.response.data.message;
                    }
                    if (e.response.status === 500) {
                        iziToast.error({
                            title: "Error",
                            message: e.response.data.message,
                            backgroundColor: "rgb(103 0 0)",
                            icon: "fas fa-times-circle"
                            // eta bootstrap er icon class
                        });
                    }
                })
                .finally(() => {
                    this.lodingBeforeUpdate = "";
                    this.checkboxOption.selected = [];
                    // this.$store.dispatch("appsCategories");
                    this.$store.dispatch("appsCategories",this.currentPage);
                    
                });
        },
        ////////////////////////
        // end edit methods area
        ////////////////////////

        /////////////////////////////
        // start SelectOption area //
        ////////////////////////////
        selectAllFucn() {
            if (this.checkboxOption.selectedAll) {
                this.checkboxOption.selected = [];
            } else {
                this.getCategories.forEach(cat => {
                    this.checkboxOption.selected.push(cat.id);
                });
            }
        },

        //delete all selected
        deleteAll() {
            this.sweetDelete(callbackResult => {
                axios
                    .delete(
                        this.$store.state.apiURL +
                            "category/delete-all/" +
                            this.checkboxOption.selected
                    )
                    .then(res => {
                        // this.$store.dispatch("appsCategories"); //mounted er moddhe  jei dispatch vuex er property ta call kora hoise oitai eikhane call hobe refresh without reaload houar jonno
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
                    })
                    .finally(() => {
                        this.checkboxOption.selected = [];
                        this.currentPage = 1;
                        this.$store.dispatch("appsCategories",this.currentPage);
                    });
            });
        },

        //active all status
        activeAllStts() {
            // put method e api er jonno update korle ar eikhane jodi _method,put na dewa hoy taile kaaj korbe na
            let formDta = new FormData();
            formDta.append("_method", "put");

            swal.fire({
                title: "Are you confirm to active items?",
                // text:
                //     "If you confirm then all selected categories will be activate!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "rgb(0 194 42)",
                cancelButtonColor: "rgb(1 1 1)",
                confirmButtonText: "Yes, Active All!"
            }).then(result => {
                if (result.isConfirmed) {
                    axios
                        .post(
                            this.$store.state.apiURL +
                                "category/active-all/" +
                                this.checkboxOption.selected,
                            formDta
                        )
                        .then(res => {
                            if (res.data.activeNumber === 0) {
                                iziToast.warning({
                                    title: "Check Again!",
                                    message: res.data.msg,
                                    backgroundColor: "rgb(130 70 0)",
                                    icon: "fas fa-exclamation-circle"
                                    // eta bootstrap er icon class
                                });
                            } else {
                                iziToast.success({
                                    title: "Success",
                                    message: res.data.msg,
                                    backgroundColor: "rgb(7 83 44)",
                                    icon: "fas fa-check-circle"
                                    // eta bootstrap er icon class
                                });
                            }
                        })
                        .catch(function(errordata) {
                            iziToast.error({
                                title: "Error",
                                message:
                                    "Category didn't activated for some technical issue!",
                                backgroundColor: "rgb(103 0 0)",
                                icon: "fas fa-times-circle"
                                // eta bootstrap er icon class
                            });
                        })
                        .finally(() => {
                            this.checkboxOption.selected = [];
                        this.$store.dispatch("appsCategories",this.currentPage);
                        });
                }
            });
        },
        //active all status
        inactiveAllStts() {
            // put method e api er jonno update korle ar eikhane jodi _method,put na dewa hoy taile kaaj korbe na
            let formDta = new FormData();
            formDta.append("_method", "put");
            swal.fire({
                title: "Are you confirm to inactive items?",
                // text:
                //     "If you confirm then all selected categories will be inactivate!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "rgb(184 0 0)",
                cancelButtonColor: "rgb(1 1 1)",
                confirmButtonText: "Yes, Inactivate All!"
            }).then(result => {
                if (result.isConfirmed) {
                    axios
                        .post(
                            this.$store.state.apiURL +
                                "category/inactive-all/" +
                                this.checkboxOption.selected,
                            formDta
                        )
                        .then(res => {
                            if (res.data.activeNumber === 0) {
                                iziToast.warning({
                                    title: "Check Again!",
                                    message: res.data.msg,
                                    backgroundColor: "rgb(130 70 0)",
                                    icon: "fas fa-exclamation-circle"
                                    // eta bootstrap er icon class
                                });
                            } else {
                                iziToast.success({
                                    title: "Success",
                                    message: res.data.msg,
                                    backgroundColor: "rgb(7 83 44)",
                                    icon: "fas fa-check-circle"
                                    // eta bootstrap er icon class
                                });
                            }
                        })
                        .catch(function(errordata) {
                            iziToast.error({
                                title: "Error",
                                message:
                                    "Category didn't activated for some technical issue!",
                                backgroundColor: "rgb(103 0 0)",
                                icon: "fas fa-times-circle"
                                // eta bootstrap er icon class
                            });
                        })
                        .finally(() => {
                            this.checkboxOption.selected = [];
                        this.$store.dispatch("appsCategories",this.currentPage);
                        });
                }
            });
        }

        /////////////////////////////
        // start SelectOption area //
        ////////////////////////////
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
