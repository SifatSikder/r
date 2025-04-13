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
                            <h4 class="m-0"><strong class="text-dark">Safety & Assurance Settings</strong></h4>
                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">Save Changes</button>
                        </div>
                        <div class="card-body p-5">
                            <div class="row">
                                <div class="col-lg-12 mb-5">
                                    <div class="w-100 p-5 shadow">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3" v-if="settings.safety.banner_full !== null">
                                                    <img :src="settings.safety.banner_full" style="max-width: 100%; height: 150px;border-radius: 20px">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>Banner Photo</strong></label>
                                                    <input type="file" class="form-control" name="banner" @change="attachFile">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>Banner Title</strong></label>
                                                    <input type="text" class="form-control" name="banner_title" v-model="settings.safety.banner_title" placeholder="Banner Title">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>Banner Intro</strong></label>
                                                    <input type="text" class="form-control" name="banner_intro" v-model="settings.safety.banner_intro" placeholder="Banner Intro">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-5">
                                    <div class="w-100 p-5 shadow">
                                        <div class="row">
                                            <div class="col-lg-12 mb-5">
                                                <label class="form-label"><strong>Pre Risk Content</strong></label>
                                                <textarea class="form-control" placeholder="Pre Risk Content" rows="3" v-model="settings.safety.pre_risk"></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 mb-5">
                                                <h1 class=""><strong>The Risks and Uncertainty of Application of AI</strong></h1>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>SOFTWARE</strong></label>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.software[0]" name="software[]">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.software[1]" name="software[]">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.software[2]" name="software[]">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.software[3]" name="software[]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>HARDWARE</strong></label>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.hardware[0]" name="hardware[]">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.hardware[1]" name="hardware[]">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.hardware[2]" name="hardware[]">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.hardware[3]" name="hardware[]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>ETHICAL</strong></label>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.ethical[0]" name="ethical[]">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.ethical[1]" name="ethical[]">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.ethical[2]" name="ethical[]">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.ethical[3]" name="ethical[]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>LEGAL</strong></label>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.legal[0]" name="legal[]">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.legal[1]" name="legal[]">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.legal[2]" name="legal[]">
                                                            <input type="text" class="form-control mb-2" v-model="settings.safety.risk.legal[3]" name="legal[]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 mb-5">
                                                <label class="form-label"><strong>Role of RaiDOT</strong></label>
                                                <QuillEditor v-model:content="settings.safety.mot_role" contentType="html" theme="snow" toolbar="full" style="height: 400px"/>
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
import { QuillEditor } from '@vueup/vue-quill'

export default {
    components: {
        sections_menu,QuillEditor
    },
    data() {
        return {
            Loading: false,
            settings: {
                safety: {
                    banner: null,
                    banner_full: null,
                    banner_intro: '',
                    pre_risk: '',
                    risk:{
                        software: [],
                        hardware: [],
                        ethical: [],
                        legal: [],
                    },
                    mot_role: ''
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
                    this.settings.safety.banner = res.data.file_path;
                    this.settings.safety.banner_full = res.data.full_file_path;
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
            ApiService.POST(ApiRoutes.WebsiteSettings + '/safety', {}, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.settings.safety = res.data.settings;
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
