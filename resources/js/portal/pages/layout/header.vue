<template>
    <div class="w-100">

        <!--Header-Area-->
        <div class="header bg-dark position-relative">
            <nav class="navbar navbar-expand-lg p-0">
                <div class="container-fluid px-5">
                    <a class="navbar-brand" href="/">Rai<span class="text-danger">DOT</span></a>
                    <button class="navbar-toggler shadow-none text-white" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-fw fa-2x fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <router-link class="nav-link" :to="{name: 'Dashboard'}">Dashboard</router-link>
                            </li>
                            <li class="nav-item ms-xl-4">
                                <div class="dropdown">
                                    <a class="btn btn-light rounded-pill shadow-none px-3 py-2" data-bs-toggle="dropdown">{{ UserInfo.name }} <i class="fa fa-fw fa-chevron-down"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end p-3 shadow" style="width: 250px">
                                        <li><router-link class="dropdown-item px-3 py-2 rounded-pill text-center" :to="{name: 'Profile'}">Profile</router-link></li>
                                        <li><a class="btn btn-warning w-100 rounded-pill mt-2" href="/logout">Logout</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <!--Header-Area/-->

    </div>
</template>

<script>
export default {
    data() {
        return {
            UserInfo: window.core.UserInfo
        }
    },
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
