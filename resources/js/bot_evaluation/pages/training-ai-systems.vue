<template>

    <div class="card shadow">
        <div class="card-header py-3">
            <h3 class="text-center m-0"><strong>Risk Evaluation Process</strong></h3>
        </div>
        <div class="card-body py-3 px-md-5 px-3">

            <div class="w-100 mt-3 mb-5">

                <h4><strong class="text-secondary">Here are some examples of AI tools and technologies that are suitable for different domains of companies:</strong></h4>

                <div class="w-100 mt-4 shadow p-sm-5 p-3">
                    <h5><strong class="text-dark">Agriculture:</strong></h5>
                    <ul class="w-100 m-0 mt-3">
                        <li class="mb-3"><strong class="text-secondary">Precision Agriculture Solutions:</strong> <br> These use AI and IoT sensors to optimize crop management, irrigation, and pest control for higher yields.</li>

                        <li class="mb-3"><strong class="text-secondary">Crop Disease Detection:</strong> <br> AI-powered image recognition can identify diseases and pests in crops, allowing for targeted treatment.</li>

                        <li><strong class="text-secondary">Predictive Weather Analytics:</strong> <br> AI can analyse weather data to provide accurate forecasts, helping farmers plan planting and harvesting schedules.</li>
                    </ul>
                </div>
                <div class="w-100 mt-4 shadow p-sm-5 p-3">
                    <h5><strong class="text-dark">Healthcare:</strong></h5>
                    <ul class="w-100 m-0 mt-3">
                        <li class="mb-3"><strong class="text-secondary">Medical Imaging Analysis:</strong> <br> AI algorithms can assist in the analysis of medical images like X-rays, MRIs, and CT scans for faster and more accurate diagnoses.</li>

                        <li class="mb-3"><strong class="text-secondary">Clinical Decision Support Systems:</strong> <br> These provide healthcare professionals with evidence-based recommendations for treatment.</li>

                        <li><strong class="text-secondary">Natural Language Processing (NLP) for Electronic Health Records:</strong> <br> NLP can extract valuable insights from unstructured medical data.</li>
                    </ul>
                </div>
                <div class="w-100 mt-4 shadow p-sm-5 p-3">
                    <h5><strong class="text-dark">Business and Finance:</strong></h5>
                    <ul class="w-100 m-0 mt-3">
                        <li class="mb-3"><strong class="text-secondary">Fraud Detection:</strong> <br> AI algorithms can analyse transaction data to identify suspicious activities and prevent fraud.</li>

                        <li class="mb-3"><strong class="text-secondary">Customer Relationship Management (CRM):</strong> <br> AI-powered CRM systems use data to personalize interactions, improve sales forecasting, and enhance customer service.</li>

                        <li><strong class="text-secondary">Predictive Analytics for Financial Markets:</strong> <br> AI can analyse market data to make predictions about stock prices and investment strategies.</li>
                    </ul>
                </div>
                <div class="w-100 mt-4 shadow p-sm-5 p-3">
                    <h5><strong class="text-dark">Art and Creativity:</strong></h5>
                    <ul class="w-100 m-0 mt-3">
                        <li class="mb-3"><strong class="text-secondary">Generative Adversarial Networks (GANs):</strong> <br> These can be used to generate new, original art based on existing styles or patterns.</li>

                        <li class="mb-3"><strong class="text-secondary">Style Transfer:</strong> <br> AI can apply the style of one image to another, creating unique and artistic visual effects.</li>

                        <li><strong class="text-secondary">Music Composition:</strong> <br> AI models can generate original music compositions based on input parameters like genre, mood, and tempo.</li>
                    </ul>
                </div>
                <div class="w-100 mt-4 shadow p-sm-5 p-3">
                    <h5><strong class="text-dark">Industry and Manufacturing:</strong></h5>
                    <ul class="w-100 m-0 mt-3">
                        <li class="mb-3"><strong class="text-secondary">Predictive Maintenance:</strong> <br> AI can analyse sensor data to predict when equipment is likely to fail, allowing for proactive maintenance.</li>

                        <li class="mb-3"><strong class="text-secondary">Quality Control and Inspection:</strong> <br> AI-powered vision systems can identify defects in manufacturing processes.</li>

                        <li><strong class="text-secondary">Supply Chain Optimization:</strong> <br> AI can optimize inventory levels, demand forecasting, and distribution for more efficient operations.</li>
                    </ul>
                </div>
                <div class="w-100 mt-4 shadow p-sm-5 p-3">
                    <h5><strong class="text-dark">Engineering and Design:</strong></h5>
                    <ul class="w-100 m-0 mt-3">
                        <li class="mb-3"><strong class="text-secondary">Generative Design:</strong> <br> AI can assist in the creation of optimized design solutions based on specified parameters and constraints.</li>

                        <li class="mb-3"><strong class="text-secondary">Finite Element Analysis (FEA):</strong> <br> AI algorithms can assist in simulating and analysing the structural integrity of designs.</li>

                        <li><strong class="text-secondary">Automated Code Generation:</strong> <br> In software engineering, AI can help generate code snippets or even entire applications based on high-level instructions.</li>
                    </ul>
                </div>

            </div>

        </div>
        <div class="card-footer py-3 px-md-5 d-flex align-items-center justify-content-between">
            <router-link :to="{name: 'PlanningAiSystems'}" class="btn btn-lg btn-outline-secondary rounded-pill px-5 ">Back</router-link>
            <a href="/training" class="btn btn-lg btn-success rounded-pill px-5"><span class="d-sm-inline d-none">Go to </span>Training <i class="fa fa-fw fa-arrow-right d-sm-inline d-none"></i></a>
        </div>
    </div>

</template>


<script>
export default {
    data() {
        return {
        }
    },
    computed: {},
    watch: {},
    methods: {},
    created() {

    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

