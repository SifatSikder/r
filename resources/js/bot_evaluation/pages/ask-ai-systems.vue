<template>

    <div class="w-100">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <router-link :to="{name: 'ProjectIntro'}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-fw fa-arrow-left"></i> <span class="d-sm-inline d-none">Back</span></router-link>
                <h3 class="text-center m-0"><strong>Risk Evaluation Process</strong></h3>
                <a class="invisible"><i class="fa fa-fw fa-arrow-left"></i> <span class="d-sm-inline d-none">Back</span></a>
            </div>
            <div class="card-body py-3 px-5">

                <div class="w-100 mt-5">
                    <h3 class="text-center mb-5"><strong class="text-secondary">Are you using any AI systems?</strong></h3>
                </div>
                <div class="w-100 mb-3" v-if="bot_evaluation !== null">

                    <div class="w-100 text-center">
                        <a @click="goNext" class="btn btn-outline-success fs-5 m-2 border border-secondary border-2 rounded py-3" style="width: 150px;"><strong>Yes</strong></a>
                        <router-link :to="{name: 'PlanningAiSystems'}" class="btn btn-outline-success fs-5 m-2 border border-secondary border-2 rounded py-3" style="width: 150px;"><strong>No</strong></router-link>
                    </div>

                </div>

            </div>
        </div>
    </div>

</template>


<script>
export default {
    data() {
        return {
            bot_evaluation: null,
            demo_type: 0
        }
    },
    computed: {},
    watch: {},
    methods: {
        goNext(){
            if(this.demo_type === 1){
                this.$router.push({name: 'cgptQuestions'})
            } else if(this.demo_type === 2){
                this.$router.push({name: 'fdQuestions'})
            }
        }
    },
    created() {
        if (localStorage.getItem('bot_evaluation') == null) {
            this.$router.push({name: 'DemoStart'})
        } else {
            this.bot_evaluation = JSON.parse(localStorage.getItem('bot_evaluation'));
        }
        if (localStorage.getItem('demo_type') == null) {
            this.$router.push({name: 'DemoStart'})
        } else {
            this.demo_type = parseInt(localStorage.getItem('demo_type'));
        }
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

