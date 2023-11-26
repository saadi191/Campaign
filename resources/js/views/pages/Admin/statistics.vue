<template>
  <div
    id="roles"
    class="bg-white p-3 dark:bg-slate-800 dark:text-gray-200"
    style="background-color: #f1f5f9"
  >
    <nav class="mb-6 text-sm font-semibold" aria-label="Breadcrumb">
      <ol class="inline-flex list-none p-0">
        <li class="flex items-center">
          <router-link
            v-if="authenticated && roles && (roles.admin || roles.superAdmin)"
            v-slot="{ isActive }"
            :to="{ name: 'admin' }"
            class="text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400"
          >
            Admin
          </router-link>
        </li>
        <li class="flex items-center">
          <ChevronRightIcon class="ml-2 mr-2 mt-0 h-4 w-4" />
        </li>
        <li class="flex items-center">
          <router-link
            v-if="authenticated && roles && (roles.admin || roles.superAdmin)"
            v-slot="{ isActive }"
            :to="{ name: 'view.statistics' }"
            class="text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400"
          >
            <span
              :class="[
                isActive &&
                  'cursor-default text-gray-800 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-500',
              ]"
            >
              Statistics
            </span>
          </router-link>
        </li>
      </ol>
    </nav>
    <div class="mb-1 sm:mb-0 ml-20">
      <h1 class="text-2xl md:text-3xl text-slate-800 font-bold float-left">
        Statistics ✨
      </h1>
    </div>

    <div
      class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2"
    >
      <form class="relative">
        <label for="action-search" class="sr-only">Search</label>
        <input
          id="action-search"
          class="form-input pl-4 focus:border-slate-300 w-[250px]"
          type="search"
          placeholder=""
        />
      </form>
    </div>

    <div class="grid grid-cols-8 gap-6 mt-4">
      <div
        class="flex flex-col col-span-full sm:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200"
      >
        <header class="px-5 py-4 border-b border-slate-100 flex items-center">
          <h2 class="font-semibold text-slate-800">Daily Participants</h2>
        </header>
        <LineChart
          v-if="chartData.labels.length > 0"
          :data="chartData"
          width="595"
          height="248"
        />
      </div>

      <div
        class="flex flex-col col-span-full sm:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200"
      >
        <header class="px-5 py-4 border-b border-slate-100 flex items-center">
          <h2 class="font-semibold text-slate-800">
            Participants with different cities
          </h2>
        </header>

        <BarChart
          v-if="BarchartData.labels.length > 0"
          :data="BarchartData"
          width="1000"
          height="248"
        />
      </div>

      <div
        class="flex flex-col col-span-full sm:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200"
      >
        <header class="px-5 py-4 border-b border-slate-100 flex items-center">
          <h2 class="font-semibold text-slate-800">
            Participants with different locations
          </h2>
        </header>

        <LocChart
          v-if="LocChartData.labels.length > 0"
          :data="LocChartData"
          width="1000"
          height="248"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapState } from 'vuex';
import axios from 'axios';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
import { ref, onMounted, onUnmounted } from 'vue';
import LineChart from '@/views/pages/charts/LineChart.vue';
import BarChart from '@/views/pages/charts/BarChart.vue';
import LocChart from '@/views/pages/charts/LocChart.vue';

import { Bar } from 'vue-chartjs';

export default {
  name: 'Statistics',
  components: {
    LineChart,
    ChevronRightIcon,
    BarChart,
    LocChart,
  },
  setup() {
    const chartData = ref({
      labels: [],
      datasets: [],
    });

    const BarchartData = ref({
      labels: [],
      datasets: [],
    });

    const LocChartData = ref({
      labels: [],
      datasets: [],
    });

    return {
      chartData,
      BarchartData,
      LocChartData,
    };
  },
  computed: {
    ...mapState('auth', {
      user: (state) => state.user,
    }),
    ...mapGetters({
      authenticated: 'auth/authenticated',
      user: 'auth/user',
      roles: 'auth/roles',
      logins: 'auth/logins',
    }),
  },
  mounted() {
    this.getStat();
  },
  methods: {
    async getStat() {
      try {
        const self = this;
        axios
          .get('/api/admin/stat')
          .then((response) => {
            this.chartData.labels = response.data.daily_participations.map(
              (x) => x['created_at'],
            );
            this.chartData.datasets = [
              {
                label: 'Participants',
                data: response.data.daily_participations.map(
                  (x) => x['participants'],
                ),
                borderColor: 'indigo',
                fill: false,
                borderWidth: 2,
                tension: 0,
                pointRadius: 0,
                pointHoverRadius: 3,
                pointBackgroundColor: 'indigo',
                clip: 20,
              },
              {
                label: 'Leaflets',
                data: response.data.daily_leaflets.map((x) => x['leaflets']),
                borderColor: 'blue',
                fill: false,
                borderWidth: 2,
                tension: 0,
                pointRadius: 0,
                pointHoverRadius: 3,
                pointBackgroundColor: 'blue',
                clip: 20,
              },
            ];
            const cities = response.data.city.map((x) => x['city']);
            Object.keys(cities).forEach(function (key) {
              if (cities[key] === null) {
                cities[key] = 'Not Defined';
              } else {
                // eslint-disable-next-line no-self-assign
                cities[key] = cities[key];
              }
            });

            const participants = response.data.city.map(
              (x) => x['participants'],
            );
            Object.keys(participants).forEach(function (key) {
              if (participants[key] === null) {
                participants[key] = 0;
              } else {
                // eslint-disable-next-line no-self-assign
                participants[key] = participants[key];
              }
            });

            this.BarchartData.labels = cities;
            this.BarchartData.datasets = participants;

            const locations = response.data.daily_locations.map(
              (x) => x['location'],
            );
            Object.keys(locations).forEach(function (key) {
              if (locations[key] === null) {
                locations[key] = 'Not Defined';
              } else {
                // eslint-disable-next-line no-self-assign
                locations[key] = locations[key];
              }
            });

            const participantsLoc = response.data.daily_locations.map(
              (x) => x['leaflets'],
            );

            Object.keys(participantsLoc).forEach(function (key) {
              if (participantsLoc[key] === null) {
                participantsLoc[key] = 0;
              } else {
                // eslint-disable-next-line no-self-assign
                participantsLoc[key] = participantsLoc[key];
              }
            });
            this.LocChartData.labels = locations;
            this.LocChartData.datasets = participantsLoc;
          })
          .catch((error) => {});
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
  },
};
</script>
