<template>
    <div class="w-100">
        <div class="body-loading" v-if="Loading === true">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-3x fa-spin fa-cog text-theme"></i> <br> Please Wait ...
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 col-md-4">
                <div class="card mb-4 sticky-top">
                    <div class="card-header bg-white py-3">
                        <h4 class="m-0"><strong class="text-dark">Pages and Sections</strong></h4>
                    </div>
                    <div class="card-body">
                        <sections_menu></sections_menu>
                    </div>
                </div>
            </div>
            <div class="col-xl-10 col-md-8">


                <form class="w-100" @submit.prevent="updateWebSettings">
                    <div class="card">
                        <div class="card-header bg-white py-3 d-flex justify-content-between sticky-top">
                            <h4 class="m-0"><strong class="text-dark">Meta Info Settings</strong></h4>
                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">Save Changes</button>
                        </div>
                        <div class="card-body p-5">
                            <div class="w-100 p-5 shadow mb-5">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3" v-if="settings.meta_info.image_full !== null">
                                            <img :src="settings.meta_info.image_full" style="max-width: 100%; height: 150px;border-radius: 20px">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label"><strong>Image</strong></label>
                                            <input type="file" class="form-control" name="image" @change="attachFile">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label"><strong>Keywords</strong></label>
                                            <input type="text" class="form-control" name="keywords" v-model="settings.meta_info.keywords" placeholder="Type website SEO keywords as comma separate way">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label"><strong>Description</strong></label>
                                            <input type="text" class="form-control" name="description" v-model="settings.meta_info.description" placeholder="Type website description 160 character">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label"><strong>Address</strong></label>
                                            <input type="text" class="form-control" name="address" v-model="settings.meta_info.address" placeholder="Type Office Address">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label"><strong>Postal Code</strong></label>
                                            <input type="text" class="form-control" name="postal" v-model="settings.meta_info.postal" placeholder="Postal Code">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label"><strong>Country</strong></label>
                                            <input type="text" class="form-control" name="country" v-model="settings.meta_info.country" placeholder="Country">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>

<script>
import sections_menu from "@/admin/pages/WebsiteSettings/sections_menu.vue";
import ApiService from "../../services/ApiService";
import ApiRoutes from "../../services/ApiRoutes";
import {createToaster} from "@meforma/vue-toaster";

const Toaster = createToaster({position: 'top-right'});

export default {
    components: {
        sections_menu
    },
    data() {
        return {
            Loading: false,
            settings: {
                meta_info: {
                    image: null,
                    image_full: null,
                    keywords: '',
                    description: '',
                    address: '',
                    postal: '',
                    country: ''
                }
            }
        };
    },
    methods: {
        attachFile: function (event) {
            let file = event.target.files[0];
            let formData = new FormData();
            formData.append("file", file);
            formData.append("media_type", 1);
            this.Loading = true;
            ApiService.UPLOAD(ApiRoutes.MEDIA, formData, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.settings.meta_info.image = res.data.file_path;
                    this.settings.meta_info.image_full = res.data.full_file_path;
                }
            })
        },
        updateWebSettings() {
            this.Loading = true;
            ApiService.POST(ApiRoutes.WebsiteSettings + '/store', {settings: this.settings}, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    Toaster.success(res.msg);
                }
            })
        },
        GetWebSettings() {
            this.Loading = true;
            ApiService.POST(ApiRoutes.WebsiteSettings + '/meta_info', {}, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.settings.meta_info = res.data.settings;
                }
            })
        }
    },
    created() {
        this.GetWebSettings();
    },
    mounted() {
    }
};
</script>
