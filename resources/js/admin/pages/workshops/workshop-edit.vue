<template>
    <div class="container-lg">
        <div class="w-100">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 col-md-12">

                    <form class="w-100" @submit.prevent="UpdateWorkshop">
                        <div class="card question-holder">
                            <div class="card-header bg-white py-3 d-flex justify-content-between sticky-top">
                                <h4 class="m-0"><strong class="text-dark">Update Workshop</strong></h4>
                                <div class="">
                                    <router-link class="btn btn-sm btn-secondary rounded-pill px-3 me-2" :to="{name: 'Workshops'}">Cancel</router-link>
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Save Changes</button>
                                </div>
                            </div>
                            <div class="card-body p-2 p-lg-5" v-if="workshop !== null">
                                <div class="row">
                                    <div class="col-lg-12 mb-1">
                                        <div class="w-100 p-4">
                                            <div class="error-report-g"></div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Code</strong></label>
                                                        <input type="text" class="form-control" name="code" v-model="workshop.code" placeholder="Code">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Title</strong></label>
                                                        <input type="text" class="form-control" name="title" v-model="workshop.title" placeholder="Title">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Venue</strong></label>
                                                        <input type="text" class="form-control" name="venue" v-model="workshop.venue" placeholder="Venue">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Date</strong></label>
                                                        <flat-pickr
                                                            v-model="workshop.date"
                                                            :config="dateConfig"
                                                            class="form-control"
                                                            placeholder="Select date"
                                                            name="date"/>
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
            dateConfig: {
                disableMobile: true,
                altInput: true,
                altFormat: "d M, Y",
                minDate: new Date()
            }
        }
    },
    methods: {
        UpdateWorkshop() {
            this.Loading = true;
            ApiService.ClearErrorHandler();
            ApiService.POST(ApiRoutes.UpdateWorkshop, this.workshop, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    Toaster.success(res.msg);
                    this.$router.push({name: 'Workshops'})
                } else {
                    ApiService.ErrorHandler(res.error);
                }
            })
        },
        getWorkshop() {
            this.Loading = true;
            ApiService.POST(ApiRoutes.GetWorkshop, {workshop_id: this.workshop_id}, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.workshop = res.data;
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
