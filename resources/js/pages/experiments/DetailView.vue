<template>
  <v-card class="h-100">
    <header-component
      :back-button="true"
      :title="$t('ExperimentDetailTitle')"
    >
      <v-btn
        v-if="data?.experiment?.created_by === currentLoggedUser.id"
        :density="width < 960 ? 'comfortable' : 'default'"
        icon
        :size="width < 600 ? 'small' : 'default'"
        :to="`/experiments/${data?.experiment?.id}/edit`"
        variant="tonal"
      >
        <v-icon>mdi-pencil</v-icon>
      </v-btn>
    </header-component>
    <v-card-text>
      <v-container>
        <div class="d-flex">
          <div class="text-md-h4 text-sm-h5">
            {{ data?.experiment?.name }}
          </div>
          <v-spacer />
          <div class="text-md-h5 text-sm-h6">
            <span class="font-weight-thin">{{ $t("By") }}:</span>
            <span>{{
              user?.user?.name || data?.experiment?.created_by
            }}</span>
          </div>
        </div>
        <v-divider />
        <simulate-form
          :context="data?.experiment?.context || ''"
          :loading="isPendingSimulation"
          :submit="handleSubmit"
        />
        <v-container>
          <graph-component :data="graphData" />
        </v-container>
      </v-container>
    </v-card-text>
  </v-card>
</template>

<script setup>
import { trans } from "laravel-vue-i18n";
import { useRoute } from "vue-router";
import { onMounted, watch, ref } from "vue";
import {
    useExperimentDetailMutation,
    useExperimentSimulateMutation,
} from "@/api/queries/experimentQueries";
import { useNotificationStore } from "@/stores/NotificationService";
import HeaderComponent from "./components/HeaderComponent.vue";
import GraphComponent from "./components/GraphComponent.vue";
import { useAuthStore } from "@/stores/Auth";
import { storeToRefs } from "pinia";
import SimulateForm from "./components/SimulateForm.vue";
import { useWindowSize } from "@vueuse/core";
import { useUserDetailMutation } from "@/api/queries/userQueries";

const { width } = useWindowSize();
const route = useRoute();
const { id } = route.params;
const graphData = ref([]);

const authStore = useAuthStore();
const { currentLoggedUser } = storeToRefs(authStore);

const { data, mutateAsync } = useExperimentDetailMutation();
const { data: user, mutateAsync: loadUser } = useUserDetailMutation();
const { mutateAsync: simulate, isPending: isPendingSimulation } =
    useExperimentSimulateMutation();

const { showSnackbar } = useNotificationStore();

onMounted(async () => {
    loadExperiment(id);
});

watch(route, () => {
    if (route.params.id) {
        loadExperiment(route.params.id);
    }
});

const loadExperiment = (experimentId) => {
    mutateAsync(experimentId)
        .then(({ experiment }) => loadUser(experiment.created_by))
        .catch((err) => console.error(err.message));
};

const handleSubmit = async (context) => {
    try {
        const { simulation } = await simulate({
            context,
            id: route.params.id,
        });

        showSnackbar(trans("ExperimentSimulationSuccess"), "success");
        graphData.value = simulation;
    } catch (_) {
        showSnackbar(trans("ExperimentSimulationError"), "error");
    }
};
</script>

<style scoped>
.v-card {
    display: flex !important;
    flex-direction: column;
}
.v-card-text {
    overflow: scroll;
    padding: 16;
}
</style>
