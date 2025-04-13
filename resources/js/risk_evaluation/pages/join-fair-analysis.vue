<template>

    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="w-100">

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
    },
    created() {
        localStorage.setItem('risk_analysis', 'fair');
        if(this.UserInfo == null){
            this.$router.push({name: 'Register'})
        } else {
            this.$router.push({name: 'ProjectIntro'})
        }
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

