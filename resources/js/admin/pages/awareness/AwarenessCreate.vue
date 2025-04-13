<template>
    <div class="container-lg">
        <div class="w-100">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 col-md-12">

                    <form class="w-100" @submit.prevent="CreateCourse">
                        <div class="card question-holder">
                            <div class="card-header bg-white py-3 d-flex justify-content-between sticky-top">
                                <h4 class="m-0"><strong class="text-dark">New Awareness Course</strong></h4>
                                <div class="">
                                    <router-link class="btn btn-sm btn-secondary rounded-pill px-3 me-2" :to="{name: 'Awareness'}">Cancel</router-link>
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Save Changes</button>
                                </div>
                            </div>
                            <div class="card-body p-2 p-lg-3">
                                <div class="row">
                                    <div class="col-lg-12 mb-1">
                                        <div class="w-100 p-4">
                                            <div class="error-report-g"></div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group mb-4">
                                                        <div class="w-100" v-if="course.banner_full_path != null">
                                                            <img :src="course.banner_full_path" alt="Banner" class="img-fluid rounded-3 mb-2 bg-light p-2 shadow-sm border" style="max-height: 200px; max-width: 100%;">
                                                        </div>
                                                        <label class="form-label"><strong>Course Icon</strong></label>
                                                        <input type="file" class="form-control" name="file" @change="attachFile($event)" accept="image/*">
                                                        <input type="hidden" name="banner" v-model="course.banner">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Title</strong></label>
                                                        <input type="text" class="form-control" name="title" v-model="course.title" placeholder="Title">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Type</strong></label>
                                                        <select class="form-select" name="type" v-model="course.type" @change="course.type === 'premium' ? course.category = 'private' : course.category = 'public'">
                                                            <option value="free">Free</option>
                                                            <option value="premium">Premium</option>
                                                        </select>
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Category</strong></label>
                                                        <select class="form-select" name="category" v-model="course.category" @change="course.category === 'public' ? course.type = 'free' : ''">
                                                            <option value="public">Public</option>
                                                            <option value="private">Private</option>
                                                        </select>
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Course Certificate</strong></label>
                                                        <select class="form-select" name="certificate" v-model="course.certificate">
                                                            <option value="0">No Certificate</option>
                                                            <option value="1">Final Exam Certificate</option>
                                                        </select>
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Description</strong></label>
                                                        <textarea class="form-control" name="description" v-model="course.description" placeholder="Course short description"></textarea>
                                                        <div class="error-report text-danger"></div>
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
    </div>
</template>


<script>
import ApiService from "../../services/ApiService";
import {createToaster} from "@meforma/vue-toaster";
import ApiRoutes from "@/admin/services/ApiRoutes";

const Toaster = createToaster({position: 'top-right'});

export default {
    data() {
        return {
            Loading: false,
            course: {
                type: 'free',
                category: 'public',
                title: '',
                slug: '',
                description: '',
                certificate: '0',
                banner: null,
                banner_full_path: null,
            }
        }
    },
    methods: {
        CreateCourse() {
            this.Loading = true;
            ApiService.ClearErrorHandler();
            ApiService.POST('/api/secure/admin/evaluation/awareness/create', this.course, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    Toaster.success(res.msg);
                    this.$router.push({name: 'Awareness'})
                } else {
                    ApiService.ErrorHandler(res.error);
                }
            })
        },
        attachFile: function (event) {
            let file = event.target.files[0];
            let formData = new FormData();
            formData.append("file", file);
            formData.append("media_type", 1);
            this.Loading = true;
            ApiService.UPLOAD(ApiRoutes.MEDIA, formData, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.course.banner = res.data.file_path;
                    this.course.banner_full_path = res.data.full_file_path;
                }
            })
        }

    },
    created() {
    },
    mounted() {
    }
};
</script>
