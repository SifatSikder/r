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
                            <p class="btn btn-primary px-5 rounded-pill d-inline-block m-0 mb-5"><strong>AI System Type</strong></p>
                            <h4 class="mb-4 text-center">
                                <strong class="text-secondary">
                                    What type of tools or systems are you currently using
                                    <br>
                                    that involve advanced technologies like automated decision-making or intelligent processing?
                                </strong>
                            </h4>
                        </div>
                        <div class="w-100 mt-3">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="w-100 btn p-3 text-start" :class="{'btn-outline-success':risk_evaluation.ai_system_type !== 'chatbot','btn-success':risk_evaluation.ai_system_type === 'chatbot'}" @click="addAI('chatbot')">
                                        <strong>Chatbots or Virtual Assistants (for example, ChatGPT)</strong>
                                        <br>
                                        <small>
                                            Imagine using a virtual assistant that can answer customer questions on your
                                            website or provide automated responses in customer service chats.
                                        </small>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="w-100 btn p-3 text-start" :class="{'btn-outline-success':risk_evaluation.ai_system_type !== 'image-analyzer','btn-success':risk_evaluation.ai_system_type === 'image-analyzer'}" @click="addAI('image-analyzer')">
                                        <strong>Tools that can analyze pictures or images (for example, image recognition tools)</strong>
                                        <br>
                                        <small>
                                            Think about using a tool that can recognize objects in photos, like when you upload pictures to
                                            social media and it automatically suggests tagging people or objects.
                                        </small>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="w-100 btn p-3 text-start" :class="{'btn-outline-success':risk_evaluation.ai_system_type !== 'data-analyzer','btn-success':risk_evaluation.ai_system_type === 'data-analyzer'}" @click="addAI('data-analyzer')">
                                        <strong>Tools that help understand and analyze data (for example, Excel data analysis tools)</strong>
                                        <br>
                                        <small>
                                            These could be tools that help you find patterns or insights in your sales data, allowing you to
                                            make informed business decisions.
                                        </small>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="w-100 btn p-3 text-start" :class="{'btn-outline-success':risk_evaluation.ai_system_type !== 'automated-robot','btn-success':risk_evaluation.ai_system_type === 'automated-robot'}" @click="addAI('automated-robot')">
                                        <strong>Automated processes or robots that perform tasks (for example, a robot on an assembly line)</strong>
                                        <br>
                                        <small>
                                            This might include robots used in manufacturing to assemble products on an assembly line or
                                            automated systems that manage inventory in a warehouse.
                                        </small>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="w-100 btn p-3 text-start" :class="{'btn-outline-secondary':risk_evaluation.ai_system_type !== 'none','btn-secondary':risk_evaluation.ai_system_type === 'none'}" @click="addAI('none')">
                                        <strong>I'm not sure / None of the above</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer py-3 d-flex justify-content-between">
                        <router-link :to="{name: 'SafetyRisksDomains'}" class="btn btn-lg btn-outline-secondary rounded-pill px-5">Back</router-link>
                        <button type="submit" class="btn btn-lg btn-success rounded-pill px-5" :disabled="risk_evaluation.ai_system_type === null">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>


<script>
export default {
    data() {
        return {
            risk_evaluation: null
        }
    },
    computed: {},
    watch: {},
    methods: {
        addAI: function (ai) {
            this.risk_evaluation.ai_system_type = ai;
        },
        submitForm: function () {
            localStorage.setItem('risk_evaluation', JSON.stringify(this.risk_evaluation));
            this.$router.push({name: 'AiSystemFeedback'})
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

