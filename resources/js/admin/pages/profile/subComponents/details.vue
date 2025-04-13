<template>

    <div class="card w-100 h-100">
        <div class="bg-light">
            <div class="h3 w-100 ps-3 py-3">Details</div>
        </div>

        <div class="h-100 d-flex justify-content-center align-items-center">

            <div v-if="profile != null">
                <h4 class="text-center">
                    <img :src="'/img/user.png'" alt="" style="width: 100px">
                </h4>
                <h4 class="text-center">{{ profile.name }}</h4>
                <h5 class="text-center">{{ profile.email }}</h5>
            </div>

        </div>

    </div>

</template>

<script>

import ApiService from "../../../services/ApiService";
import ApiRoutes from "../../../services/ApiRoutes";

export default {

    data() {

        return {
            profile: null,
            loading: false,
        }

    },

    mounted() {

        this.getMe()

    },

    methods: {

        getMe: function () {
            ApiService.POST(ApiRoutes.Profile, {}, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    this.profile = res.data
                }
            })
        },

    }

}

</script>
