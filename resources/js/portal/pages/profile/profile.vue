<template>
    <div class="w-100">
        <div class="container">
            <div class="w-100 bg-white py-5">

                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="card shadow border py-5 px-sm-5 px-3">
                            <div class="w-100 text-center mt-5">
                                <img v-if="UserInfo.avatar == null" class="profile-avatar" :src="'/img/user.png'" alt="">
                                <img v-if="UserInfo.avatar != null" class="profile-avatar" :src="'/storage/media/image/'+UserInfo.avatar" alt="">
                            </div>
                            <div class="w-100 py-5">
                                <table class="table table-borderless">
                                    <tr>
                                        <td style="width: 50%" class="text-sm-end"><strong>Name:</strong></td>
                                        <td>{{ UserInfo.name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-sm-end"><strong>Email Address:</strong></td>
                                        <td>{{ UserInfo.email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-sm-end"><strong>Phone:</strong></td>
                                        <td>{{ UserInfo.phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-sm-end"><strong>Company:</strong></td>
                                        <td>{{ UserInfo.company }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-sm-end"><strong>Website:</strong></td>
                                        <td>{{ UserInfo.website }}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top" class="text-sm-end">
                                            <div class="w-100">
                                                <strong>Subscription:</strong>
                                            </div>
                                        </td>
                                        <td style="vertical-align: top">
                                            <div class="w-100" v-if="UserInfo.subscription_type !== 'premium'">
                                                <span class="badge bg-secondary">Free</span> <br> <a class="text-decoration-none" href="/pricing">Upgrade to Premium</a>
                                            </div>
                                            <div class="w-100" v-if="UserInfo.subscription_type === 'premium'">
                                                <span class="badge bg-success">Premium</span>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="w-100 text-center d-flex justify-content-center">
                                <router-link :to="{name: 'ProfileUpdate'}" class="btn btn-sm btn-primary rounded-pill px-sm-4 me-sm-3 me-2">Update Profile</router-link>
                                <router-link :to="{name: 'ProfilePasswordUpdate'}" class="btn btn-sm btn-warning rounded-pill px-sm-4 me-sm-3 me-0">Change Password</router-link>
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
            loading: 1,
            UserInfo: window.core.UserInfo
        }
    },
    computed: {},
    watch: {},
    methods: {
    },
    created() {
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>
