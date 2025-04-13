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
                    <div class="card question-holder">
                        <div class="card-header bg-white py-3 d-flex justify-content-between sticky-top">
                            <h4 class="m-0"><strong class="text-dark">Social Settings</strong></h4>
                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">Save Changes</button>
                        </div>
                        <div class="card-body p-5">
                            <div class="row">
                                <div class="col-lg-12 mb-5">
                                    <div class="w-100 p-5 shadow">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>Facebook</strong></label>
                                                    <input type="text" class="form-control" v-model="settings.social.facebook" name="facebook" placeholder="Facebook Profile/Page">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>LinkedIn</strong></label>
                                                    <input type="text" class="form-control" v-model="settings.social.linkedin" name="linkedin" placeholder="LinkedIn Profile">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>Instagram</strong></label>
                                                    <input type="text" class="form-control" v-model="settings.social.instagram" name="instagram" placeholder="Instagram Profile">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>Twitter</strong></label>
                                                    <input type="text" class="form-control" v-model="settings.social.twitter" name="twitter" placeholder="Twitter Profile">
                                                </div>
                                            </div>
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
                social: {
                    facebook: '',
                    linkedin: '',
                    instagram: '',
                    twitter: '',
                }
            }
        };
    },
    methods: {
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
            ApiService.POST(ApiRoutes.WebsiteSettings + '/social', {}, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.settings.social = res.data.settings;
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
