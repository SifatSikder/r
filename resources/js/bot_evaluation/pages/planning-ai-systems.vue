<template>

    <div class="w-100">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <router-link :to="{name: 'AskAiSystems'}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-fw fa-arrow-left"></i> <span class="d-sm-inline d-none">Back</span></router-link>
                <h3 class="text-center m-0"><strong>Risk Evaluation Process</strong></h3>
                <a class="invisible"><i class="fa fa-fw fa-arrow-left"></i> <span class="d-sm-inline d-none">Back</span></a>
            </div>
            <div class="card-body py-3 px-5">

                <div class="w-100 text-center">
                    <h3 class="text-center my-5"><strong class="text-secondary">Are you planning to use AI?</strong></h3>
                </div>
                <div class="w-100 mb-3" v-if="bot_evaluation !== null">

                    <div class="w-100 text-center">
                        <router-link :to="{name: 'TrainingAiSystems'}" type="button" class="btn btn-outline-success fs-5 m-2 border border-secondary border-2 rounded py-3" style="width: 150px;"><strong>Yes</strong></router-link>
                        <router-link :to="{name: 'BenefitAiSystems'}" type="button" class="btn btn-outline-success fs-5 m-2 border border-secondary border-2 rounded py-3" style="width: 150px;"><strong>No</strong></router-link>
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
            bot_evaluation: null
        }
    },
    computed: {},
    watch: {},
    methods: {

    },
    created() {
        if (localStorage.getItem('bot_evaluation') == null) {
            this.$router.push({name: 'ProjectIntro'})
        } else {
            this.bot_evaluation = JSON.parse(localStorage.getItem('bot_evaluation'));
        }
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

