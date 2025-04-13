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
                            <h4 class="m-0"><strong class="text-dark">Team Settings</strong></h4>
                            <div class="">
                                <a @click="addNewTeam" class="btn btn-sm btn-primary rounded-pill px-3 me-2">Add Team Member</a>
                                <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">Save Changes</button>
                            </div>
                        </div>
                        <div class="card-body p-5">
                            <div class="row">
                                <div class="col-lg-12 mb-5">
                                    <div class="w-100 p-5 shadow">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3" v-if="settings.team.banner_full !== null">
                                                    <img :src="settings.team.banner_full" style="max-width: 100%; height: 150px;border-radius: 20px">
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
                                                    <input type="text" class="form-control" name="banner_title" v-model="settings.team.banner_title" placeholder="Banner Title">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"><strong>Banner Intro</strong></label>
                                                    <input type="text" class="form-control" name="banner_intro" v-model="settings.team.banner_intro" placeholder="Banner Intro">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-5">
                                    <div class="row">

                                        <div class="col-lg-6" v-for="(team, index) in settings.team.members">
                                            <div class="w-100 p-5 shadow mb-4">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3" v-if="team.avatar_full !== null">
                                                            <img :src="team.avatar_full" style="max-width: 100%; height: 150px;border-radius: 20px">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label"><strong>Avatar</strong></label>
                                                            <input type="file" class="form-control" name="banner" @change="attachMemberFile($event, index)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label"><strong>Name</strong></label>
                                                            <input type="text" class="form-control" name="name" v-model="team.name" placeholder="Name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label"><strong>Designation</strong></label>
                                                            <input type="text" class="form-control" name="designation" v-model="team.designation" placeholder="Designation">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label"><strong>Details</strong></label>
                                                            <textarea class="form-control" name="details" v-model="team.details" placeholder="Details"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-end">
                                                        <a class="btn btn-sm btn-danger" @click="removeThisMember(index)">Remove</a>
                                                    </div>
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
import { QuillEditor } from '@vueup/vue-quill'

export default {
    components: {
        sections_menu,QuillEditor
    },
    data() {
        return {
            Loading: false,
            settings: {
                team: {
                    banner: null,
                    banner_full: null,
                    banner_intro: '',
                    members: []
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
                    this.settings.team.banner = res.data.file_path;
                    this.settings.team.banner_full = res.data.full_file_path;
                }
            })
        },
        attachMemberFile: function (event, index) {
            let file = event.target.files[0];
            let formData = new FormData();
            formData.append("file", file);
            formData.append("media_type", 1);
            this.Loading = true;
            ApiService.UPLOAD(ApiRoutes.MEDIA, formData, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.settings.team.members[index].avatar = res.data.file_path;
                    this.settings.team.members[index].avatar_full = res.data.full_file_path;
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
            ApiService.POST(ApiRoutes.WebsiteSettings + '/team', {}, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.settings.team = res.data.settings;
                }
            })
        },
        addNewTeam() {
            this.settings.team.members.push({
                avatar: '',
                name: '',
                designation: '',
                details: '',
            })
            setTimeout(() => {
                window.scrollTo(0, document.body.scrollHeight);
            })
        },
        removeThisMember(index) {
            this.settings.team.members.splice(index, 1)
        }
    },
    created() {
        this.GetWebSettings();
    },
    mounted() {
    }
};
</script>
