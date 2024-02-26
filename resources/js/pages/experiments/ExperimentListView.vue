<template>
  <v-data-table-server
    v-model:items-per-page="itemsPerPage"
    :headers="headers"
    item-value="name"
    :items="experiments"
    :items-length="totalItems"
    :loading="isLoading"
    :search="search"
    @update:options="loadItems"
  >
    <template #top>
      <v-toolbar title="Experiments">
        <v-btn
          prepend-icon="mdi-plus-circle"
          variant="elevated"
          @click="onCreateExperimentClicked"
        >
          Create Experiment
        </v-btn>
      </v-toolbar>
    </template>
    <template #item="{ item }">
      <tr @click="onRowClick(item)">
        <td>{{ item.id }}</td>
        <td>{{ item.name }}</td>
        <td>{{ item.created_by }}</td>
        <td class="text-right">
          {{ parseDate(item.created_at) }}
        </td>
      </tr>
    </template>
  </v-data-table-server>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useExperimentsListMutation } from "@/api/queries/experimentQueries";
import {parseDate} from "@/utils/timeUtils";

const router = useRouter();
const {isLoading, mutateAsync} = useExperimentsListMutation();
const itemsPerPage = ref(5);
const headers= [
  {
    title: 'ID',
    align: 'start',
    sortable: true,
    key: 'id',
  },
  {
    title: "Name",
    align: "start",
    sortable: true,
    key: "name"
  },
  { title: 'Created By', key: 'createdBy', align: 'start' },
  { title: 'Created At', key: 'createdAt', align: 'end' },
];

const search = ref('');
const experiments = ref([]);
const totalItems = ref(0);

const loadItems = () => {
  mutateAsync().then(({data}) => {
    experiments.value = data.experiments;
    totalItems.value = data.experiments.length;
  });
};

const onRowClick = (item) => {
  router.push(`/experiments/${item.id}`);
};

const onCreateExperimentClicked = () => {
  router.push("/experiments/add");
};
</script>