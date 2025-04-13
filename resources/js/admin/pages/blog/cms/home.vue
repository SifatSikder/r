<template>
    <div class="container-lg">

        <div class="w-100 bg-white p-3 shadow mb-4 d-flex justify-content-between align-items-center">
            <h4 class="m-0 p-0">News & Events</h4>
            <router-link class="btn btn-primary rounded-pill px-3 btn-sm" :to="{name: 'CreateBlog'}">New Blog</router-link>
        </div>

        <div class="body-loading" v-if="Loading === true">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-3x fa-spin fa-cog text-theme"></i> <br> Please Wait ...
            </div>
        </div>

        <div class="w-100">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6" v-for="(dt, index) in blog">
                    <div class="eachBlog w-100 bg-white p-2 shadow mb-4">
                        <img :src="dt.banner_full_path" alt="">
                        <h5 class="py-2"><router-link :to="{name: 'EditBlog', params: {blog_id: dt._id}}" class="text-secondary text-decoration-none"><strong>{{ dt.title }}...</strong></router-link></h5>
                        <p class="text-secondary">{{ dt.content }}</p>
                        <p class="m-0 d-flex justify-content-between align-items-center">
                            <router-link class="btn btn-sm btn-primary py-1 rounded-pill" :to="{name: 'EditBlog', params: {blog_id: dt._id}}">Edit</router-link>
                            <span class="badge rounded-pill text-uppercase" :class="{
                                'bg-secondary': dt.status === 'draft',
                                'bg-success': dt.status === 'published',
                                'bg-warning': dt.status === 'archived'}">
                                {{ dt.status }}
                            </span>
                        </p>
                    </div>
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
            blog: []
        };
    },
    methods: {
        getBlogList: function () {
            const THIS = this;
            this.Loading = true;
            ApiService.GET(ApiRoutes.BlogList, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    THIS.blog = res.data;
                }
            })
        }
    },
    created() {
        this.getBlogList();
    },
    mounted() {
    }
};
</script>
