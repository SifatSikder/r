<template>

    <form class="w-100" @submit.prevent="submitForm">
        <div class="card shadow">
            <div class="card-header py-3 text-center">
                <h3 class="text-center m-0"><strong>Risk Evaluation Process</strong></h3>
            </div>
            <div class="card-body py-3 px-5">

                <div class="w-100 mt-3">
                    <div class="form-group mb-4">
                        <strong class="title_count">{{project.name.length}}/30</strong>
                        <label class="form-label"><strong>Title of the proposed Evaluation</strong></label>
                        <input type="text" class="form-control form-control-lg rounded-pill" @keyup="name_validate" name="name" v-model="project.name" placeholder="Give a short title (Maximum 30 Characters)" required>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label"><strong>Website <small>(Optional)</small></strong></label>
                        <input type="text" class="form-control form-control-lg rounded-pill" name="website" v-model="project.website" placeholder="Please provide your website address">
                    </div>
                    <div class="form-group mb-4">
                        <strong class="title_count">{{project.desc.length}}/200</strong>
                        <label class="form-label"><strong>Short Details (Maximum 200 words) about your evaluation areas <small>(Optional)</small></strong></label>
                        <textarea class="form-control form-control-lg" @keyup="desc_validate" style="border-radius: 20px;padding-right: 85px" name="desc" v-model="project.desc" placeholder="What is the purpose of your evaluation?"></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer py-3 d-flex justify-content-between">
                <a class=""></a>
                <button type="submit" class="btn btn-lg btn-success rounded-pill px-5 ">Next</button>
            </div>
        </div>
    </form>

</template>


<script>
export default {
    data() {
        return {
            bot_evaluation: {
                project: null,
                evaluation_sector: null,
                category: 'ChatGPT',
                answers: {}
            },
            project: {
                name: '',
                website: '',
                desc: '',
            }
        }
    },
    computed: {},
    watch: {},
    methods: {
        name_validate() {
            if (this.project.name.length > 30) {
                this.project.name = this.project.name.substring(0, 30);
            }
        },
        desc_validate() {
            if (this.project.desc.length > 200) {
                this.project.desc = this.project.desc.substring(0, 200);
            }
        },
        submitForm: function (){
            if(localStorage.getItem('bot_evaluation') !== null){
                this.bot_evaluation = JSON.parse(localStorage.getItem('bot_evaluation'));
            } else {
                this.bot_evaluation.project = this.project;
            }
            if (localStorage.getItem('demo_type') == null) {
                this.$router.push({name: 'DemoStart'})
            } else {
                this.demo_type = parseInt(localStorage.getItem('demo_type'));
            }
            localStorage.setItem('bot_evaluation', JSON.stringify(this.bot_evaluation));
            this.$router.push({name: 'AskAiSystems'})
        }
    },
    created() {
        if (localStorage.getItem('bot_evaluation') != null) {
            this.bot_evaluation = JSON.parse(localStorage.getItem('bot_evaluation'));
            this.project = this.bot_evaluation.project;
        }
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

