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
                        <h4 class="m-0"><strong class="text-dark">Awareness: Learners and Teachers</strong></h4>
                    </div>
                    <div class="card-body p-3">

                        <template v-if="AwarenessSections.length === 0">
                            <h5 class="alert alert-info text-center py-5 m-0">
                                You have no question section yet! <br>
                                <br> <a class="btn btn-sm btn-primary rounded-pill" href="javascript:void(0)"
                                        @click="addNewSection()"><i class="fa fa-fw fa-plus"></i> New Section</a>
                            </h5>
                        </template>


                        <div class="accordion mb-5" id="AwarenessSections">
                            <div v-for="(AwarenessSection, sectionIndex) in AwarenessSections" class="accordion-item" :id="'AwarenessSections_'+sectionIndex">
                                <h2 class="accordion-header bg-white" :id="'eachSections_'+sectionIndex">
                                    <button class="accordion-button bg-white collapsed" type="button"
                                            data-bs-toggle="collapse" :data-bs-target="'#eachSections_collapse_'+sectionIndex"
                                            aria-expanded="true" aria-controls="collapseOne">
                                        <strong><span class="text-secondary">Section #{{ sectionIndex+1 }}:</span> {{ AwarenessSection.title }}</strong>
                                    </button>
                                </h2>
                                <div :id="'eachSections_collapse_'+sectionIndex" class="accordion-collapse collapse"
                                     data-bs-parent="#AwarenessSections">
                                    <div class="accordion-body">

                                        <div class="w-100 p-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label text-black-50"><strong>Section Title</strong></label>
                                                <input name="title" class="form-control" placeholder="Section Title" v-model="AwarenessSection.title">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label text-black-50"><strong>Description</strong></label>
                                                <div class="w-100">
                                                    <QuillEditor theme="snow" v-model:content="AwarenessSection.description" contentType="html"/>
                                                </div>
                                            </div>
                                            <div class="form-group mb-5">
                                                <div class="w-100 text-end">
                                                    <a class="btn btn-sm btn-danger me-2" href="javascript:void(0)" @click="removeSection(AwarenessSection, sectionIndex)">Remove Section</a>
                                                    <a class="btn btn-sm btn-success" href="javascript:void(0)" @click="UpdateSection(AwarenessSection)">Save Changes</a>
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="accordion" :id="'EvSystemQuestion_'+sectionIndex">
                                                    <div class="accordion-item" v-for="(question, qIndex) in AwarenessSection.questions"
                                                         :id="'eachQuestion_'+sectionIndex+'_'+qIndex">
                                                        <h2 class="accordion-header bg-white"
                                                            :id="'EvSystemQuestion_'+sectionIndex+'_'+qIndex">
                                                            <button class="accordion-button bg-white collapsed"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    :data-bs-target="'#EvSystemQuestionCollapse_'+sectionIndex+'_'+qIndex"
                                                                    aria-expanded="true" aria-controls="collapseOne">
                                                                <strong v-if="question.question == ''">Question
                                                                    #{{ qIndex + 1 }}</strong>
                                                                <strong v-if="question.question != ''">#{{ qIndex + 1 }}
                                                                    - {{ question.question }}</strong>
                                                            </button>
                                                        </h2>
                                                        <div :id="'EvSystemQuestionCollapse_'+sectionIndex+'_'+qIndex"
                                                             class="accordion-collapse collapse"
                                                             :data-bs-parent="'#EvSystemQuestion_'+sectionIndex">
                                                            <div class="accordion-body">

                                                                <div class="w-100 p-3 bg-light border">
                                                                    <div class="row">
                                                                        <div class="col-xl-12">
                                                                            <!--Question-->
                                                                            <div class="form-group mb-3">
                                                                                <label class="form-label text-black-50"><strong>Question</strong></label>
                                                                                <textarea v-model="question.question"
                                                                                          name="question"
                                                                                          class="form-control"
                                                                                          placeholder="Write question here..."
                                                                                          style="resize: vertical"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--Multiple Options-->
                                                                    <div class="col-xl-12 mb-4">
                                                                        <div class="row">
                                                                            <div class="col-xl-6">
                                                                                <div class="form-group mb-3">
                                                                                    <label class="form-label text-black-50"><strong>Option (A)</strong></label>
                                                                                    <input name="option_1" v-model="question.option_1" class="form-control" placeholder="Answer Option">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-xl-6">
                                                                                <div class="form-group mb-3">
                                                                                    <label class="form-label text-black-50"><strong>Option (B)</strong></label>
                                                                                    <input name="option_1" v-model="question.option_2" class="form-control" placeholder="Answer Option">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-xl-6">
                                                                                <div class="form-group mb-3">
                                                                                    <label class="form-label text-black-50"><strong>Option (C)</strong></label>
                                                                                    <input name="option_1" v-model="question.option_3" class="form-control" placeholder="Answer Option">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-xl-6">
                                                                                <div class="form-group mb-3">
                                                                                    <label class="form-label text-black-50"><strong>Option (D)</strong></label>
                                                                                    <input name="option_1" v-model="question.option_4" class="form-control" placeholder="Answer Option">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-xl-12">
                                                                                <div class="form-group mb-3">
                                                                                    <label class="form-label text-success"><strong>Correct Answer</strong></label>
                                                                                    <select v-model="question.answer" class="form-select">
                                                                                        <option value="">-- Choose Correct Answer --</option>
                                                                                        <option value="1">Option (A)</option>
                                                                                        <option value="2">Option (B)</option>
                                                                                        <option value="3">Option (C)</option>
                                                                                        <option value="4">Option (D)</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--Actions-->
                                                                    <div class="col-xl-12">
                                                                        <div class="w-100 text-end">
                                                                            <a class="btn btn-sm btn-success" href="javascript:void(0)" @click="ManageQuestion(question, sectionIndex, qIndex)"><i class="fa fa-fw fa-check"></i></a>
                                                                            <a class="btn btn-sm btn-danger ms-2" href="javascript:void(0)" @click="removeQuestion(question, sectionIndex, qIndex)"><i class="fa fa-fw fa-trash"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="w-100 mt-5">
                                                    <a class="btn btn-warning rounded-pill"
                                                       href="javascript:void(0)" @click="addNewQuestion(sectionIndex, AwarenessSection.id)"><i
                                                        class="fa fa-fw fa-plus"></i> New Question</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <template v-if="AwarenessSections.length > 0">
                            <div class="w-100 text-center mb-3">
                                <a class="btn btn-sm btn-primary rounded-pill" href="javascript:void(0)"
                                   @click="addNewSection()"><i class="fa fa-fw fa-plus"></i> New Section</a>
                            </div>
                        </template>

                    </div>
                </div>

            </div>
        </div>
    </div>

</template>

<script>

import ApiService from "../../../services/ApiService";
import ApiRoutes from "../../../services/ApiRoutes";
import {createToaster} from "@meforma/vue-toaster";
import Swal from "sweetalert2";
import {QuillEditor} from '@vueup/vue-quill'

const Toaster = createToaster({position: 'top-right'});

export default {
    components: {QuillEditor},
    data() {
        return {
            Loading: false,
            core: window.core,
            AwarenessSections: [],
            description: "asdf asfas dfasd fasdf asdf"
        };
    },
    methods: {
        addNewSection() {
            this.Loading = true;
            const question = {
                type: 'lnt',
                title: 'Untitled Section',
                description: ''
            };
            ApiService.POST(ApiRoutes.AwarenessEvaluationSectionCreate, question, (res) => {
                this.Loading = false;

                this.AwarenessSections.push(res.data);
                const index = this.AwarenessSections.length - 1;
                setTimeout(function () {
                    new bootstrap.Collapse('#eachSections_collapse_' + index, {
                        show: true
                    })
                })

            })
        },
        UpdateSection(AwarenessSection) {
            this.Loading = true;
            const section = {
                title: AwarenessSection.title,
                description: AwarenessSection.description
            };
            ApiService.POST(ApiRoutes.AwarenessEvaluationSectionUpdate + '/' + AwarenessSection.id, section, (res) => {
                this.Loading = false;
                Toaster.success(res.msg);
            })
        },
        removeSection(AwarenessSection, index) {
            Swal.fire({
                title: 'Delete Section',
                text: "Are you sure? You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff005a',
                cancelButtonColor: '#777777',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.Loading = true;
                    ApiService.GET(ApiRoutes.AwarenessEvaluationSectionDelete + '/' + AwarenessSection.id, (res) => {
                        this.Loading = false;
                        this.AwarenessSections.splice(index, 1);
                        Toaster.success(res.msg);
                    })
                }
            })
        },
        addNewQuestion(index, section_id) {
            this.AwarenessSections[index].questions.push({
                _id: null,
                section_id: section_id,
                question: "",
                option_1: "",
                option_2: "",
                option_3: "",
                option_4: "",
                answer: ""
            });
            const qIndex = this.AwarenessSections[index].questions.length - 1;
            setTimeout(function () {
                new bootstrap.Collapse('#EvSystemQuestionCollapse_' + index + '_' + qIndex, {
                    show: true
                })
            })
        },
        ManageQuestion: function (question, sectionIndex, qIndex) {
            this.Loading = true;
            ApiService.POST(ApiRoutes.AwarenessEvaluationSectionQuestionManage, question, (res) => {
                this.Loading = false;
                this.AwarenessSections[sectionIndex].questions[qIndex] = res.data;
                Toaster.success(res.msg);
            })
        },
        removeQuestion(question, sectionIndex, index) {
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
                    console.log(question);
                    if (question._id === null) {
                        this.AwarenessSections[sectionIndex].questions.splice(index, 1);
                    } else {
                        this.Loading = true;
                        const param = {
                            section_id: question.section_id
                        };
                        ApiService.POST(ApiRoutes.AwarenessEvaluationSectionQuestionDelete+'/'+question._id, param, (res) => {
                            this.Loading = false;
                            this.AwarenessSections[sectionIndex].questions.splice(index, 1);
                            Toaster.error(res.msg);
                        })
                    }
                }
            })
        },
        ListAwarenessSection: function () {
            this.Loading = true;
            ApiService.GET(ApiRoutes.AwarenessEvaluationSections + '/lnt', (res) => {
                this.Loading = false;
                this.AwarenessSections = res.data;
            })
        }
    },
    created() {

    },
    mounted() {
        this.ListAwarenessSection();
    }
};
</script>
