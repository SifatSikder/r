<template>

    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <form class="w-100">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <p class="text-center m-0">We are almost done!</p>
                        <h3 class="text-center m-0">Risk Evaluation Process</h3>
                    </div>
                    <div class="card-body p-5">

                        <div class="w-100 text-center mb-5" v-if="loadingStep === 1">
                            <div class="alert alert-warning">
                                <strong>Processing Your Submitted Answers...</strong>
                                <div class="progress border border-warning rounded-pill mt-3">
                                    <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" :style="{width: progress+'%'}"></div>
                                </div>
                            </div>
                        </div>

                        <div class="w-100 text-center mb-5" v-if="loadingStep === 2">
                            <div class="alert alert-primary">
                                <strong>Evaluating Risk For Specific Sector...</strong>
                                <div class="progress border border-primary rounded-pill mt-3">
                                    <div class="progress-bar progress-bar-striped bg-primary progress-bar-animated" :style="{width: progress+'%'}"></div>
                                </div>
                            </div>
                        </div>

                        <div class="w-100 text-center" v-if="loadingStep === 3">
                            <div class="alert alert-success">
                                <strong>Measuring the Risk...</strong>
                                <div class="progress border border-success rounded-pill mt-3">
                                    <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" :style="{width: progress+'%'}"></div>
                                </div>
                            </div>
                        </div>

                        <div class="w-100 text-center" v-if="loadingStep === 4">
                            <div class="alert alert-success">
                                <strong>Generating Visual Report of Risk Evaluation </strong>
                                <div class="progress border border-success rounded-pill mt-3">
                                    <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" :style="{width: progress+'%'}"></div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>

</template>


<script>
import ApiService from "../services/ApiService";
import ApiRoutes from "../services/ApiRoutes";

export default {
    data() {
        return {
            bot_evaluation: null,
            loadingStep: 1,
            progress: 0,
            evaluation_id: 0
        }
    },
    computed: {},
    watch: {},
    methods: {
        submitRisk: function () {
            ApiService.POST(ApiRoutes.RiskSubmit, {bot_evaluation: this.bot_evaluation}, function (res) {
                localStorage.clear();
                if (res.guest_id !== null) {
                    window.location.href = '/bot/evaluation/report/'+res.guest_id;
                }
            })
        },
        showLoading: function (step) {
            if (step <= 4) {
                this.progress = 0;
                this.loadingStep = step;
                setTimeout(() => {
                    this.progress = 30;
                    setTimeout(() => {
                        this.progress = 50;
                        setTimeout(() => {
                            this.progress = 75;
                            setTimeout(() => {
                                this.progress = 90;
                                setTimeout(() => {
                                    this.progress = 100;
                                    setTimeout(() => {
                                        this.showLoading(step + 1);
                                    }, 1000)
                                }, 1000)
                            }, 1000)
                        }, 1000)
                    }, 1000)
                }, 1000)
            }
        }
    },
    created() {
        if (localStorage.getItem('bot_evaluation') == null) {
            this.$router.push({name: 'ProjectIntro'})
        } else {
            this.bot_evaluation = JSON.parse(localStorage.getItem('bot_evaluation'));
            this.submitRisk();
            this.showLoading(1);
        }
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

