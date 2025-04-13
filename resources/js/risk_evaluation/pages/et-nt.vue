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

                        <div class="w-100 mb-3 py-5">

                            <div class="w-100 text-center">
                                <button @click="openEtQuestions" type="button" class="btn btn-outline-success fs-5 m-2 border border-secondary border-2 rounded py-3" style="width: 200px; height: 80px;"><strong>I’m technical</strong></button>
                                <button @click="openNtQuestions" type="button" class="btn btn-outline-secondary fs-5 m-2 border border-secondary border-2 rounded py-3" style="width: 200px; height: 80px;"><strong>I’m not technical</strong></button>
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
        return {
            UserInfo: window.core.UserInfo,
        }
    },
    computed: {},
    watch: {},
    methods: {
        openEtQuestions: function () {
            this.$router.push({name: 'EtEta'})
        },
        openNtQuestions: function () {
            this.$router.push({name: 'NtQuestions'})
        },
        goBack(){
            this.$router.push({name: 'AskAiSystems'})
        }
    },
    created() {
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

