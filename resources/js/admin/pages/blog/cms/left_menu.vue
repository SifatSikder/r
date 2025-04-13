<template>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'CreateBlog'}" class="w-100 btn rounded-pill"
                     :class="{'btn-danger': current_page === 'CreateBlog', 'btn-outline-secondary': current_page !== 'CreateBlog'}">Create New</router-link>
    </div>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'BlogList'}" class="w-100 btn rounded-pill"
                     :class="{'btn-danger': current_page === 'BlogList', 'btn-outline-secondary': current_page !== 'BlogList'}">List</router-link>
    </div>
</template>

<script>

export default {
    components: {
    },
    data() {
        return {
            current_page: this.$route.name
        };
    },
    methods: {

    },
    created() {

    },
    mounted() {
    }
};
</script>
