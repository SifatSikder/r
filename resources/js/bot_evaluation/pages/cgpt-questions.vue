<template>

    <form class="w-100" id="SubmitQuestions" @submit.prevent="SubmitQuestions">
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <h3 class="text-center text-secondary m-0"><strong>Risk Evaluation Process</strong></h3>
            </div>
            <div class="card-body bg-light py-3 px-4">

                <div class="w-100 text-center mb-3" v-if="questions.length > 0">
                    <p class="btn btn-primary py-2 px-5 rounded-pill d-inline-block m-0 mb-2"><strong>Demo Evaluation</strong></p>
                </div>
                <div class="w-100 mb-3">

                    <div class="eachQuestions w-100 bg-white rounded shadow mb-4 p-4" v-for="(q, i) in questions">
                        <div class="w-100">
                            <h5 class="m-0 p-0 mt-2">
                                <strong>{{ i + 1 }}. <span v-html="q.question"></span></strong>
                                <a href="javascript:void(0)" class="text-primary ms-2" v-if="q.question_hints !== ''"
                                   data-bs-container="body"
                                   data-bs-toggle="popover"
                                   data-bs-placement="top"
                                   :title="q.question"
                                   :data-bs-content="q.question_hints">
                                    <i class="fa fa-fw fa-info-circle"></i>
                                </a>
                            </h5>
                        </div>
                        <div class="w-100">
                            <div class="row">
                                <div class="col-xl-12 mt-3">

                                    <div class="w-100">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="list-unstyled px-2 px-lg-5">
                                                    <li class="mt-3" v-if="q.option_1.title !== ''">
                                                        <p class="text-dark m-0 p-0"><span v-html="q.option_1.title"></span></p>
                                                        <div class="w-100 mt-2 custom-radio-checkbox">
                                                            <div class="form-check form-check-inline ps-0">
                                                                <input class="form-check-input-custom"
                                                                       :name="q._id+'_q1'" type="radio" :id="'qCheck1Y'+i" value="0" required>
                                                                <label class="form-check-label" :for="'qCheck1Y'+i">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline ps-0">
                                                                <input class="form-check-input-custom"
                                                                       :name="q._id+'_q1'" type="radio" :id="'qCheck1N'+i" :value="q.option_1.risk_value" required>
                                                                <label class="form-check-label"
                                                                       :for="'qCheck1N'+i">No</label>
                                                            </div>
                                                            <div class="form-check form-check-inline ps-0">
                                                                <input class="form-check-input-custom" :name="q._id+'_q1'" type="radio" :id="'qCheck1NA'+i" value="-1" required>
                                                                <label class="form-check-label" :for="'qCheck1NA'+i">NA</label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <template v-if="q.type === 'Multiple_Answers'">
                                                        <li class="mt-5" v-if="q.option_2.title !== ''">
                                                            <p class="text-dark m-0 p-0"><span v-html="q.option_2.title"></span></p>
                                                            <div class="w-100 mt-2 custom-radio-checkbox">
                                                                <div class="form-check form-check-inline ps-0">
                                                                    <input class="form-check-input-custom" :name="q._id+'_q2'" type="radio" :id="'qCheck2Y'+i" value="0" required>
                                                                    <label class="form-check-label" :for="'qCheck2Y'+i">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline ps-0">
                                                                    <input class="form-check-input-custom"
                                                                           :name="q._id+'_q2'" type="radio" :id="'qCheck2N'+i" :value="q.option_2.risk_value" required>
                                                                    <label class="form-check-label"
                                                                           :for="'qCheck2N'+i">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline ps-0">
                                                                    <input class="form-check-input-custom" :name="q._id+'_q2'" type="radio" :id="'qCheck2NA'+i" value="-1" required>
                                                                    <label class="form-check-label" :for="'qCheck2NA'+i">NA</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="mt-5" v-if="q.option_3.title !== ''">
                                                            <p class="text-dark m-0 p-0"><span v-html="q.option_3.title"></span></p>
                                                            <div class="w-100 mt-2 custom-radio-checkbox">
                                                                <div class="form-check form-check-inline ps-0">
                                                                    <input class="form-check-input-custom" :name="q._id+'_q3'" type="radio" :id="'qCheck3Y'+i" value="0" required>
                                                                    <label class="form-check-label" :for="'qCheck3Y'+i">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline ps-0">
                                                                    <input class="form-check-input-custom"
                                                                           :name="q._id+'_q3'" type="radio" :id="'qCheck3N'+i" :value="q.option_3.risk_value" required>
                                                                    <label class="form-check-label"
                                                                           :for="'qCheck3N'+i">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline ps-0">
                                                                    <input class="form-check-input-custom" :name="q._id+'_q3'" type="radio" :id="'qCheck3NA'+i" value="-1" required>
                                                                    <label class="form-check-label" :for="'qCheck3NA'+i">NA</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="mt-5" v-if="q.option_4.title !== ''">
                                                            <p class="text-dark m-0 p-0"><span v-html="q.option_4.title"></span></p>
                                                            <div class="w-100 mt-2 custom-radio-checkbox">
                                                                <div class="form-check form-check-inline ps-0">
                                                                    <input class="form-check-input-custom" :name="q._id+'_q4'" type="radio" :id="'qCheck4Y'+i" value="0" required>
                                                                    <label class="form-check-label" :for="'qCheck4Y'+i">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline ps-0">
                                                                    <input class="form-check-input-custom"
                                                                           :name="q._id+'_q4'" type="radio" :id="'qCheck4N'+i" :value="q.option_4.risk_value" required>
                                                                    <label class="form-check-label"
                                                                           :for="'qCheck4N'+i">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline ps-0">
                                                                    <input class="form-check-input-custom" :name="q._id+'_q4'" type="radio" :id="'qCheck4NA'+i" value="-1" required>
                                                                    <label class="form-check-label" :for="'qCheck4NA'+i">NA</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </template>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="card-footer py-3 d-flex align-items-center justify-content-between">
                <a @click="goBack" class="btn btn-lg btn-outline-secondary rounded-pill px-5">Back</a>
                <button type="submit" class="btn btn-lg btn-success rounded-pill px-5" :disabled="questions.length === 0">Next</button>
            </div>
        </div>
    </form>

</template>


<script>
import ApiService from "../services/ApiService";
import ApiRoutes from "../services/ApiRoutes";

export default {
    data() {
        return {
            questions: [],
            bot_evaluation: null
        }
    },
    computed: {},
    watch: {},
    methods: {
        getQuestions() {
            let THIS = this;
            this.questions.length = 0;
            ApiService.POST(ApiRoutes.EvaluationNonTechnicalQuestions, {}, (res) => {
                if (parseInt(res.status) === 200) {
                    THIS.questions = res.data;
                    window.scrollTo(0, 0);

                    setTimeout(function (){
                        const ptl = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                        ptl.map(function (el) { return new bootstrap.Popover(el, {trigger: 'hover'}) })
                    }, 1000);

                }
            })
        },
        SubmitQuestions() {
            let THIS = this;
            const object = {};
            const formData = new FormData(document.getElementById('SubmitQuestions'));
            formData.forEach(function (value, key) {
                object[key] = value;
            });
            THIS.bot_evaluation.answers['cgpt'] = object;
            localStorage.setItem('bot_evaluation', JSON.stringify(THIS.bot_evaluation));
            THIS.$router.push({name: 'AlmostDone'})
        },
        goBack() {
            this.$router.push({name: 'AskAiSystems'})
        }
    },
    created() {
        this.getQuestions();
        if (localStorage.getItem('bot_evaluation') == null) {
            this.$router.push({name: 'ProjectIntro'})
        } else {
            this.bot_evaluation = JSON.parse(localStorage.getItem('bot_evaluation'));
            this.bot_evaluation.category = 'cgpt';
        }
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

