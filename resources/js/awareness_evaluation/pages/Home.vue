<template>

    <div class="w-100" v-if="type != null">

        <div class="card shadow" v-if="current_section_data !== null">
            <div class="card-header py-3">
                <h3 class="m-0"><strong>{{ current_section + 1 }}. {{ current_section_data.title }}</strong></h3>
            </div>
            <div id="scrollSlate" class="card-body p-4" style="height: 60vh; overflow-y: auto;">

                <div class="w-100">

                    <div class="w-100">

                        <div class="w-100" v-if="current_section_state === 1">
                            <div class="w-100" v-html="current_section_data.description"></div>
                        </div>
                        <div class="w-100" v-if="current_section_state === 2">

                            <div class="w-100">
                                <div class="eachQuestions w-100 bg-white rounded border shadow-sm mb-4 p-4" v-for="(q, i) in current_section_data.questions">
                                    <div class="w-100">
                                        <h4 class="fw-light text-dark mb-3">
                                            <strong>{{ i + 1 }}. <span v-text="q.question"></span></strong>
                                        </h4>
                                    </div>
                                    <div class="w-100 ps-4">
                                        <div class="w-100 mt-2 custom-radio-checkbox">
                                            <div class="form-check form-check-inline ps-0">
                                                <input class="form-check-input-custom" value="1" :name="q._id+'_q1'" type="radio" :id="'q1Check'+i" required @change="q.answer = '1'" :checked="q.answer === '1'">
                                                <label class="form-check-label fs-5 fw-light text-dark" :for="'q1Check'+i">{{ q.option_1 }}</label>
                                            </div>
                                        </div>
                                        <div class="w-100 mt-2 custom-radio-checkbox">
                                            <div class="form-check form-check-inline ps-0">
                                                <input class="form-check-input-custom" value="2" :name="q._id+'_q1'" type="radio" :id="'q2Check'+i" required @change="q.answer = '2'" :checked="q.answer === '2'">
                                                <label class="form-check-label fs-5 fw-light text-dark" :for="'q2Check'+i">{{ q.option_2 }}</label>
                                            </div>
                                        </div>
                                        <div class="w-100 mt-2 custom-radio-checkbox">
                                            <div class="form-check form-check-inline ps-0">
                                                <input class="form-check-input-custom" value="3" :name="q._id+'_q1'" type="radio" :id="'q3Check'+i" required @change="q.answer = '3'" :checked="q.answer === '3'">
                                                <label class="form-check-label fs-5 fw-light text-dark" :for="'q3Check'+i">{{ q.option_3 }}</label>
                                            </div>
                                        </div>
                                        <div class="w-100 mt-2 custom-radio-checkbox">
                                            <div class="form-check form-check-inline ps-0">
                                                <input class="form-check-input-custom" value="4" :name="q._id+'_q1'" type="radio" :id="'q4Check'+i" required @change="q.answer = '4'" :checked="q.answer === '4'">
                                                <label class="form-check-label fs-5 fw-light text-dark" :for="'q4Check'+i">{{ q.option_4 }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>

                </div>

            </div>
            <div class="card-footer py-3">
                <a v-if="isPreviousExist()" @click="previousSection()" class="btn btn-secondary pull-left px-4 me-2">Back</a>
                <a v-if="!isLast()" @click="nextSection()" class="btn btn-primary pull-right px-4">Next</a>
                <a v-if="isLast()" @click="submitEvaluation()" class="btn btn-primary pull-right px-4">Submit</a>
            </div>
        </div>

        <div class="card shadow" v-if="evaluation_loading === 1">
            <div class="card-header py-3">
                <p class="text-center m-0">We are almost done!</p>
                <h3 class="text-center m-0">Running Evaluation Process</h3>
            </div>
            <div class="card-body p-5">
                <div class="w-100 text-center mb-5" v-if="evaluation_loading_step === 1">
                    <div class="alert alert-warning">
                        <strong>Processing Your Submitted Answers...</strong>
                        <div class="progress border border-warning rounded-pill mt-3">
                            <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" :style="{width: evaluation_loading_progress+'%'}"></div>
                        </div>
                    </div>
                </div>
                <div class="w-100 text-center mb-5" v-if="evaluation_loading_step === 2">
                    <div class="alert alert-primary">
                        <strong>Evaluating For Specific Sector...</strong>
                        <div class="progress border border-primary rounded-pill mt-3">
                            <div class="progress-bar progress-bar-striped bg-primary progress-bar-animated" :style="{width: evaluation_loading_progress+'%'}"></div>
                        </div>
                    </div>
                </div>
                <div class="w-100 text-center" v-if="evaluation_loading_step === 3">
                    <div class="alert alert-success">
                        <strong>Comparing correct answers...</strong>
                        <div class="progress border border-success rounded-pill mt-3">
                            <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" :style="{width: evaluation_loading_progress+'%'}"></div>
                        </div>
                    </div>
                </div>
                <div class="w-100 text-center" v-if="evaluation_loading_step === 4">
                    <div class="alert alert-success">
                        <strong>Generating Visual Report of Evaluation </strong>
                        <div class="progress border border-success rounded-pill mt-3">
                            <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" :style="{width: evaluation_loading_progress+'%'}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-100" v-if="results.length > 0 && evaluation_loading === 0">
            <div class="card mb-4" v-for="(section, index) in results">
                <div class="card-header py-3">
                    <h4 class="m-0 p-0">{{ index+1 }}. {{ section.title }}</h4>
                </div>
                <div class="card-body" style="min-height: 150px">
                    <div class="w-100">
                        <div class="w-100" v-for="(question, qIndex) in section.questions">
                            <div class="rounded-pill cursor_pointer border shadow hover-opacity d-flex align-items-center justify-content-center position-relative m-1"
                                :class="{'bg-success': question.result === 1, 'bg-danger': question.result === 0}"
                                 style="height: 60px;width: 60px;float: left">
                                <strong class="text-uppercase text-white">{{ qIndex+1 }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>


<script>
import ApiService from "../services/ApiService";
import ApiRoutes from "../services/ApiRoutes";
import {createToaster} from "@meforma/vue-toaster";

const Toaster = createToaster({position: 'top-right'});

export default {
    data() {
        return {
            type: null,
            sections: [],
            current_type: "",
            current_section: 0,
            current_section_data: null,
            current_section_state: 1, // 1: Preview Content, 2: Answer Questions
            evaluation_loading: 0,
            evaluation_loading_step: 1,
            evaluation_loading_progress: 1,
            results: []
        }
    },
    computed: {},
    watch: {},
    methods: {
        getEvaluation(type) {
            let THIS = this;
            THIS.current_type = type;
            ApiService.GET(ApiRoutes.EvaluationSections + '/' + THIS.current_type, function (res) {
                THIS.sections = res.data;
                THIS.current_section = 0;
                THIS.current_section_data = THIS.sections[THIS.current_section];
                THIS.current_section_state = 1;
            });
        },
        previousSection() {
            if (this.current_section_state === 2) {
                this.current_section_state = 1;
            } else {
                if (this.current_section > 0) {
                    this.current_section_state = 2;
                    this.current_section--;
                    this.current_section_data = this.sections[this.current_section];
                }
            }
            document.getElementById('scrollSlate').scrollTo(0, 0);
        },
        nextSection() {
            if (this.current_section_state === 1) {
                this.current_section_state = 2;
            } else {
                if (this.currentSectionAnswerValidation()) {
                    this.current_section++;
                    this.current_section_data = this.sections[this.current_section];
                    this.current_section_state = 1;
                } else {
                    Toaster.error("Please answer all questions before proceeding to next section.");
                }
            }
            document.getElementById('scrollSlate').scrollTo(0, 0);
        },
        isPreviousExist() {
            return this.current_section > 0 || this.current_section_state === 2;
        },
        isLast() {
            return this.current_section === this.sections.length - 1 && this.current_section_state === 2;
        },
        currentSectionAnswerValidation() {
            let questions = this.current_section_data.questions;
            let isAllAnswered = true;
            questions.forEach(function (q) {
                if (q.answer === "") {
                    isAllAnswered = false;
                }
            });
            return isAllAnswered;
        },
        showEvaluationLoading: function (step) {
            if (step <= 4) {
                this.evaluation_loading_progress = 0;
                this.evaluation_loading_step = step;
                setTimeout(() => {
                    this.evaluation_loading_progress = 30;
                    setTimeout(() => {
                        this.evaluation_loading_progress = 50;
                        setTimeout(() => {
                            this.evaluation_loading_progress = 75;
                            setTimeout(() => {
                                this.evaluation_loading_progress = 90;
                                setTimeout(() => {
                                    this.evaluation_loading_progress = 100;
                                    setTimeout(() => {
                                        this.showEvaluationLoading(step + 1);
                                    }, 1000)
                                }, 1000)
                            }, 1000)
                        }, 1000)
                    }, 1000)
                }, 1000)
            } else {
                this.evaluation_loading = 0;
            }
        },
        submitEvaluation() {
            let THIS = this;
            if (THIS.currentSectionAnswerValidation()) {

                let param = {};
                THIS.sections.forEach((section) => {
                    section.questions.forEach((question) => {
                        param['section_'+section.id+'_question_'+question._id] = question.answer;
                    });
                });

                THIS.current_section_data = null;
                THIS.evaluation_loading = 1;
                THIS.showEvaluationLoading(1);
                ApiService.POST(ApiRoutes.EvaluationSections + '/' + THIS.current_type, param, function (res) {
                    THIS.results = res.data;
                });

            } else {
                Toaster.error("Please answer all questions before proceeding to next section.");
            }
        }
    },
    created() {
        this.type = this.$route.params.type;
        if (this.type === 'learners-and-teachers') {
            this.getEvaluation('lnt');
        } else if (this.type === 'people') {
            this.getEvaluation('plp');
        } else {
            window.location.href = '/awareness';
        }
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

