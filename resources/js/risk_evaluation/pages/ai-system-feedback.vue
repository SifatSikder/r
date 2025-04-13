<template>
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <form class="w-100" @submit.prevent="submitForm" v-if="risk_evaluation != null">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h3 class="text-center m-0">Risk Evaluation Process</h3>
                        <p class="text-center m-0">Please complete the form below to help us understand your requirements.</p>
                    </div>
                    <div class="card-body py-3 px-5">

                        <div class="w-100 text-center">
                            <p class="btn btn-primary px-5 rounded-pill d-inline-block m-0 mb-3"><strong>Chatbots or Virtual Assistants</strong></p>
                        </div>
                        <div class="w-100 mt-3">
                            <template v-if="risk_evaluation.ai_system_type === 'chatbot'">
                                <div class="w-100 shadow mb-3">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <h5 class="bg-light border p-3 m-0">
                                                <strong>
                                                    Which one of these Chatbots are you using most?
                                                </strong>
                                            </h5>
                                        </div>
                                        <div class="w-100 p-5">
                                            <div class="row">
                                                <div class="col-lg-4 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn rounded-pill"
                                                                :class="{'btn-outline-success': risk_evaluation.chatbots.indexOf('ChatGPT') < 0, 'btn-success': risk_evaluation.chatbots.indexOf('ChatGPT') > -1}"
                                                                @click="addChatBot('ChatGPT')">ChatGPT
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn rounded-pill"
                                                                :class="{'btn-outline-success': risk_evaluation.chatbots.indexOf('GoogleBard') < 0, 'btn-success': risk_evaluation.chatbots.indexOf('GoogleBard') > -1}"
                                                                @click="addChatBot('GoogleBard')">Google Bard
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn rounded-pill"
                                                                :class="{'btn-outline-success': risk_evaluation.chatbots.indexOf('ClaudeAI') < 0, 'btn-success': risk_evaluation.chatbots.indexOf('ClaudeAI') > -1}"
                                                                @click="addChatBot('ClaudeAI')">Claude AI
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 mb-3">
                                                    <div class="w-100 d-flex justify-content-start align-items-center">
                                                        <input disabled readonly type="text" name="chatbot_other" @keyup="addCustomChatBot" placeholder="Other ChatbBot" class="form-control rounded-pill px-4">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100 shadow mb-3">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <h5 class="bg-light border p-3 m-0">
                                                <strong>
                                                    How accurately do these assistants respond to your queries and requests?
                                                </strong>
                                            </h5>
                                        </div>
                                        <div class="w-100 p-5">
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button :class="{'btn-outline-success': risk_evaluation.chatbot_feedback.accuracy !== 3, 'btn-success': risk_evaluation.chatbot_feedback.accuracy === 3}"
                                                                @click="risk_evaluation.chatbot_feedback.accuracy = 3"
                                                                type="button" class="w-100 btn rounded-pill">Very Accurate
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button :class="{'btn-outline-success': risk_evaluation.chatbot_feedback.accuracy !== 2, 'btn-success': risk_evaluation.chatbot_feedback.accuracy === 2}"
                                                                @click="risk_evaluation.chatbot_feedback.accuracy = 2"
                                                                type="button" class="w-100 btn rounded-pill">Accurate
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button :class="{'btn-outline-success': risk_evaluation.chatbot_feedback.accuracy !== 1, 'btn-success': risk_evaluation.chatbot_feedback.accuracy === 1}"
                                                                @click="risk_evaluation.chatbot_feedback.accuracy = 1"
                                                                type="button" class="w-100 btn rounded-pill">Moderately Accurate
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button :class="{'btn-outline-success': risk_evaluation.chatbot_feedback.accuracy !== 0, 'btn-success': risk_evaluation.chatbot_feedback.accuracy === 0}"
                                                                @click="risk_evaluation.chatbot_feedback.accuracy = 0"
                                                                type="button" class="w-100 btn rounded-pill">Not Accurate
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100 shadow mb-3">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <h5 class="bg-light border p-3 m-0">
                                                <strong>
                                                    How well do these assistants adapt to different customer preferences?
                                                </strong>
                                            </h5>
                                        </div>
                                        <div class="w-100 p-5">
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button :class="{'btn-outline-success': risk_evaluation.chatbot_feedback.adaptiveness !== 3, 'btn-success': risk_evaluation.chatbot_feedback.adaptiveness === 3}"
                                                                @click="risk_evaluation.chatbot_feedback.adaptiveness = 3"
                                                                type="button" class="w-100 btn rounded-pill">Very Well
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button :class="{'btn-outline-success': risk_evaluation.chatbot_feedback.adaptiveness !== 2, 'btn-success': risk_evaluation.chatbot_feedback.adaptiveness === 2}"
                                                                @click="risk_evaluation.chatbot_feedback.adaptiveness = 2"
                                                                type="button" class="w-100 btn rounded-pill">Well
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button :class="{'btn-outline-success': risk_evaluation.chatbot_feedback.adaptiveness !== 1, 'btn-success': risk_evaluation.chatbot_feedback.adaptiveness === 1}"
                                                                @click="risk_evaluation.chatbot_feedback.adaptiveness = 1"
                                                                type="button" class="w-100 btn rounded-pill">Moderately
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button :class="{'btn-outline-success': risk_evaluation.chatbot_feedback.adaptiveness !== 0, 'btn-success': risk_evaluation.chatbot_feedback.adaptiveness === 0}"
                                                                @click="risk_evaluation.chatbot_feedback.adaptiveness = 0"
                                                                type="button" class="w-100 btn rounded-pill">Not Well
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template v-if="risk_evaluation.ai_system_type === 'image-analyzer'">
                                <div class="w-100 shadow mb-3">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <h5 class="bg-light border p-3 m-0">
                                                <strong>
                                                    How reliable are these tools in identifying and categorizing visual elements?
                                                </strong>
                                            </h5>
                                        </div>
                                        <div class="w-100 p-5">
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Very Reliable</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Reliable</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Somewhat Reliable</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Not Reliable</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100 shadow mb-3">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <h5 class="bg-light border p-3 m-0">
                                                <strong>
                                                    How well do these tools perform in different lighting conditions?
                                                </strong>
                                            </h5>
                                        </div>
                                        <div class="w-100 p-5">
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Very Well</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Well</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Moderately</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Not Well</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template v-if="risk_evaluation.ai_system_type === 'data-analyzer'">
                                <div class="w-100 shadow mb-3">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <h5 class="bg-light border p-3 m-0">
                                                <strong>
                                                    How well do these tools help in understanding trends and patterns in your data?
                                                </strong>
                                            </h5>
                                        </div>
                                        <div class="w-100 p-5">
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Very Well</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Well</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Moderately</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Not Well</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100 shadow mb-3">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <h5 class="bg-light border p-3 m-0">
                                                <strong>
                                                    How easy is it to use these tools without technical expertise?
                                                </strong>
                                            </h5>
                                        </div>
                                        <div class="w-100 p-5">
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Very Easy</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Easy</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Somewhat Easy</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Not Easy</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template v-if="risk_evaluation.ai_system_type === 'automated-robot'">
                                <div class="w-100 shadow mb-3">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <h5 class="bg-light border p-3 m-0">
                                                <strong>
                                                    How safely do the automated processes interact with your existing workflows?
                                                </strong>
                                            </h5>
                                        </div>
                                        <div class="w-100 p-5">
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Very Safely</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Safely</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Somewhat Safely</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Not Safely</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100 shadow mb-3">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <h5 class="bg-light border p-3 m-0">
                                                <strong>
                                                    How reliable are these automated processes or robots in performing tasks?
                                                </strong>
                                            </h5>
                                        </div>
                                        <div class="w-100 p-5">
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Very Reliable</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Reliable</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Somewhat Reliable</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="w-100">
                                                        <button type="button" class="w-100 btn btn-outline-success rounded-pill">Not Reliable</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                    </div>
                    <div class="card-footer py-3 d-flex justify-content-between">
                        <router-link :to="{name: 'AiSystems'}" class="btn btn-lg btn-outline-secondary rounded-pill px-5">Back</router-link>
                        <button type="submit" class="btn btn-lg btn-success rounded-pill px-5">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>


<script>
import ApiRoutes from "../services/ApiRoutes";
import ApiService from "../services/ApiService";

export default {
    data() {
        return {
            risk_evaluation: null
        }
    },
    computed: {},
    watch: {},
    methods: {
        addChatBot: function (bot) {
            let chatbots = this.risk_evaluation.chatbots;
            if (chatbots.indexOf(bot) > -1) {
                chatbots.splice(chatbots.indexOf(bot), 1);
            } else {
                chatbots.push(bot);
            }
            this.risk_evaluation.chatbots = chatbots;
        },
        addCustomChatBot: function (e) {
            this.risk_evaluation.chatbots.length = 0;
            this.risk_evaluation.chatbots = [e.target.value];
        },
        submitForm: function () {
            let THIS = this;
            localStorage.setItem('risk_evaluation', JSON.stringify(this.risk_evaluation));
            if (this.risk_evaluation.chatbots.length > 0) {
                ApiService.POST(ApiRoutes.RiskSubmit, {risk_evaluation: this.risk_evaluation}, function (res) {
                    localStorage.removeItem('risk_evaluation');
                    if (res.data.guest_id !== null) {
                        localStorage.setItem('mot4ai_guest_id', res.data.guest_id);
                        THIS.$router.push({name: 'AlmostDone'});
                    } else {
                        window.location.href = '/portal/ai/report/' + res.data._id;
                    }
                })
            }
        }
    },
    created() {
        if (localStorage.getItem('risk_evaluation') == null) {
            this.$router.push({name: 'ProjectIntro'})
        } else {
            this.risk_evaluation = JSON.parse(localStorage.getItem('risk_evaluation'));
        }
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

