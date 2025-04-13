<template>
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="w-100">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <a @click="goBack" class="btn btn-sm btn-outline-secondary"><i class="fa fa-fw fa-arrow-left"></i> <span class="d-sm-inline d-none">Back</span></a>
                        <h3 class="text-center m-0" v-if="risk_analysis === 'risk'"><strong>Risk Evaluation Process</strong></h3>
                        <h3 class="text-center m-0" v-if="risk_analysis === 'fair'"><strong>Fair Decision Analysis</strong></h3>
                        <a class="invisible"><i class="fa fa-fw fa-arrow-left"></i> <span class="d-sm-inline d-none">Back</span></a>
                    </div>
                    <div class="card-body py-3 px-sm-5">

                        <div class="w-100 py-5">
                            <div class="row" v-if="risk_analysis === 'risk'">
                                <div class="col-xl-6 mb-3 mt-3">
                                    <div class="w-100 h-100 text-center p-5 border shadow d-flex flex-column justify-content-between align-items-center">
                                        <h5 class="mb-4">If you want to evaluate general (Hardware, Software, Ethical, Legal) risks <br> please select</h5>
                                        <button @click="openEtQuestions" type="button" class="btn btn-outline-success fs-5 m-2 border border-secondary border-2 rounded py-2" style="width: 200px; height: 50px;"><strong>General Risks</strong></button>
                                    </div>
                                </div>
                                <div class="col-xl-6 mb-3 mt-3">
                                    <div class="w-100 h-100 text-center p-5 border shadow d-flex flex-column justify-content-between align-items-center">
                                        <h5>If you want to evaluate the risks of specific industry <br> please select</h5>
                                        <button @click="openEtaDomain" type="button" class="btn btn-outline-success fs-5 m-2 border border-secondary border-2 rounded py-2" style="width: 200px; height: 50px;"><strong>Specific Industry</strong></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="risk_analysis === 'fair'">
                                <div class="col-xl-6 mb-3 mt-3">
                                    <div class="w-100 h-100 text-center py-5 px-3 border shadow d-flex flex-column justify-content-between align-items-center">
                                        <h5 class="mb-4">If you want to evaluate general fair decision analysis <br> please select</h5>
                                        <button @click="openFdQuestions" type="button" class="btn btn-outline-success fs-5 m-2 border border-secondary border-2 rounded py-2" style="width: 200px; height: 50px;"><strong>General Fairness</strong></button>
                                    </div>
                                </div>
                                <div class="col-xl-6 mb-3 mt-3">
                                    <div class="w-100 h-100 text-center py-5 px-3 border shadow d-flex flex-column justify-content-between align-items-center">
                                        <h5>If you want to analysis the fair decision of specific industry <br> please select</h5>
                                        <button @click="openEtaDomain" type="button" class="btn btn-outline-success fs-5 m-2 border border-secondary border-2 rounded py-2" style="width: 200px; height: 50px;"><strong>Specific Industry</strong></button>
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
import Swal from "sweetalert2";

export default {
    data() {
        return {
            UserInfo: window.core.UserInfo,
            risk_analysis: ''
        }
    },
    computed: {},
    watch: {},
    methods: {
        openEtQuestions: function () {
            this.$router.push({name: 'EtQuestions'})
        },
        openFdQuestions: function () {
            this.$router.push({name: 'fdQuestions'})
        },
        openEtaDomain: function () {
            if(this.UserInfo.subscription_type === 'free'){
                Swal.fire({
                    title: 'Premium Module',
                    text: "You must subscribe to premium plan to have all premium features.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0d9f56',
                    cancelButtonColor: '#777777',
                    confirmButtonText: 'Go to Pricing',
                    cancelButtonText: 'Close'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/pricing';
                    }
                });
            } else {
                this.$router.push({name: 'SafetyRisksDomains'})
            }
        },
        goBack(){
            if(this.risk_analysis === 'fair'){
                this.$router.push({name: 'ProjectIntro'})
            } else {
                this.$router.push({name: 'EtNt'})
            }
        }
    },
    created() {
        if (localStorage.getItem('risk_analysis') != null) {
            this.risk_analysis = localStorage.getItem('risk_analysis');
        } else {
            this.risk_analysis = 'risk';
            localStorage.setItem('risk_analysis', this.risk_analysis);
        }
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

