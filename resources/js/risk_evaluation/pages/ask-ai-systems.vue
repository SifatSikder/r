<template>
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="w-100">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <a @click="goBack" class="btn btn-sm btn-outline-secondary"><i class="fa fa-fw fa-arrow-left"></i> <span class="d-sm-inline d-none">Back</span></a>
                        <h3 class="text-center m-0"><strong>Risk Evaluation Process</strong></h3>
                        <a class="invisible"><i class="fa fa-fw fa-arrow-left"></i> <span class="d-sm-inline d-none">Back</span></a>
                    </div>
                    <div class="card-body py-3 px-sm-5">

                        <div class="w-100 mt-5">
                            <h3 class="text-center mb-5"><strong class="text-secondary">Are you using any AI systems?</strong></h3>
                        </div>
                        <div class="w-100 mb-3">

                            <div class="w-100 text-center">
                                <button @click="showEtNt" type="button" class="btn btn-outline-success fs-5 m-2 border border-secondary border-2 rounded py-3" style="width: 150px; height: 80px;"><strong>Yes</strong></button>
                                <button @click="showPlanning" type="button" class="btn btn-outline-secondary fs-5 m-2 border border-secondary border-2 rounded py-3" style="width: 150px; height: 80px;"><strong>No</strong></button>
                                <button @click="showTraining" type="button" class="btn btn-outline-secondary fs-5 m-2 border border-secondary border-2 rounded py-3" style="width: 150px; height: 80px;"><strong>Not Sure</strong></button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {}
    },
    computed: {},
    watch: {},
    methods: {
        showEtNt: function () {
            this.$router.push({name: 'EtNt'})
        },
        showPlanning: function () {
            this.$router.push({name: 'PlanningAiSystems'})
        },
        showTraining: function () {
            this.$router.push({name: 'TrainingAiSystems'})
        },
        goBack(){
            this.$router.push({name: 'ProjectIntro'})
        }
    },
    created() {

    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

