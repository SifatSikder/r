<template>
    <div class="container-lg">

        <div class="w-100 bg-white p-3 shadow mb-4 d-flex justify-content-between align-items-center">
            <input type="text" class="form-control" v-model="keyword" @keyup="searchWorkshop" style="width: 300px" placeholder="Search Workshop">
            <router-link class="btn btn-primary rounded-pill px-3 btn-sm" :to="{name: 'WorkshopCreate'}">New Workshop</router-link>
        </div>

        <div class="body-loading" v-if="Loading === true">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-3x fa-spin fa-cog text-theme"></i> <br> Please Wait ...
            </div>
        </div>

        <div class="w-100">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6" v-for="(workshop, index) in workshops">
                    <div class="eachUser w-100 bg-white shadow mb-4" :class="{grayscale: workshop.expired === 1}">
                        <div class="w-100 px-2 pt-5 d-flex flex-column justify-content-between" style="min-height: 400px">
                            <div class="w-100 py-2 text-center">
                                <span class="badge bg-success">{{ workshop.code }}</span>
                                <br><br>
                                <router-link :to="{name: 'WorkshopEdit', params: {workshop_id: workshop._id}}" class="fs-5 text-secondary text-decoration-none"><strong>{{ workshop.title }}</strong></router-link>
                            </div>
                            <div class="w-100 text-center mt-5">
                                <span class="fs-6 text-success">{{ workshop.date }}</span>
                                <br>
                                <strong class="fs-6 text-secondary">{{ workshop.venue }}</strong>
                            </div>
                            <div class="w-100 d-flex justify-content-between align-items-center p-2">
                                <router-link :to="{name: 'WorkshopEdit', params:{workshop_id: workshop._id}}" class="w-100 btn btn-sm btn-outline-primary rounded-pill me-1">Edit</router-link>
                                <router-link :to="{name: 'WorkshopPreview', params:{workshop_id: workshop._id}}" class="w-100 btn btn-sm btn-outline-success rounded-pill me-1">View</router-link>
                                <a @click="deleteWorkshop(workshop)" class="w-100 btn btn-sm btn-outline-danger rounded-pill ms-1">Delete</a>
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
import ApiRoutes from "../../services/ApiRoutes";
import Swal from "sweetalert2";

export default {
    components: {},
    data() {
        return {
            Loading: false,
            searchTimeout: null,
            keyword: '',
            workshops: []
        };
    },
    methods: {
        getWorkshops: function () {
            const THIS = this;
            this.Loading = true;
            ApiService.POST(ApiRoutes.Workshops, {keyword: this.keyword}, (res) => {
                THIS.Loading = false;
                if (parseInt(res.status) === 200) {
                    THIS.workshops = res.data;
                }
            })
        },
        searchWorkshop: function (){
            if(this.searchTimeout !== null){
                clearTimeout(this.searchTimeout);
            }
            this.searchTimeout = setTimeout(() => {
                clearTimeout(this.searchTimeout);
                this.getUsers();
            }, 1000);
        },
        deleteWorkshop(workshop) {
            Swal.fire({
                title: 'Delete Workshop',
                html: "<strong class='text-danger'>Are you sure?</strong> <br><br> <p class='alert alert-danger'>This action will remove all related information of this Workshop permanently.</p>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff005a',
                cancelButtonColor: '#777777',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    ApiService.POST(ApiRoutes.DeleteWorkshop, {workshop_id: workshop._id}, (res) => {
                        this.Loading = false;
                        if (parseInt(res.status) === 200) {
                            this.getWorkshops();
                            Toaster.success(res.msg);
                        }
                    })
                }
            })
        }
    },
    created() {
        this.getWorkshops();
    },
    mounted() {
    }
};
</script>
