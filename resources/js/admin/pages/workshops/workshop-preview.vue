<template>
    <div class="container-lg">
        <div class="w-100">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 col-md-12">

                    <div class="w-100" v-if="workshop !== null">
                        <div class="card question-holder">
                            <div class="card-header bg-white py-3">
                                <h4 class="m-0"><strong class="text-secondary">Workshop: <span class="text-success">{{workshop.title}}</span></strong></h4>
                            </div>
                            <div class="card-body p-2 p-lg-3">
                                <div class="w-100">
                                    <span class="badge bg-success">{{ workshop.code }}</span>
                                    <br>
                                    <strong>{{workshop.venue}}</strong>
                                    <br>
                                    <small>{{workshop.date_format}}</small>
                                </div>
                                <div class="w-100 mt-5" v-if="certificates.length == 0">
                                    <p class="alert alert-info">No participant download certificate yet.</p>
                                </div>
                                <div class="w-100 mt-5" v-if="certificates.length > 0">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th style="width: 150px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="cert in certificates">
                                            <td>{{cert.full_name}}</td>
                                            <td>{{cert.email}}</td>
                                            <td class="text-center">
                                                <a target="_blank" class="btn btn-sm rounded-pill btn-success px-3" :href="cert.file_path">Download</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
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
import ApiService from "../../services/ApiService";
import ApiRoutes from "../../services/ApiRoutes";
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import {createToaster} from "@meforma/vue-toaster";
const Toaster = createToaster({position: 'top-right'});

export default {
    components: {
        flatPickr
    },
    data() {
        return {
            Loading: false,
            workshop_id: null,
            workshop: null,
            certificates: [],
            dateConfig: {
                disableMobile: true,
                altInput: true,
                altFormat: "d M, Y",
                minDate: new Date()
            }
        }
    },
    methods: {
        getWorkshopCertificates() {
            this.Loading = true;
            ApiService.POST(ApiRoutes.GetWorkshopCertificates, {workshop_id: this.workshop_id}, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.certificates = res.data;
                }
            })
        },
        getWorkshop() {
            this.Loading = true;
            ApiService.POST(ApiRoutes.GetWorkshop, {workshop_id: this.workshop_id}, (res) => {
                if (parseInt(res.status) === 200) {
                    this.workshop = res.data;
                    this.getWorkshopCertificates()
                }
            })
        }

    },
    created() {
        this.workshop_id = this.$route.params.workshop_id;
        this.getWorkshop()
    },
    mounted() {
    }
};
</script>
