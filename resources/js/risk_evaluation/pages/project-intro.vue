<template>
    <div class="row">
        <div class="col-xl-8 offset-xl-2">

            <div class="w-100" v-if="risk_form_check() === 0">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h3 class="text-center m-0"><strong>Premium Module</strong></h3>
                    </div>
                    <div class="card-body py-3 px-md-5 px-3">

                        <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex;"><div class="swal2-icon-content">!</div></div>

                        <h5 class="text-center text-dark py-3">You must subscribe to premium plan <br> to have all premium features.</h5>

                        <div class="w-100 text-center mt-3 mb-5">
                            <a href="/pricing" class="btn btn-lg btn-success rounded-pill px-5 ">Choose Premium Plan</a>
                        </div>
                    </div>
                </div>
            </div>
            <form class="w-100" @submit.prevent="submitForm" v-if="risk_form_check() === 1">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h3 class="text-center m-0" v-if="risk_analysis === 'risk'"><strong>Risk Evaluation Process</strong></h3>
                        <h3 class="text-center m-0" v-if="risk_analysis === 'fair'"><strong>Fair Decision Analysis</strong></h3>
                    </div>
                    <div class="card-body py-3 px-md-5 px-3">

                        <div class="w-100 mt-3">
                            <div class="form-group mb-4">
                                <strong class="title_count">{{project.name.length}}/30</strong>
                                <label class="form-label"><strong>Title of the proposed Evaluation</strong></label>
                                <input type="text" class="form-control form-control-lg rounded-pill" @keyup="name_validate" name="name" v-model="project.name" placeholder="Give a short title (Maximum 30 Characters)" required>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label"><strong>Website <small>(Optional)</small></strong></label>
                                <input type="text" class="form-control form-control-lg rounded-pill" name="website" v-model="project.website" placeholder="Please provide your website address">
                            </div>
                            <div class="form-group mb-4">
                                <strong class="title_count">{{project.desc.length}}/200</strong>
                                <label class="form-label"><strong>Short Details (Maximum 200 words) about your evaluation areas <small>(Optional)</small></strong></label>
                                <textarea class="form-control form-control-lg" @keyup="desc_validate" style="border-radius: 20px;padding-right: 85px" name="desc" v-model="project.desc" placeholder="What is the purpose of your evaluation?"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-3 d-flex justify-content-between">
                        <a class=""></a>
                        <button type="submit" class="btn btn-lg btn-success rounded-pill px-5 ">Next</button>
                    </div>
                </div>
            </form>


        </div>
    </div>

</template>


<script>
export default {
    data() {
        return {
            UserInfo: window.core.UserInfo,
            risk_evaluation: {
                category: '',
                project: null,
                evaluation_sector: null,
                evaluation_sub_sector: null,
                answers: {}
            },
            project: {
                name: '',
                website: '',
                desc: '',
            },
            risk_analysis: ''
        }
    },
    computed: {},
    watch: {},
    methods: {
        name_validate() {
            if (this.project.name.length > 30) {
                this.project.name = this.project.name.substring(0, 30);
            }
        },
        desc_validate() {
            if (this.project.desc.length > 200) {
                this.project.desc = this.project.desc.substring(0, 200);
            }
        },
        submitForm: function () {
            this.risk_evaluation.project = this.project;
            localStorage.setItem('risk_evaluation', JSON.stringify(this.risk_evaluation));
            if(this.risk_analysis === 'fair'){
                this.$router.push({name: 'EtEta'})
            } else {
                this.$router.push({name: 'AskAiSystems'})
            }
        },
        risk_form_check() {
            if(this.risk_analysis === 'risk' || this.UserInfo.subscription_type === 'premium'){
                return 1;
            } else {
                return 0;
            }
        }
    },
    created() {
        if (localStorage.getItem('risk_evaluation') != null) {
            this.risk_evaluation = JSON.parse(localStorage.getItem('risk_evaluation'));
            this.project = this.risk_evaluation.project;
        }
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

