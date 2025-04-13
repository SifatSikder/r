<template>
    <div class="header">
        <nav class="navbar navbar-expand-lg bg-white border-bottom py-3 px-2 px-lg-5">
            <div class="container-fluid">
                <router-link class="navbar-brand MotLogo" :to="{name: 'Dashboard'}">Rai<span class="text-danger">DOT</span></router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-fw fa-2x fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item pe-3">
                            <router-link class="nav-link" :to="{name: 'Dashboard'}"><strong>Dashboard</strong></router-link>
                        </li>
                        <li class="nav-item px-3 dropdown">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><strong>Features</strong></a>
                            <ul class="dropdown-menu dropdown-menu-end shadow m-0 p-0" style="min-width: 250px">
                                <li class="text-secondary p-3 bg-light border-bottom mb-2"><strong>Management</strong></li>
                                <li class="m-2"><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'Users'}">Users</router-link></li>
                                <li class="m-2"><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'BlogList'}">News & Events</router-link></li>
                                <li class="m-2"><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'Workshops'}">Workshops</router-link></li>
                                <li class="text-secondary p-3 bg-light border-bottom border-top mb-2"><strong>Certification</strong></li>
                                <li class="m-2"><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'EvaluationCertification'}">Evaluation Certification</router-link></li>
                                <li class="m-2"><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'ParticipationCertification'}">Participation Certification</router-link></li>
                            </ul>
                        </li>
                        <li class="nav-item px-3 dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"><strong>Risk Evaluation</strong></a>
                            <ul class="dropdown-menu dropdown-menu-end shadow m-0 p-0" style="min-width: 250px">
                                <li class="text-secondary p-3 bg-light border-bottom mb-2"><strong>Evaluation Sectors</strong></li>
                                <li class="m-2"><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'Sectors'}">Select an Industry</router-link></li>
                                <li class="text-secondary p-3 bg-light border-bottom border-top mb-2"><strong>Questions</strong></li>
                            <!--<li class="m-2"><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'cgptQuestionnaires'}">ChatGPt Evaluation</router-link></li>-->
                                <li class="m-2"><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'ntQuestionnaires'}">Non Technical</router-link></li>
                                <li class="m-2"><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'etQuestionnaires'}">General Technical</router-link></li>
                                <li class="m-2"><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'etaQuestionnaires'}">Specific Application</router-link></li>
                            </ul>
                        </li>
                        <li class="nav-item px-3 dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"><strong>Fair Decision Analysis</strong></a>
                            <ul class="dropdown-menu dropdown-menu-end shadow m-0 p-0" style="min-width: 250px">
                                <li class="text-secondary p-3 bg-light border-bottom mb-2"><strong>Fair Decision</strong></li>
                                <li class="m-2"><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'FdSectors'}">Select an Industry</router-link></li>
                                <li class="text-secondary p-3 bg-light border-bottom border-top mb-2"><strong>Questions</strong></li>
                                <li class="m-2"><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'fdQuestionnaires'}">General Fair Decision</router-link></li>
                                <li class="m-2"><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'etaFdQuestionnaires'}">Specific Industry Fair Decision</router-link></li>
                            </ul>
                        </li>
                        <li class="nav-item px-3">
                            <router-link class="nav-link" :to="{name: 'Awareness'}"><strong>Awareness</strong></router-link>
                        </li>
                        <li class="nav-item px-3 dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"><strong>Settings</strong></a>
                            <ul class="dropdown-menu dropdown-menu-end p-3 shadow" style="min-width: 250px">
                                <li><router-link class="dropdown-item rounded-pill mb-1" :to="{name: 'WebHomeSettings'}">Website Settings</router-link></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="d-flex" role="search">
                        <div class="profile">
                            <div class="dropdown">
                                <div class="profile-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="profile-avatar">
                                        <img :src="'/img/user.png'" alt="">
                                    </div>
                                </div>
                                <ul class="dropdown-menu dropdown-menu-lg-end p-3 shadow-lg" style="min-width: 250px">
                                    <li><router-link class="dropdown-item rounded-pill text-center mb-1" :to="{name: 'Profile'}">Profile</router-link></li>
                                    <li><router-link class="dropdown-item rounded-pill text-center mb-1" :to="{name: 'EditProfile'}">Update Profile</router-link></li>
                                    <li><router-link class="dropdown-item rounded-pill text-center mb-1" :to="{name: 'ChangePassword'}">Change Password</router-link></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><router-link class="dropdown-item rounded-pill text-center mb-1" :to="{name: 'NotificationSettings'}">Notification Settings</router-link></li>
                                    <li><router-link class="dropdown-item rounded-pill text-center mb-1" :to="{name: 'AccountSettings'}">Account Settings</router-link></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="btn btn-sm btn-danger w-100 rounded-pill" href="javascript:void(0)" @click="Logout">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>
<script>


import ApiService from "../../services/ApiService.js";
import ApiRoutes from "../../services/ApiRoutes.js";

export default {
    data() {
        return {
            profile: window.UserInfo,
        }
    },
    computed: { },
    methods: {
        ProfileOption(){
            $('.profile-option').toggleClass('active')
        },

        getMe: function () {
            ApiService.POST(ApiRoutes.Profile, {}, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    this.profile = res.data
                }
            })
        },
        langOption(){
            $('.lang-option').toggleClass('active')
        },
        setLang: function(lang) {
            if(window.localStorage.getItem('lang') != lang) {
                window.localStorage.setItem('lang', lang)
                location.reload();
            }

        },
        toggleMenu: function () {
            this.menuMini =  this.menuMini == false ? true : false;
            $('.sidenav').toggleClass('mini');
            $('.sidebar-toggler').toggleClass('active not-active');
            $('.main_section').toggleClass('full');
            if($('.sidenav').hasClass('active')){
                $('.sidenav').removeClass('active')
            }else{
                $('.sidenav').addClass('active')
            }
        },
        formInit(){
            setTimeout(() => {
                if (window.screen.width < 1025) {
                    $('.sidenav').toggleClass('mini');
                    $('.main_section').toggleClass('full');
                }
            })
            $(document).mouseup(function (e) {
                const container = $('.outsideClick');
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    container.removeClass('active');
                }
            });
            $(document).mouseup(function (e) {
                const container = $('.outsideClick2');
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    container.removeClass('active');
                }
            });
        },

        Logout() {
            this.logoutLoading = true;
            ApiService.POST(ApiRoutes.Logout, {}, (res) => {
                this.logoutLoading = false;
                if (parseInt(res.status) === 200) {
                    window.location.reload();
                }
            });
        },
    },
    created() {},
    mounted() {
        this.getMe()
        this.formInit()
    }
}
</script>
