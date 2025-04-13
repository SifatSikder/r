<template>
    <div class="container-lg">
        <div class="w-100">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 col-md-12">

                    <div class="w-100">
                        <div class="card question-holder">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                <h4 class="m-0"><strong class="text-secondary">Participation Certificates</strong></h4>
                                <router-link :to="{name: 'ParticipantCertificationSettings'}" class="btn btn-sm btn-primary rounded-pill px-3">Certificate Settings</router-link>
                            </div>
                            <div class="card-body p-2 p-lg-3">
                                <div class="w-100" v-if="certificates.length === 0">
                                    <p class="alert alert-info">No Participant Download certificate yet.</p>
                                </div>
                                <div class="w-100" v-if="certificates.length > 0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Workshop</th>
                                                <th style="width: 150px" class="text-center">Date</th>
                                                <th style="width: 150px"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="cert in certificates">
                                                <td>{{cert.full_name}}</td>
                                                <td>{{cert.email}}</td>
                                                <td>{{cert.workshop.title}}</td>
                                                <td class="text-center">{{cert.created_at}}</td>
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
            certificates: [],
        }
    },
    methods: {
        getWorkshop() {
            this.Loading = true;
            ApiService.POST(ApiRoutes.ParticipantCertificates, {}, (res) => {
                if (parseInt(res.status) === 200) {
                    this.certificates = res.data;
                }
            })
        }

    },
    created() {
        this.getWorkshop()
    },
    mounted() {
    }
};
</script>
