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
                            <h4 class="m-0"><strong class="text-dark">Homepage Settings</strong></h4>
                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">Save Changes</button>
                        </div>
                        <div class="card-body p-5">
                            <div class="row">
                                <div class="col-lg-12 mb-5">
                                    <div class="w-100 shadow">
                                        <div class="w-100 p-3 bg-light border border-bottom">
                                            <h4 class="m-0 p-0 text-secondary"><strong>Home Banner</strong></h4>
                                        </div>
                                        <div class="w-100 p-5">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3" v-if="settings.homepage.banner_full !== null">
                                                        <img :src="settings.homepage.banner_full" style="max-width: 100%; height: 150px;border-radius: 20px">
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
                                                        <input type="text" class="form-control" name="banner_title" v-model="settings.homepage.banner_title" placeholder="Banner Title">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label"><strong>Banner Intro</strong></label>
                                                        <input type="text" class="form-control" name="banner_intro" v-model="settings.homepage.banner_intro" placeholder="Banner Intro">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label"><strong>Banner Description</strong></label>
                                                        <input type="text" class="form-control" name="banner_intro" v-model="settings.homepage.banner_description" placeholder="Banner Description">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-5">
                                    <div class="w-100 shadow">
                                        <div class="w-100 p-3 bg-light border border-bottom">
                                            <h4 class="m-0 p-0 text-secondary"><strong>About Us</strong></h4>
                                        </div>
                                        <div class="w-100 p-5">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label"><strong>About us</strong></label>
                                                        <textarea class="form-control" v-model="settings.homepage.about_us" name="about_us" placeholder="Type About Us" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label"><strong>Our Mission</strong></label>
                                                        <textarea class="form-control" v-model="settings.homepage.our_mission" name="our_mission" placeholder="Type About Our Mission" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-5">
                                    <div class="w-100 shadow">
                                        <div class="w-100 p-3 bg-light border border-bottom">
                                            <h4 class="m-0 p-0 text-secondary"><strong>Why RaiDOT?</strong></h4>
                                        </div>
                                        <div class="w-100 p-5">
                                            <div class="form-group mb-3">
                                                <label class="form-label"><strong>Title</strong></label>
                                                <input type="text" class="form-control" v-model="settings.homepage.about_project_title" name="about_project_title">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label"><strong>Sub Title</strong></label>
                                                <textarea class="form-control" v-model="settings.homepage.about_project" name="about_project" rows="3"></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-xxl-4 col-xl-6 col-lg-12">
                                                    <div class="form-group mb-3 bg-light p-3 border">
                                                        <input type="text" class="form-control mb-3" v-model="settings.homepage.about_project_details[0].title" name="about_project_title_0">
                                                        <textarea class="form-control" v-model="settings.homepage.about_project_details[0].details" name="economic_growth" placeholder="Type About Economic Growth" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-xl-6 col-lg-12">
                                                    <div class="form-group mb-3 bg-light p-3 border">
                                                        <input type="text" class="form-control mb-3" v-model="settings.homepage.about_project_details[1].title" name="about_project_title_1">
                                                        <textarea class="form-control" v-model="settings.homepage.about_project_details[1].details" name="economic_growth" placeholder="Type About Economic Growth" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-xl-6 col-lg-12">
                                                    <div class="form-group mb-3 bg-light p-3 border">
                                                        <input type="text" class="form-control mb-3" v-model="settings.homepage.about_project_details[2].title" name="about_project_title_2">
                                                        <textarea class="form-control" v-model="settings.homepage.about_project_details[2].details" name="economic_growth" placeholder="Type About Economic Growth" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-xl-6 col-lg-12">
                                                    <div class="form-group mb-3 bg-light p-3 border">
                                                        <input type="text" class="form-control mb-3" v-model="settings.homepage.about_project_details[3].title" name="about_project_title_3">
                                                        <textarea class="form-control" v-model="settings.homepage.about_project_details[3].details" name="economic_growth" placeholder="Type About Economic Growth" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-xl-6 col-lg-12">
                                                    <div class="form-group mb-3 bg-light p-3 border">
                                                        <input type="text" class="form-control mb-3" v-model="settings.homepage.about_project_details[4].title" name="about_project_title_4">
                                                        <textarea class="form-control" v-model="settings.homepage.about_project_details[4].details" name="economic_growth" placeholder="Type About Economic Growth" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-xl-6 col-lg-12">
                                                    <div class="form-group mb-3 bg-light p-3 border">
                                                        <input type="text" class="form-control mb-3" v-model="settings.homepage.about_project_details[5].title" name="about_project_title_5">
                                                        <textarea class="form-control" v-model="settings.homepage.about_project_details[5].details" name="economic_growth" placeholder="Type About Economic Growth" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-xl-6 col-lg-12">
                                                    <div class="form-group mb-3 bg-light p-3 border">
                                                        <input type="text" class="form-control mb-3" v-model="settings.homepage.about_project_details[6].title" name="about_project_title_6">
                                                        <textarea class="form-control" v-model="settings.homepage.about_project_details[6].details" name="economic_growth" placeholder="Type About Economic Growth" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-5">
                                    <div class="w-100 p-5 shadow">
                                        <div class="form-group mb-3">
                                            <label class="form-label"><strong>Homepage Video Preview</strong></label>
                                            <input type="text" class="form-control" v-model="settings.homepage.homepage_video_preview" name="homepage_video_preview" placeholder="Place a Youtube video URL here">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>Mobile App URL (Play Store)</strong></label>
                                                    <input type="text" class="form-control" v-model="settings.homepage.mobile_app_play_store" name="mobile_app_play_store" placeholder="Mobile App URL (Play Store)">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>Mobile App URL (Apple Store)</strong></label>
                                                    <input type="text" class="form-control" v-model="settings.homepage.mobile_app_apple_store" name="mobile_app_apple_store" placeholder="Mobile App URL (Apple Store)">
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
                homepage: {
                    banner: null,
                    banner_full: null,
                    banner_title: '',
                    banner_intro: '',
                    about_us: '',
                    our_mission: '',
                    about_project_title: '',
                    about_project: '',
                    about_project_details: [
                        {title: '', description: ''},
                        {title: '', description: ''},
                        {title: '', description: ''},
                        {title: '', description: ''},
                        {title: '', description: ''},
                        {title: '', description: ''},
                        {title: '', description: ''},
                    ],
                    homepage_video_preview: '',
                    mobile_app_play_store: '',
                    mobile_app_apple_store: ''
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
                    this.settings.homepage.banner = res.data.file_path;
                    this.settings.homepage.banner_full = res.data.full_file_path;
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
            ApiService.POST(ApiRoutes.WebsiteSettings + '/homepage', {}, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.settings.homepage = res.data.settings;
                    if(this.settings.homepage.about_project_details === undefined){
                        this.settings.homepage['about_project_details'] = [
                            {title: '', description: ''},
                            {title: '', description: ''},
                            {title: '', description: ''},
                            {title: '', description: ''},
                            {title: '', description: ''},
                            {title: '', description: ''},
                            {title: '', description: ''},
                        ];
                    }
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
