<template>
    <div class="w-100">
        <div class="w-100" v-if="lesson != null">
            <div class="card question-holder">
                <div class="card-body p-3 p-lg-5">
                    <div class="row">

                        <div class="w-100">
                            <h1>{{ lesson.title }}</h1>
                        </div>
                        <div class="w-100 mt-4 ql-editor" v-if="lesson.is_quiz === '0'">
                            <div class="w-100" v-html="lesson.description"></div>
                        </div>

                        <div class="col-lg-12" v-if="lesson.is_quiz === '1'">
                            <div class="w-100 mt-5">
                                <div class="accordion" id="lesson_quiz">
                                    <div class="accordion-item" v-for="(question, qIndex) in lesson.questions" :id="'eachQuestion_'+qIndex">
                                        <h2 class="accordion-header bg-white" :id="'EvSystemQuestion_'+qIndex">
                                            <button class="accordion-button bg-white collapsed"
                                                    type="button" data-bs-toggle="collapse"
                                                    :data-bs-target="'#EvSystemQuestionCollapse_'+qIndex"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                <strong v-if="question.question === ''">Question #{{ qIndex + 1 }}</strong>
                                                <strong v-if="question.question !== ''">#{{ qIndex + 1 }} - {{ question.question }}</strong>
                                            </button>
                                        </h2>
                                        <div :id="'EvSystemQuestionCollapse_'+qIndex"
                                             class="accordion-collapse collapse"
                                             data-bs-parent="#lesson_quiz">
                                            <div class="accordion-body">

                                                <form class="w-100" @submit.prevent="ManageQuestion(question, qIndex)">
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
                                                                              style="resize: vertical" required></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--Multiple Options-->
                                                        <div class="col-xl-12 mb-4">
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label text-black-50"><strong>Option (A)</strong></label>
                                                                        <input name="option_1" v-model="question.option_1" class="form-control" placeholder="Answer Option" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label text-black-50"><strong>Option (B)</strong></label>
                                                                        <input name="option_1" v-model="question.option_2" class="form-control" placeholder="Answer Option" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label text-black-50"><strong>Option (C)</strong></label>
                                                                        <input name="option_1" v-model="question.option_3" class="form-control" placeholder="Answer Option" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label text-black-50"><strong>Option (D)</strong></label>
                                                                        <input name="option_1" v-model="question.option_4" class="form-control" placeholder="Answer Option" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-12">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label text-success"><strong>Correct Answer</strong></label>
                                                                        <select v-model="question.answer" class="form-select" required>
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
                                                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-fw fa-check"></i></button>
                                                                <a class="btn btn-sm btn-danger ms-2" href="javascript:void(0)" @click="removeQuestion(question, qIndex)"><i class="fa fa-fw fa-trash"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-100 mt-5">
                                    <a class="btn btn-warning rounded-pill" href="javascript:void(0)" @click="addNewQuestion()"><i class="fa fa-fw fa-plus"></i> New Question</a>
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
import ApiService from "../../../services/ApiService";
import {createToaster} from "@meforma/vue-toaster";
import Swal from "sweetalert2";

const Toaster = createToaster({position: 'top-right'});

export default {
    data() {
        return {
            Loading: false,
            course_id: null,
            topic_id: null,
            lesson_id: null,
            lesson: null
        }
    },
    methods: {
        getLesson() {
            this.Loading = true;
            ApiService.ClearErrorHandler();
            ApiService.GET('/api/secure/admin/evaluation/awareness/' + this.course_id + '/topic/' + this.topic_id + '/lesson/single/' + this.lesson_id, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.lesson = res.data;
                }
            })
        },
        restartPage() {
            this.course_id = this.$route.params.course_id;
            this.topic_id = this.$route.params.topic_id;
            this.lesson_id = this.$route.params.lesson_id;
            this.getLesson();
            this.$emit('currentLesson', {topic_id: this.topic_id, lesson_id: this.lesson_id});
        },
        addNewQuestion() {
            this.lesson.questions.push({
                _id: null,
                question: "",
                option_1: "",
                option_2: "",
                option_3: "",
                option_4: "",
                answer: ""
            });
            const qIndex = this.lesson.questions.length - 1;
            setTimeout(function () {
                new bootstrap.Collapse('#EvSystemQuestionCollapse_' + qIndex, {
                    show: true
                })
            })
        },
        ManageQuestion: function (question, qIndex) {
            console.log(question, qIndex);
            this.Loading = true;
            ApiService.POST('/api/secure/admin/evaluation/awareness/' + this.course_id + '/topic/' + this.topic_id + '/lesson/' + this.lesson_id+'/question/manage', question, (res) => {
                this.Loading = false;
                this.lesson.questions[qIndex] = res.data;
                Toaster.success(res.msg);
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
                        this.lesson.questions.splice(index, 1);
                    } else {
                        this.Loading = true;
                        ApiService.DELETE('/api/secure/admin/evaluation/awareness/' + this.course_id + '/topic/' + this.topic_id + '/lesson/' + this.lesson_id+'/question/delete/'+question._id, (res) => {
                            this.Loading = false;
                            this.lesson.questions.splice(index, 1);
                            Toaster.error(res.msg);
                        })
                    }
                }
            })
        }
    },
    created() {
        this.restartPage()
    },
    watch: {
        '$route.params.lesson_id'(newId, oldId) {
            if (newId !== oldId) {
                this.restartPage()
            }
        }
    }
};
</script>
