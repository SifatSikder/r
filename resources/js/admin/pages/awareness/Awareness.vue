<template>
    <div class="container-lg">

        <div class="w-100 bg-white p-3 shadow mb-4 d-flex justify-content-between align-items-center">
            <input type="text" class="form-control" v-model="keyword" @keyup="searchAwareness" style="width: 300px" placeholder="Search Awareness">
            <router-link class="btn btn-primary rounded-pill px-3 btn-sm" :to="{name: 'AwarenessCreate'}">New Awareness</router-link>
        </div>

        <div class="body-loading" v-if="Loading === true">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-3x fa-spin fa-cog text-theme"></i> <br> Please Wait ...
            </div>
        </div>

        <div class="w-100">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6" v-for="(course, index) in courses">
                    <div class="eachUser w-100 bg-white shadow mb-4">
                        <div class="w-100 px-2 pt-3 d-flex flex-column justify-content-between" style="min-height: 350px">
                            <div class="w-100 py-2 text-center">
                                <div class="w-100 text-center" v-if="course.banner_full_path != null">
                                    <img :src="course.banner_full_path" alt="Banner" class="img-fluid rounded-3 mb-2 bg-light p-2 shadow-sm border" style="max-height: 200px; max-width: 100%;">
                                </div>
                                <span class="badge bg-success me-2">{{ course.type.toUpperCase() }}</span>
                                <span class="badge bg-success">{{ course.category.toUpperCase() }}</span>
                                <br><br>
                                <router-link :to="{name: 'AwarenessPreview', params: {course_id: course._id}}" class="fs-5 text-secondary text-decoration-none"><strong>{{ course.title }}</strong></router-link>
                                <p>{{ course.description }}</p>
                            </div>
                            <div class="w-100 d-flex justify-content-between align-items-center p-2">
                                <router-link :to="{name: 'AwarenessEdit', params:{course_id: course._id}}" class="w-100 btn btn-sm btn-outline-primary rounded-pill me-1">Edit</router-link>
                                <router-link :to="{name: 'AwarenessPreview', params:{course_id: course._id}}" class="w-100 btn btn-sm btn-outline-success rounded-pill me-1">View</router-link>
                                <a @click="deleteAwareness(course)" class="w-100 btn btn-sm btn-outline-danger rounded-pill">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
import ApiService from "../../services/ApiService";
import Swal from "sweetalert2";

export default {
    components: {},
    data() {
        return {
            Loading: false,
            searchTimeout: null,
            keyword: '',
            courses: []
        };
    },
    methods: {
        getAwareness: function () {
            const THIS = this;
            this.Loading = true;
            ApiService.POST('/api/secure/admin/evaluation/awareness/list', {keyword: this.keyword}, (res) => {
                THIS.Loading = false;
                if (parseInt(res.status) === 200) {
                    THIS.courses = res.data;
                }
            })
        },
        searchAwareness: function (){
            if(this.searchTimeout !== null){
                clearTimeout(this.searchTimeout);
            }
            this.searchTimeout = setTimeout(() => {
                clearTimeout(this.searchTimeout);
                this.getUsers();
            }, 1000);
        },
        deleteAwareness(course) {
            Swal.fire({
                title: 'Delete Awareness',
                html: "<strong class='text-danger'>Are you sure?</strong> <br><br> <p class='alert alert-danger'>This action will remove all related information of this Awareness permanently.</p>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff005a',
                cancelButtonColor: '#777777',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    ApiService.DELETE('/api/secure/admin/evaluation/awareness/delete/'+course._id, (res) => {
                        this.Loading = false;
                        if (parseInt(res.status) === 200) {
                            this.getAwareness();
                            Toaster.success(res.msg);
                        }
                    })
                }
            })
        }
    },
    created() {
        this.getAwareness();
    },
    mounted() {
    }
};
</script>
