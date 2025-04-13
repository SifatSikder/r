<template>

    <form class="w-100" @submit.prevent="submitForm" v-if="bot_evaluation != null">
        <div class="card shadow">
            <div class="card-header py-3">
                <h3 class="text-center m-0">Risk Evaluation Process</h3>
            </div>
            <div class="card-body py-3 px-5">

                <div class="w-100">
                    <h2 class="mb-4 text-center"><strong class="text-secondary">Please select one Domain</strong></h2>
                </div>
                <div class="w-100 mt-3">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="w-100 mb-3">
                                <div class="w-100 btn py-4" :class="{'btn-outline-success':bot_evaluation.evaluation_sector !== 'Industry', 'btn-success':bot_evaluation.evaluation_sector === 'Industry'}" @click="addSector('Industry')">
                                    <h5 class="m-0"><i class="fa fa-fw fa-2x fa-industry"></i> <br> Industry</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="w-100 mb-3">
                                <div class="w-100 btn py-4" :class="{'btn-outline-success':bot_evaluation.evaluation_sector !== 'Health', 'btn-success':bot_evaluation.evaluation_sector === 'Health'}" @click="addSector('Health')">
                                    <h5 class="m-0"><i class="fa fa-fw fa-2x fa-heartbeat"></i> <br> Health</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="w-100 mb-3">
                                <div class="w-100 btn py-4" :class="{'btn-outline-success':bot_evaluation.evaluation_sector !== 'Engineering', 'btn-success':bot_evaluation.evaluation_sector === 'Engineering'}" @click="addSector('Engineering')">
                                    <h5 class="m-0"><i class="fa fa-fw fa-2x fa-cogs"></i> <br> Engineering</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="w-100 mb-3">
                                <div class="w-100 btn py-4" :class="{'btn-outline-success':bot_evaluation.evaluation_sector !== 'Agriculture', 'btn-success':bot_evaluation.evaluation_sector === 'Agriculture'}" @click="addSector('Agriculture')">
                                    <h5 class="m-0"><i class="fa fa-fw fa-2x fa-truck"></i> <br> Agriculture</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="w-100 mb-3">
                                <div class="w-100 btn py-4" :class="{'btn-outline-success':bot_evaluation.evaluation_sector !== 'Business', 'btn-success':bot_evaluation.evaluation_sector === 'Business'}" @click="addSector('Business')">
                                    <h5 class="m-0"><i class="fa fa-fw fa-2x fa-money"></i> <br> Business & Finance</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="w-100 mb-3">
                                <div class="w-100 btn py-4" :class="{'btn-outline-success':bot_evaluation.evaluation_sector !== 'Education', 'btn-success':bot_evaluation.evaluation_sector === 'Education'}" @click="addSector('Education')">
                                    <h5 class="m-0"><i class="fa fa-fw fa-2x fa-university"></i> <br> Education</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 offset-lg-4">
                            <div class="w-100 mb-3">
                                <div class="w-100 btn py-4" :class="{'btn-outline-success':bot_evaluation.evaluation_sector !== 'Art', 'btn-success':bot_evaluation.evaluation_sector === 'Art'}" @click="addSector('Art')">
                                    <h5 class="m-0"><i class="fa fa-fw fa-2x fa-paint-brush"></i> <br> Art & creativity</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer py-3 d-flex justify-content-between">
                <router-link :to="{name: 'AskAiSystems'}" class="btn btn-lg btn-outline-secondary rounded-pill px-5">Back</router-link>
                <button type="submit" class="btn btn-lg btn-success rounded-pill px-5" :disabled="bot_evaluation.evaluation_sector === null">Next</button>
            </div>
        </div>
    </form>

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
        addSector: function (sector) {
            this.bot_evaluation.evaluation_sector = sector;
        },
        submitForm: function () {
            localStorage.setItem('bot_evaluation', JSON.stringify(this.bot_evaluation));
            this.$router.push({name: 'AlmostDone'})
        }
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

