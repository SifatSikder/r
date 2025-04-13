<template>

    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="w-100">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h3 class="text-center text-secondary m-0"><strong>Risk Evaluation Process</strong></h3>
                    </div>
                    <div class="card-body py-3 px-md-5 px-3">

                        <div class="w-100 mt-5">
                            <h3 class="text-center mb-5">
                                <strong class="text-secondary" v-if="UserInfo == null">Register / Login <br> To Access the Dashboard and Tool</strong>
                                <strong class="text-secondary" v-if="UserInfo != null">Do you want <br> To start a new Evaluation?</strong>
                            </h3>
                        </div>
                        <div class="w-100 mb-3">

                            <div class="w-100 text-center">
                                <button v-if="UserInfo == null" @click="openRegister" type="button" class="btn btn-outline-success fs-5 m-2 border border-secondary border-2 rounded py-3" style="width: 150px; height: 80px;"><strong>Register</strong></button>
                                <button v-if="UserInfo == null" @click="openLogin" type="button" class="btn btn-outline-success fs-5 m-2 border border-secondary border-2 rounded py-3" style="width: 150px; height: 80px;"><strong>Login</strong></button>
                                <button @click="showBenefit" type="button" class="btn btn-outline-secondary fs-5 m-2 border border-secondary border-2 rounded py-3" style="width: 150px; height: 80px;"><strong>No, Thanks!</strong></button>
                                <button v-if="UserInfo != null" @click="openIntro" type="button" class="btn btn-outline-success fs-5 m-2 border border-secondary border-2 rounded py-3" style="width: 150px; height: 80px;"><strong>Yes</strong></button>
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
        showBenefit: function () {
            this.$router.push({name: 'BenefitAiSystems'})
        },
        openLogin: function () {
            this.$router.push({name: 'Login'})
        },
        openRegister: function () {
            this.$router.push({name: 'Register'})
        },
        openIntro: function () {
            this.$router.push({name: 'ProjectIntro'})
        }
    },
    created() {
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

