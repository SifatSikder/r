<template>
    <div class="container-fluid">
        <div class="w-100">

            <div class="card" v-if="course != null">
                <div class="card-header bg-white py-3">
                    <h4 class="m-0 fw-bold text-secondary">Evaluation Sectors</h4>
                </div>
                <div class="card-body p-0">
                    <div class="course-preview-board">

                        <div class="course-preview-board-sidebar">

                            <div class="accordion" id="accordionCourse">
                                <div v-for="(topic, tIndex) in topics" class="each-topics mb-2">

                                    <div v-if="topic.edit_form !== 1" class="w-100 bg-white shadow-sm p-3 border rounded-3 d-flex justify-content-between align-items-center">
                                        <h3 class="each-topics-title"><a class="text-decoration-none text-dark" href="javascript:void(0)" data-bs-toggle="collapse" :data-bs-target="'#collapse'+tIndex">{{ topic.title }}</a></h3>
                                        <a @click="topic.edit_form = 1"><i class="fa fa-pencil"></i></a>
                                    </div>
                                    <div class="w-100 bg-white shadow-sm p-2 border rounded-3" v-if="topic.edit_form === 1">
                                        <input type="text" class="form-control" autofocus v-model="topic.title" placeholder="Topic Title" @blur="editCourseTopic(topic)">
                                    </div>

                                    <div class="each-topic-lesson collapse" :class="{'show': topic_id === topic._id}" :id="'collapse'+tIndex" data-bs-parent="#accordionCourse">
                                        <div class="w-100">
                                            <ol class="m-0 p-0">
                                                <li v-for="(lesson, lIndex) in topic.lessons" class="py-2 px-3 bg-light border mb-2 lesson_hover d-flex justify-content-between align-items-center"
                                                    :class="{'active_lesson': lesson_id === lesson._id}"
                                                    :key="lIndex">
                                                    <router-link class="text-decoration-none" :to="{name: 'LessonPreview', params:{course_id: course._id, topic_id: topic._id, lesson_id: lesson._id}}"><strong class="text-secondary">{{ lesson.title }}</strong></router-link>
                                                    <router-link :to="{name: 'LessonEdit', params:{course_id: course._id, topic_id: topic._id, lesson_id: lesson._id}}"><i class="fa fa-pencil"></i></router-link>
                                                </li>
                                            </ol>
                                        </div>
                                        <div class="each-lesson text-center mt-2">
                                            <router-link :to="{name: 'LessonCreate', params:{course_id: course._id, topic_id: topic._id}}" class="btn btn-sm btn-secondary"><i class="fa fa-plus"></i> New Lesson</router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="each-topics" v-if="create_topic === false">
                                <a class="btn btn-secondary w-100 btn-lg" @click="create_topic = true"><i class="fa fa-plus"></i> New Topic</a>
                            </div>
                            <div class="each-topics" v-if="create_topic === true">
                                <div class="w-100 bg-white shadow-sm p-2 border rounded-3">
                                    <input type="text" class="form-control" v-model="topic_form.title" placeholder="Topic Title" @blur="createCourseTopic()">
                                </div>
                            </div>

                        </div>

                        <div class="course-preview-board-content bg-light">
                            <router-view @refresh="restartPage()" @currentLesson="getCurrentLesson"/>
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
import {createToaster} from "@meforma/vue-toaster";

const Toaster = createToaster({position: 'top-right'});

export default {
    data() {
        return {
            Loading: false,
            create_topic: false,
            topic_form: {
                title: ''
            },
            course_id: null,
            topic_id: null,
            lesson_id: null,
            course: null,
            topics: []
        }
    },
    methods: {
        getCourse() {
            this.Loading = true;
            ApiService.GET('/api/secure/admin/evaluation/awareness/single/' + this.course_id, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.course = res.data;
                    this.getCourseTopics();
                }
            })
        },
        getCourseTopics() {
            this.Loading = true;
            ApiService.GET('/api/secure/admin/evaluation/awareness/' + this.course_id + '/topic/list', (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.topics = res.data;
                }
            })
        },
        createCourseTopic() {
            this.Loading = true;
            ApiService.POST('/api/secure/admin/evaluation/awareness/' + this.course_id + '/topic/create', this.topic_form, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.getCourseTopics();
                    this.create_topic = false;
                    this.topic_form.title = '';
                }
            })
        },
        editCourseTopic(topic) {
            this.Loading = true;
            ApiService.POST('/api/secure/admin/evaluation/awareness/' + this.course_id + '/topic/update/' + topic._id, {title: topic.title}, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.getCourseTopics();
                }
            })
        },
        getCurrentLesson(payload) {
            this.topic_id = payload.topic_id;
            this.lesson_id = payload.lesson_id;
        },
        restartPage() {
            this.course_id = this.$route.params.course_id;
            this.getCourse()
        }
    },
    created() {
        this.restartPage()
    },
    watch: {
        '$route.params.course_id'(newId, oldId) {
            if (newId !== oldId) {
                this.restartPage()
            }
        }
    }
};
</script>
