<template>

    <div class="w-100">
        <div class="card shadow">
            <div class="card-header py-3">
                <h3 class="text-center m-0"><strong>Risk Evaluation Process</strong></h3>
            </div>
            <div class="card-body py-3 px-5">

                <div class="w-100 my-5" v-if="bot_evaluation !== null">

                    <div class="w-100 text-center">
<!--                        <router-link :to="{name: 'ProjectIntro'}" @click="setDemo(1)" type="button" class="btn btn-success fs-5 m-2 border border-secondary border-2 rounded py-3 px-4"><strong>Demo For ChatGPT</strong></router-link>-->
<!--                        <router-link :to="{name: 'ProjectIntro'}" @click="setDemo(2)" type="button" class="btn btn-warning fs-5 m-2 border border-secondary border-2 rounded py-3 px-4"><strong>Demo For Fair Decision</strong></router-link>-->
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
            demo_type: 1, // 1.ChatGPT  2.FairDecision
        }
    },
    computed: {},
    watch: {},
    methods: {
        setDemo(type){
            this.demo_type = type;
            localStorage.setItem('demo_type', type);
            this.$router.push({name: 'ProjectIntro'})
        }
    },
    created() {
        this.setDemo(1)
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

