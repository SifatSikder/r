<template>
    <div class="w-100">
        <Header/>
        <div class="w-100">
            <div class="container-fluid py-5 px-md-5 px-3">
                <p class="alert alert-primary border text-center" v-if="UserInfo.subscription_type !== 'premium'">
                    <strong>Upgrade to</strong>
                    <a class="btn btn-sm btn-primary mx-2" href="/pricing">Premium Subscription</a>
                    <strong>and explore all features to evaluate Risks and analyse fair decisions.</strong>
                </p>
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<script>
import Header from "./header.vue";

export default {
    components: {Header},
    data() {
        return {
            UserInfo: window.core.UserInfo
        }
    }
}
</script>
