<template>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebHomeSettings'}" class="w-100 btn rounded-pill"
                     :class="{'btn-danger': current_page === 'WebHomeSettings', 'btn-outline-secondary': current_page !== 'WebHomeSettings'}">Homepage</router-link>
    </div>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebSafetySettings'}" class="w-100 btn rounded-pill"
                     :class="{'btn-danger': current_page === 'WebSafetySettings', 'btn-outline-secondary': current_page !== 'WebSafetySettings'}">Safety & Assurance</router-link>
    </div>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebEvaluationSettings'}" class="w-100 btn rounded-pill"
                     :class="{'btn-danger': current_page === 'WebEvaluationSettings', 'btn-outline-secondary': current_page !== 'WebEvaluationSettings'}">Manage AI Risk</router-link>
    </div>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebFairDecisionSettings'}" class="w-100 btn rounded-pill"
                     :class="{'btn-danger': current_page === 'WebFairDecisionSettings', 'btn-outline-secondary': current_page !== 'WebFairDecisionSettings'}">Fair Decision</router-link>
    </div>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebTrainingSettings'}" class="w-100 btn rounded-pill"
                     :class="{'btn-danger': current_page === 'WebTrainingSettings', 'btn-outline-secondary': current_page !== 'WebTrainingSettings'}">Training Hub</router-link>
    </div>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebAwarenessSettings'}" class="w-100 btn rounded-pill"
                     :class="{'btn-danger': current_page === 'WebAwarenessSettings', 'btn-outline-secondary': current_page !== 'WebAwarenessSettings'}">Awareness</router-link>
    </div>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebCertificationSettings'}" class="w-100 btn rounded-pill"
                     :class="{'btn-danger': current_page === 'WebCertificationSettings', 'btn-outline-secondary': current_page !== 'WebCertificationSettings'}">Certification</router-link>
    </div>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebTeamSettings'}" class="w-100 btn rounded-pill"
                     :class="{'btn-danger': current_page === 'WebTeamSettings', 'btn-outline-secondary': current_page !== 'WebTeamSettings'}">Team</router-link>
    </div>

    <hr>

    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebMetaSettings'}" class="w-100 btn rounded-pill"
        :class="{'btn-danger': current_page === 'WebMetaSettings', 'btn-outline-secondary': current_page !== 'WebMetaSettings'}">Meta Info</router-link>
    </div>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebContactSettings'}" class="w-100 btn rounded-pill"
        :class="{'btn-danger': current_page === 'WebContactSettings', 'btn-outline-secondary': current_page !== 'WebContactSettings'}">Contact</router-link>
    </div>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebSocialSettings'}" class="w-100 btn rounded-pill"
        :class="{'btn-danger': current_page === 'WebSocialSettings', 'btn-outline-secondary': current_page !== 'WebSocialSettings'}">Social</router-link>
    </div>

    <hr>

    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebPrivacyPolicySettings'}" class="w-100 btn rounded-pill" :class="{'btn-danger': current_page === 'WebPrivacyPolicySettings', 'btn-outline-secondary': current_page !== 'WebPrivacyPolicySettings'}">Privacy Policy</router-link>
    </div>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebCookiePolicySettings'}" class="w-100 btn rounded-pill" :class="{'btn-danger': current_page === 'WebCookiePolicySettings', 'btn-outline-secondary': current_page !== 'WebCookiePolicySettings'}">Cookie Policy</router-link>
    </div>
    <div class="w-100 mb-3">
        <router-link :to="{name: 'WebTermsSettings'}" class="w-100 btn rounded-pill" :class="{'btn-danger': current_page === 'WebTermsSettings', 'btn-outline-secondary': current_page !== 'WebTermsSettings'}">Terms & Conditions</router-link>
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
