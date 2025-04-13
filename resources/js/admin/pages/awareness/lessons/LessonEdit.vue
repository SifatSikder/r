<template>
    <div class="w-100">
        <form class="w-100" v-if="lesson != null" @submit.prevent="updateLesson">
            <div class="card question-holder">
                <div class="card-header bg-white py-3 d-flex justify-content-between sticky-top">
                    <h4 class="m-0"><strong class="text-dark">Update Lesson</strong></h4>
                    <div class="">
                        <router-link class="btn btn-sm btn-secondary rounded-pill px-3 me-2" :to="{name: 'AwarenessPreview', params:{course_id: course_id}}">Cancel</router-link>
                        <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Save Changes</button>
                    </div>
                </div>
                <div class="card-body p-2 p-lg-3">
                    <div class="row">
                        <div class="col-lg-12 mb-1">
                            <div class="w-100 p-4">
                                <div class="error-report-g"></div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-4">
                                            <label class="form-label"><strong>Title</strong></label>
                                            <input type="text" class="form-control" name="title" v-model="lesson.title" placeholder="Title" required>
                                            <div class="error-report text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label class="form-label"><strong>Lesson Type</strong></label>
                                            <select class="form-select" name="type" v-model="lesson.is_quiz" @change="lesson.is_quiz === '0' ? lesson.is_final_exam = '0' : ''">
                                                <option value="0">Content Type Lesson</option>
                                                <option value="1">Quiz</option>
                                            </select>
                                            <div class="error-report text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" v-if="lesson.is_quiz === '1'">
                                        <div class="form-group mb-4">
                                            <label class="form-label"><strong>Quiz Type</strong></label>
                                            <select class="form-select" name="is_final_exam" v-model="lesson.is_final_exam">
                                                <option value="0">Topic Quiz</option>
                                                <option value="1">Course Final Exam</option>
                                            </select>
                                            <div class="error-report text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-4">
                                            <label class="form-label"><strong>Description</strong></label>
                                            <div class="w-100">
                                                <QuillEditor theme="snow" :toolbar="toolbarOptions" v-model:content="lesson.description" contentType="html"/>
                                            </div>
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
</template>


<script>
import ApiService from "../../../services/ApiService";
import {createToaster} from "@meforma/vue-toaster";
import {QuillEditor} from '@vueup/vue-quill'

const Toaster = createToaster({position: 'top-right'});

export default {
    components: {QuillEditor},
    data() {
        return {
            Loading: false,
            course_id: null,
            topic_id: null,
            lesson_id: null,
            lesson: null,
            toolbarOptions: [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote', 'code-block'],
                ['link', 'image', 'video'],
                [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                [{ 'align': [] }]
            ]
        }
    },
    methods: {
        updateLesson() {
            this.Loading = true;
            ApiService.ClearErrorHandler();
            ApiService.POST('/api/secure/admin/evaluation/awareness/'+this.course_id+'/topic/'+this.topic_id+'/lesson/update/'+this.lesson_id, this.lesson, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    Toaster.success(res.msg);
                    this.$emit('refresh', { refresh: true });
                    this.$router.push({name: 'LessonPreview', params:{course_id: this.course_id, topic_id: this.topic_id, lesson_id: this.lesson_id}});
                } else {
                    ApiService.ErrorHandler(res.error);
                }
            })
        },
        getLesson() {
            this.Loading = true;
            ApiService.ClearErrorHandler();
            ApiService.GET('/api/secure/admin/evaluation/awareness/'+this.course_id+'/topic/'+this.topic_id+'/lesson/single/'+this.lesson_id, (res) => {
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
            this.getLesson()
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
