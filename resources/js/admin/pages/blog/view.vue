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
                        <h4 class="m-0"><strong class="text-dark">Blog Pages</strong></h4>
                    </div>
                    <div class="card-body">
                        <sections_menu></sections_menu>
                    </div>
                </div>
            </div>
            <div class="col-xl-10 col-md-8">

            <div class="card question-holder">
                <div class="card-header bg-white py-3 d-flex justify-content-between sticky-top">
                    <h1 class="m-0 text-dark">
                        {{ blog.title }}
                    </h1>
                    <h6 class="badge bg-primary">{{ blog.status }}</h6>
                </div>
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="w-100 p-4 border">
                                <div class="row">
                                    <div class="col">
                                        <p v-html="blog.content"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
</template>


<script>
import sections_menu from "@/admin/pages/blog/cms/left_menu.vue";
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
            blog_id: this.$route.params.blog_id,
            blog: {}
        };
    },
    methods: {
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
