<template>
    <div class="w-100">
        <div class="container">
            <div class="w-100">
                <div class="card-body px-0 py-5" v-if="loading === 0 && evaluations.length === 0">
                    <div class="w-100 text-md-center py-5">
                        <h4 class="text-secondary text-center mb-3">
                            There is no Risk Evaluation History of yours. <br>
                        </h4>
                        <a href="/risk-evaluation/join-now" class="btn rounded-pill btn-warning py-3 px-5 me-3 shadow">
                            <strong>Start Your AI Risk Evaluation</strong>
                        </a>
                    </div>
                </div>
                <div class="card-body py-5" v-if="loading === 0 && evaluations.length > 0">
                    <div class="dash-ai-tools w-100">

                        <div class="row">
                            <div class="col-lg-3">

                                <div class="w-100 position-relative overflow-hidden border border-secondary border-5 mb-4">
                                    <a href="/risk-evaluation/join-now" class="each-ai-tools d-inline-block rounded p-3 cursor_pointer">
                                        <div class="ai-tool-create w-100 h-100 d-flex align-items-center">
                                            <div class="w-100 text-dark text-center">
                                                <p class="m-0"><i class="fa fa-fw fa-3x fa-plus-circle"></i></p>
                                                <h5 class="m-0">New Evaluation</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            </div>
                            <div class="col-lg-3" v-for="(eve, index) in evaluations">

                                <div class="w-100 position-relative overflow-hidden border border-secondary border-5 mb-4">
                                    <div class="analysis_et_ribbon analysis_fd_ribbon" v-if="eve.category === 'fd'">Fair Analysis</div>
                                    <div class="analysis_et_ribbon" v-if="eve.category !== 'fd'">Risk Evaluation</div>
                                    <a @click="removeEvaluation(eve)" class="btn btn-sm btn-danger rounded-pill position-absolute py-2 px-2" style="top: 5px;right: 5px;z-index: 4"><i class="fa fa-fw fa-trash"></i></a>
                                    <router-link :to="{name: 'EvaluationReport', params: {evaluation_id: eve._id}}" class="each-ai-tools d-inline-block rounded p-3 cursor_pointer">
                                        <div class="ai-tool-create w-100 h-100 d-flex align-items-center">
                                            <div class="w-100 text-dark text-center">
                                                <p class="m-0"><i class="fa fa-fw fa-3x fa-pie-chart"></i></p>
                                                <h5 class="m-0">{{ eve.project.name }}</h5>
                                                <p>
                                                    <span class="badge bg-primary" v-if="eve.category === 'et'">General Risk Evaluation</span>
                                                    <span class="badge bg-primary" v-if="eve.category === 'eta'">Specific Industry Risk Evaluation</span>
                                                    <span class="badge bg-primary" v-if="eve.category === 'nt'">Non Tech Risk Evaluation</span>
                                                    <span class="badge bg-info" v-if="eve.category === 'fd'">General Fair Decision</span>
                                                    <span class="badge bg-primary" v-if="eve.category === 'eta-fd'">Specific Industry Fair Decision</span>
                                                </p>
                                            </div>
                                        </div>
                                    </router-link>
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
import Swal from "sweetalert2";

export default {
    data() {
        return {
            loading: 1,
            evaluations: []
        }
    },
    computed: {},
    watch: {},
    methods: {
        user_evaluations: function () {
            const THIS = this;
            THIS.loading = 1;
            ApiService.GET(ApiRoutes.user_evaluations, function (res) {
                THIS.loading = 0;
                if (res.status === 200) {
                    THIS.evaluations = res.data;
                }
            })
        },
        removeEvaluation(evaluation) {
            let THIS = this;
            Swal.fire({
                title: 'Delete Evaluation',
                text: "Are you sure? You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff005a',
                cancelButtonColor: '#777777',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    THIS.loading = 1;
                    ApiService.POST(ApiRoutes.user_evaluation_delete, {evaluation_id: evaluation._id}, function (res) {
                        THIS.loading = 0;
                        if (res.status === 200) {
                            THIS.user_evaluations();
                        }
                    })
                }
            })
        }
    },
    created() {
        localStorage.clear();
        this.user_evaluations();
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>
