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
    <template #item="{ item }">
      <tr class="elevation-2 rounded-xl">
        <td>{{ item.id }}</td>
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
import { useExperimentsListMutation } from "@/api/queries/experimentQueries";
import {parseDate} from "@/utils/timeUtils";

const {isLoading, mutateAsync} = useExperimentsListMutation();
const itemsPerPage = ref(5);
const headers= [
  {
    title: 'ID',
    align: 'start',
    sortable: true,
    key: 'id',
  },
  { title: 'Created By', key: 'createdBy', align: 'start' },
  { title: 'Created At', key: 'createdAt', align: 'end' },
];

const search = ref('');
const experiments = ref([]);
const totalItems = ref(0);

const loadItems = () => {
  mutateAsync().then(({data}) => {
    console.log(data);
    experiments.value = data.experiments;
    totalItems.value = data.experiments.length;
  });
};
</script>
