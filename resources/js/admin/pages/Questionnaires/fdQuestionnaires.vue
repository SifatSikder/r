<template>
    <div class="w-100">
        <div class="body-loading" v-if="Loading === true">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-3x fa-spin fa-cog text-theme"></i> <br> Please Wait ...
            </div>
        </div>
        <div class="row">
            <div class="col-xl-10 offset-xl-1 col-md-8 offset-md-2">

                <div class="card question-holder">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h4 class="m-0"><strong class="text-dark">General Fair Decision Analysis Questions</strong></h4>
                    </div>
                    <div class="card-body p-3">

                        <template v-if="questions.length === 0">
                            <h5 class="alert alert-info text-center py-5 m-0">
                                You have no question yet for Fair Decision Evaluation! <br>
                                <br> To create new question please click
                                <a class="btn btn-sm btn-warning rounded-pill" href="javascript:void(0)" @click="addNewQuestion"><i class="fa fa-fw fa-plus"></i> New Question</a>
                            </h5>
                        </template>

                        <div class="accordion" id="EvSystemQuestion">
                            <div class="accordion-item" v-for="(question, qIndex) in questions" :id="'eachQuestion'+qIndex">
                                <h2 class="accordion-header bg-white" :id="'EvSystemQuestion_'+qIndex">
                                    <button class="accordion-button bg-white collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#EvSystemQuestionCollapse_'+qIndex"
                                            aria-expanded="true" aria-controls="collapseOne">
                                        <strong v-if="question.question == ''">Question #{{ qIndex + 1 }}</strong>
                                        <strong v-if="question.question != ''">#{{ qIndex + 1 }} - {{ question.question }}</strong>
                                    </button>
                                </h2>
                                <div :id="'EvSystemQuestionCollapse_'+qIndex" class="accordion-collapse collapse" data-bs-parent="#EvSystemQuestion">
                                    <div class="accordion-body">

                                        <div class="w-100 p-5 bg-light border">
                                            <div class="row">
                                                <!--Question Type-->
                                                <div class="col-xl-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label text-black-50"><strong>Type</strong></label>
                                                        <select class="form-select" name="type" v-model="question.type">
                                                            <option value="">Choose Question Type</option>
                                                            <option :value="type" v-for="(type, index) in questionTypes" :key="'q_'+index"> {{ generate_question_type(type) }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <!--Question-->
                                                    <div class="form-group mb-3">
                                                        <label class="form-label text-black-50"><strong>Question</strong></label>
                                                        <textarea v-model="question.question" name="question" class="form-control" placeholder="Write question here..." style="resize: vertical"></textarea>
                                                    </div>
                                                    <!--Question Topic-->
                                                    <div class="form-group mb-3">
                                                        <label class="form-label text-black-50"><strong>Question Hints</strong></label>
                                                        <input type="text" v-model="question.question_hints" name="question_hints" class="form-control" placeholder="Question Hints">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Regular Answers-->
                                            <div v-if="question.type === 'Regular'" class="col-xl-12">
                                                <div class="form-group">
                                                    <div class="w-100 bg-white p-4 shadow mb-3">
                                                        <div class="w-100 mb-2">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label><strong>Title</strong></label>
                                                                    <input name="option_1[title]" v-model="question.option_1.title" class="form-control" placeholder="Answer Option">
                                                                </div>
                                                                <div class="col-md-4 mt-3">
                                                                    <label><strong>Risk Level</strong></label>
                                                                    <select name="option_1[risk_level]" class="form-select" v-model="question.option_1.risk_level" required>
                                                                        <option value="">Select Risk Level</option>
                                                                        <option value="Low">Low (1-4)</option>
                                                                        <option value="Limited">Limited (5-7)</option>
                                                                        <option value="High">High (8-10)</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4 mt-3">
                                                                    <label><strong>Risk Value</strong></label>
                                                                    <select name="option_1[risk_value]" class="form-select" v-model="question.option_1.risk_value" required>
                                                                        <option value="">Select Risk Value</option>
                                                                        <template v-if="question.option_1.risk_level == 'Low'">
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                            <option value="4">4</option>
                                                                        </template>
                                                                        <template v-if="question.option_1.risk_level == 'Limited'">
                                                                            <option value="5">5</option>
                                                                            <option value="6">6</option>
                                                                            <option value="7">7</option>
                                                                        </template>
                                                                        <template v-if="question.option_1.risk_level == 'High'">
                                                                            <option value="8">8</option>
                                                                            <option value="9">9</option>
                                                                            <option value="10">10</option>
                                                                        </template>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Multiple Answers-->
                                            <div v-if="question.type === 'Multiple_Answers'" class="col-xl-12">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <div class="w-100 bg-white p-4 border mb-3">
                                                                <div class="w-100 mb-2">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label><strong>Title</strong></label>
                                                                            <input name="option_1[title]" v-model="question.option_1.title" class="form-control" placeholder="Answer Option">
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <label><strong>Risk Level</strong></label>
                                                                            <select name="option_1[risk_level]" class="form-select" v-model="question.option_1.risk_level" required>
                                                                                <option value="">Select Risk Level</option>
                                                                                <option value="Low">Low (1-4)</option>
                                                                                <option value="Limited">Limited (5-7)</option>
                                                                                <option value="High">High (8-10)</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <label><strong>Risk Value</strong></label>
                                                                            <select name="option_1[risk_value]" class="form-select" v-model="question.option_1.risk_value" required>
                                                                                <option value="">Select Risk Value</option>
                                                                                <template v-if="question.option_1.risk_level == 'Low'">
                                                                                    <option value="1">1</option>
                                                                                    <option value="2">2</option>
                                                                                    <option value="3">3</option>
                                                                                    <option value="4">4</option>
                                                                                </template>
                                                                                <template v-if="question.option_1.risk_level == 'Limited'">
                                                                                    <option value="5">5</option>
                                                                                    <option value="6">6</option>
                                                                                    <option value="7">7</option>
                                                                                </template>
                                                                                <template v-if="question.option_1.risk_level == 'High'">
                                                                                    <option value="8">8</option>
                                                                                    <option value="9">9</option>
                                                                                    <option value="10">10</option>
                                                                                </template>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <div class="w-100 bg-white p-4 border mb-3">
                                                                <div class="w-100 mb-2">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label><strong>Title</strong></label>
                                                                            <input name="option_2[title]" v-model="question.option_2.title" class="form-control" placeholder="Answer Option">
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <label><strong>Risk Level</strong></label>
                                                                            <select name="option_2[risk_level]" class="form-select" v-model="question.option_2.risk_level" required>
                                                                                <option value="">Select Risk Level</option>
                                                                                <option value="Low">Low (1-4)</option>
                                                                                <option value="Limited">Limited (5-7)</option>
                                                                                <option value="High">High (8-10)</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <label><strong>Risk Value</strong></label>
                                                                            <select name="option_2[risk_value]" class="form-select" v-model="question.option_2.risk_value" required>
                                                                                <option value="">Select Risk Value</option>
                                                                                <template v-if="question.option_2.risk_level == 'Low'">
                                                                                    <option value="1">1</option>
                                                                                    <option value="2">2</option>
                                                                                    <option value="3">3</option>
                                                                                    <option value="4">4</option>
                                                                                </template>
                                                                                <template v-if="question.option_2.risk_level == 'Limited'">
                                                                                    <option value="5">5</option>
                                                                                    <option value="6">6</option>
                                                                                    <option value="7">7</option>
                                                                                </template>
                                                                                <template v-if="question.option_2.risk_level == 'High'">
                                                                                    <option value="8">8</option>
                                                                                    <option value="9">9</option>
                                                                                    <option value="10">10</option>
                                                                                </template>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <div class="w-100 bg-white p-4 border mb-3">
                                                                <div class="w-100 mb-2">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label><strong>Title</strong></label>
                                                                            <input name="option_3[title]" v-model="question.option_3.title" class="form-control" placeholder="Answer Option">
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <label><strong>Risk Level</strong></label>
                                                                            <select name="option_3[risk_level]" class="form-select" v-model="question.option_3.risk_level" required>
                                                                                <option value="">Select Risk Level</option>
                                                                                <option value="Low">Low (1-4)</option>
                                                                                <option value="Limited">Limited (5-7)</option>
                                                                                <option value="High">High (8-10)</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <label><strong>Risk Value</strong></label>
                                                                            <select name="option_3[risk_value]" class="form-select" v-model="question.option_3.risk_value" required>
                                                                                <option value="">Select Risk Value</option>
                                                                                <template v-if="question.option_3.risk_level == 'Low'">
                                                                                    <option value="1">1</option>
                                                                                    <option value="2">2</option>
                                                                                    <option value="3">3</option>
                                                                                    <option value="4">4</option>
                                                                                </template>
                                                                                <template v-if="question.option_3.risk_level == 'Limited'">
                                                                                    <option value="5">5</option>
                                                                                    <option value="6">6</option>
                                                                                    <option value="7">7</option>
                                                                                </template>
                                                                                <template v-if="question.option_3.risk_level == 'High'">
                                                                                    <option value="8">8</option>
                                                                                    <option value="9">9</option>
                                                                                    <option value="10">10</option>
                                                                                </template>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <div class="w-100 bg-white p-4 border mb-3">
                                                                <div class="w-100 mb-2">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label><strong>Title</strong></label>
                                                                            <input name="option_4[title]" v-model="question.option_4.title" class="form-control" placeholder="Answer Option">
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <label><strong>Risk Level</strong></label>
                                                                            <select name="option_4[risk_level]" class="form-select" v-model="question.option_4.risk_level" required>
                                                                                <option value="">Select Risk Level</option>
                                                                                <option value="Low">Low (1-4)</option>
                                                                                <option value="Limited">Limited (5-7)</option>
                                                                                <option value="High">High (8-10)</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <label><strong>Risk Value</strong></label>
                                                                            <select name="option_4[risk_value]" class="form-select" v-model="question.option_4.risk_value" required>
                                                                                <option value="">Select Risk Value</option>
                                                                                <template v-if="question.option_4.risk_level == 'Low'">
                                                                                    <option value="1">1</option>
                                                                                    <option value="2">2</option>
                                                                                    <option value="3">3</option>
                                                                                    <option value="4">4</option>
                                                                                </template>
                                                                                <template v-if="question.option_4.risk_level == 'Limited'">
                                                                                    <option value="5">5</option>
                                                                                    <option value="6">6</option>
                                                                                    <option value="7">7</option>
                                                                                </template>
                                                                                <template v-if="question.option_4.risk_level == 'High'">
                                                                                    <option value="8">8</option>
                                                                                    <option value="9">9</option>
                                                                                    <option value="10">10</option>
                                                                                </template>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Actions-->
                                            <div class="col-xl-12">
                                                <div class="w-100">
                                                    <a class="btn btn-sm btn-success" href="javascript:void(0)" @click="ManageQuestion(question, qIndex)"><i class="fa fa-fw fa-check"></i></a>
                                                    <a class="btn btn-sm btn-danger ms-2" href="javascript:void(0)" @click="removeQuestion(question, qIndex)"><i class="fa fa-fw fa-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <template v-if="questions.length > 0">
                            <div class="w-100 mt-5">
                                <a class="btn btn-warning rounded-pill" href="javascript:void(0)" @click="addNewQuestion"><i class="fa fa-fw fa-plus"></i> New Question</a>
                            </div>
                        </template>

                    </div>
                </div>

            </div>
        </div>
    </div>

</template>

<script>

import ApiService from "../../services/ApiService";
import ApiRoutes from "../../services/ApiRoutes";
import {createToaster} from "@meforma/vue-toaster";
import Swal from "sweetalert2";

const Toaster = createToaster({position: 'top-right'});

export default {
    components: {},
    data() {
        return {
            Loading: false,
            core: window.core,
            questionTypes: window.core.qTypes,
            questions: []
        };
    },
    methods: {
        generate_question_type(type) {
            return type.replace('_', ' ');
        },
        addNewQuestion() {
            this.questions.push({
                _id: null,
                type: 'Regular', //Regular, Multiple_answer
                category: 'fd',
                sector: '',
                group: '',
                question: '',
                question_hints: '',
                option_1: {title: '', desc: '', risk_level: '', risk_value: ''},
                option_2: {title: '', desc: '', risk_level: '', risk_value: ''},
                option_3: {title: '', desc: '', risk_level: '', risk_value: ''},
                option_4: {title: '', desc: '', risk_level: '', risk_value: ''}
            });
            const index = this.questions.length - 1;
            setTimeout(function () {
                new bootstrap.Collapse('#EvSystemQuestionCollapse_' + index, {
                    show: true
                })
            })
        },
        removeQuestion(question, index) {
            Swal.fire({
                title: 'Delete Question',
                text: "Are you sure? You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff005a',
                cancelButtonColor: '#777777',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (question._id === null) {
                        this.questions.splice(index, 1);
                    } else {
                        this.Loading = true;
                        const param = {
                            _id: question._id
                        };
                        ApiService.POST(ApiRoutes.DeleteQuestion, param, (res) => {
                            this.Loading = false;
                            if (parseInt(res.status) === 200) {
                                this.ListQuestions();
                                Toaster.error(res.msg);
                            }
                        })
                    }
                }
            })
        },
        ManageQuestion: function (question) {
            this.Loading = true;
            ApiService.POST(ApiRoutes.ManageQuestion, question, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.ListQuestions();
                    Toaster.success(res.msg);
                }
            })
        },
        ListQuestions: function () {
            this.Loading = true;
            const param = {
                category: 'fd',
                sector: null,
                group: null
            };
            ApiService.POST(ApiRoutes.ListQuestions, param, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.questions = res.data;
                }
            })
        }
    },
    created() {

    },
    mounted() {
        this.ListQuestions();
    }
};
</script>
