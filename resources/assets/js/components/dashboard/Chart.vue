<template>
    <VueApexCharts :options="options" :series="series" />
</template>
<script>
import VueApexCharts from "vue-apexcharts"

export default {
    name: "CardDashboardChart",
    components: { VueApexCharts },
    props: ['series', 'options']
}
</script>
