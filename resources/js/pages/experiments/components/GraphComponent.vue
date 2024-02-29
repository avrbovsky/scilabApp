<template>
  <apexchart
    :options="options"
    :series="dataSeries"
    type="line"
  />
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    data: {
        type: Array,
        required: true
    }
});

const dataSeries = computed(()=> {
    const series = props.data.reduce((prevVal, nextVal)=>{
        const values = Object.values(nextVal);

        return [[...prevVal[0], values[1]],[...prevVal[1], values[2]]];
    },[[],[],[]]);

  const keys = Object.keys(props.data[0]);
  const mappedSeries = series.map((ser, idx) => ({name: keys[idx+1], data: ser}));

  return mappedSeries;
});

const xAxis = computed(()=>
    props.data.map(data => {
        const values = Object.values(data);
        return values[0];
    })
);

const options = computed(()=>({
    chart: {
        id: "scilab-simulation"
    },
    xaxis: {
        categories: xAxis.value
    }
}));
</script>