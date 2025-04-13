<template>
    <div class="w-100">
        <Header/>
        <div class="w-100 px-3 px-lg-5 py-4 bg-light">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
import Header from "../includes/header.vue";

export default {
    components: {Header}
}
</script>
