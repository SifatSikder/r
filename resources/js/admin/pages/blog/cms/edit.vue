<template>
    <div class="container-lg">
        <div class="w-100">
            <div class="body-loading" v-if="Loading === true">
                <div class="w-100 text-center">
                    <i class="fa fa-fw fa-3x fa-spin fa-cog text-theme"></i> <br> Please Wait ...
                </div>
            </div>
            <div class="row">
<!--                <div class="col-xl-2 col-md-4">-->
<!--                    <div class="card mb-4 sticky-top">-->
<!--                        <div class="card-header bg-white py-3">-->
<!--                            <h4 class="m-0"><strong class="text-dark">Blog Pages</strong></h4>-->
<!--                        </div>-->
<!--                        <div class="card-body">-->
<!--                            <sections_menu></sections_menu>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="col-xl-10 offset-xl-1 col-md-12">

                    <form class="w-100" @submit.prevent="upsertBlog">
                        <div class="card question-holder">
                            <div class="card-header bg-white py-3 d-flex justify-content-between sticky-top">
                                <h4 class="m-0"><strong class="text-dark">Update Blog</strong></h4>
                                <div class="">
                                    <router-link class="btn btn-sm btn-secondary rounded-pill px-3 me-2" :to="{name: 'BlogList'}">Cancel</router-link>
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Save Changes</button>
                                </div>
                            </div>
                            <div class="card-body p-2 p-lg-5">
                                <div class="row">
                                    <div class="col-lg-12 mb-1">
                                        <div class="w-100 p-4 border">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group" :class="{'d-none': !blog.banner}"
                                                         v-if="blog.banner !== null">
                                                        <img :src="blog.banner_full_path"
                                                             style="max-width: 100%; height: 150px;border-radius: 20px">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label"><strong>Banner</strong></label>
                                                        <input type="file" class="form-control" name="banner"
                                                               @change="attachFile">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label"><strong>Status</strong></label>
                                                    <select class="form-select" name="is-published"
                                                            v-model="blog.status">
                                                        <option value="draft">Draft</option>
                                                        <option value="archived">Archived</option>
                                                        <option value="published">Published</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-1">
                                        <div class="w-100 p-4 border">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label"><strong>Blog Title</strong></label>
                                                        <input type="text" class="form-control" name="blog_title"
                                                               v-model="blog.title" placeholder="Blog Title">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-1">
                                        <div class="w-100 p-4 border">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label class="form-label"><strong>Blog Content</strong></label>
                                                    <QuillEditor v-model:content="blog.content" contentType="html"
                                                                 theme="snow" toolbar="full" style="height: 600px"/>
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
import sections_menu from "@/admin/pages/blog/cms/left_menu.vue";
import ApiService from "../../../services/ApiService";
import ApiRoutes from "../../../services/ApiRoutes";
import {createToaster} from "@meforma/vue-toaster";

const Toaster = createToaster({position: 'top-right'});
import {QuillEditor} from '@vueup/vue-quill'

export default {
    components: {
        sections_menu, QuillEditor
    },
    data() {
        return {
            Loading: false,
            blog_id: this.$route.params.blog_id,
            blog: {}
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
                    this.blog.banner = res.data.file_path;
                    this.blog.banner_full_path = res.data.full_file_path;
                }
            })
        },
        upsertBlog() {
            this.Loading = true;
            ApiService.PUT(ApiRoutes.UpdateBlog + '/' + this.blog_id, this.blog, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    Toaster.success(res.msg);
                }
            })
        },
        getBlog: function () {
            const THIS = this;
            this.Loading = true;
            ApiService.GET(ApiRoutes.ViewBlog + '/' + this.blog_id, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    THIS.blog = res.data;
                }
            })
        }
    },
    created() {
        this.getBlog();
    },
    mounted() {
    }
};
</script>
