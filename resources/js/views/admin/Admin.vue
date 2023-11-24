<template>
  <div id="admin" class="bg-white p-3 dark:bg-slate-800 dark:text-gray-200">
    <div v-if="roles" class="float-right mb-6 text-center">
      <RolesBadges :roles="roles" />
    </div>
    <nav class="mb-6 text-sm font-semibold" aria-label="Breadcrumb">
      <ol class="inline-flex list-none p-0">
        <li class="flex items-center">
          <router-link
            v-if="authenticated && roles && (roles.admin || roles.superAdmin)"
            v-slot="{ isActive }"
            :to="{ name: 'admin' }"
            class="text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400"
          >
            <span
              :class="[
                isActive &&
                  'cursor-default text-gray-800 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-500',
              ]"
            >
              Admin
            </span>
          </router-link>
        </li>
      </ol>
    </nav>
    <div
      class="relative bg-indigo-200 p-4 sm:p-6 rounded-sm overflow-hidden mb-8"
    >
      <div
        class="absolute right-0 top-0 -mt-4 mr-16 pointer-events-none hidden xl:block"
        aria-hidden="true"
      >
        <svg
          width="319"
          height="198"
          xmlns:xlink="http://www.w3.org/1999/xlink"
        >
          <defs>
            <path id="welcome-a" d="M64 0l64 128-64-20-64 20z" />
            <path id="welcome-e" d="M40 0l40 80-40-12.5L0 80z" />
            <path id="welcome-g" d="M40 0l40 80-40-12.5L0 80z" />
            <linearGradient id="welcome-b" x1="50%" y1="0%" x2="50%" y2="100%">
              <stop stop-color="#A5B4FC" offset="0%" />
              <stop stop-color="#818CF8" offset="100%" />
            </linearGradient>
            <linearGradient
              id="welcome-c"
              x1="50%"
              y1="24.537%"
              x2="50%"
              y2="100%"
            >
              <stop stop-color="#4338CA" offset="0%" />
              <stop stop-color="#6366F1" stop-opacity="0" offset="100%" />
            </linearGradient>
          </defs>
          <g fill="none" fill-rule="evenodd">
            <g transform="rotate(64 36.592 105.604)">
              <mask id="welcome-d" fill="#fff">
                <use xlink:href="#welcome-a" />
              </mask>
              <use fill="url(#welcome-b)" xlink:href="#welcome-a" />
              <path
                fill="url(#welcome-c)"
                mask="url(#welcome-d)"
                d="M64-24h80v152H64z"
              />
            </g>
            <g transform="rotate(-51 91.324 -105.372)">
              <mask id="welcome-f" fill="#fff">
                <use xlink:href="#welcome-e" />
              </mask>
              <use fill="url(#welcome-b)" xlink:href="#welcome-e" />
              <path
                fill="url(#welcome-c)"
                mask="url(#welcome-f)"
                d="M40.333-15.147h50v95h-50z"
              />
            </g>
            <g transform="rotate(44 61.546 392.623)">
              <mask id="welcome-h" fill="#fff">
                <use xlink:href="#welcome-g" />
              </mask>
              <use fill="url(#welcome-b)" xlink:href="#welcome-g" />
              <path
                fill="url(#welcome-c)"
                mask="url(#welcome-h)"
                d="M40.333-15.147h50v95h-50z"
              />
            </g>
          </g>
        </svg>
      </div>
      <div class="relative">
        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-1">
          {{ greeting }}, {{ user.name }}! 👋
        </h1>
        <p>Here is what’s happening with your projects today:</p>
      </div>
    </div>
  </div>

  <div class="row mt-5">
    <div class="columns-2 mx-4">
      <router-link to="/admin/app-settings">
        <article class="bg-white shadow-md rounded border border-slate-200 p-5">
          <div class="flex flex-start space-x-4">
            <!-- Avatar -->
            <div class="shrink-0 mt-1.5">
              <!--        <img-->
              <!--          class="w-8 h-8 rounded-full"-->
              <!--          src="../../images/user-32-02.jpg"-->
              <!--          width="32"-->
              <!--          height="32"-->
              <!--          alt="User 02"-->
              <!--        />-->
              <span
                data-v-bff71982=""
                class="fas fa-lock fa-fw fa-3x text-gray-700 dark:text-gray-300"
              ></span>
            </div>
            <!-- Content -->
            <div class="grow">
              <!-- Title -->
              <h2 class="font-semibold text-slate-800 mb-2">
                <p
                  data-v-bff71982=""
                  class="text-3xl font-semibold text-gray-700 dark:text-gray-300"
                >
                  <!--v-if--><span
                    data-v-bff71982=""
                    class="fa-brands fa-square-facebook fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-twitter fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-instagram fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-github fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-youtube fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-google fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-linkedin fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-twitch fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-apple fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-microsoft fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><!--
                    <span
                      class="rounded-xl"
                      :class="
                        checkSettingEnabled('enableZoHoLogin')
                          ? 'bg-yellow-300 dark:bg-yellow-600'
                          : ''
                      "
                      style="
                        height: 24px;
                        display: inline-block;
                        padding: 0 6px 0 0;
                        margin: 0;
                        line-height: 0.9;
                      "
                    >
                      <img
                        v-if="!loading"
                        id="zoho"
                        :src="zohoImgUrl"
                        alt="Zoho"
                        class=""
                        style="
                          width: 100%;
                          max-width: 60px;
                          margin: -10px 0 0 5px;
                          display: inline-block;
                        "
                      />
                    </span>
                    --><span
                    data-v-bff71982=""
                    class="fa fa-z fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-stack-exchange fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-square-gitlab fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-square-reddit fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-square-snapchat fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-meetup fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span
                  ><span
                    data-v-bff71982=""
                    class="fa-brands fa-atlassian fa-fw fa-xs text-gray-300 dark:text-gray-800"
                  ></span>
                </p>
              </h2>
              <!-- Footer -->
              <footer class="flex flex-wrap text-sm">
                <div
                  class="flex items-center after:block after:content-['·'] last:after:content-[''] after:text-sm after:text-slate-400 after:px-2"
                >
                  <a
                    class="font-medium text-indigo-500 hover:text-indigo-600"
                    href="#0"
                    >Login Enabled</a
                  >
                </div>
              </footer>
            </div>
            <!-- Upvote button -->
          </div>
        </article>
      </router-link>
      <router-link to="/admin/users">
        <article class="bg-white shadow-md rounded border border-slate-200 p-5">
          <div class="flex flex-start space-x-4">
            <!-- Avatar -->
            <div class="shrink-0 mt-1.5">
              <span
                data-v-bff71982=""
                class="fas fa-user fa-fw fa-3x text-gray-700 dark:text-gray-300"
              ></span>
            </div>
            <!-- Content -->
            <div class="grow">
              <!-- Title -->
              <h2 class="font-semibold text-slate-800 mb-2">
                <p
                  class="text-3xl font-semibold text-gray-700 dark:text-gray-300"
                >
                  <span
                    v-if="loading"
                    class="fas fa-circle-notch fa-spin fa-xs"
                  />
                  <span v-if="!loading">
                    {{ users.length }}
                  </span>
                </p>
              </h2>
              <!-- Footer -->
              <footer class="flex flex-wrap text-sm">
                <div
                  class="flex items-center after:block after:content-['·'] last:after:content-[''] after:text-sm after:text-slate-400 after:px-2"
                >
                  <a
                    class="font-medium text-indigo-500 hover:text-indigo-600"
                    href="#0"
                    >Registered Users</a
                  >
                </div>
              </footer>
            </div>
          </div>
        </article>
      </router-link>
    </div>
  </div>

  <div class="row mt-3">
    <div class="columns-2 mx-4">
      <router-link to="/admin/app-settings">
        <article class="bg-white shadow-md rounded border border-slate-200 p-5">
          <div class="flex flex-start space-x-4">
            <!-- Avatar -->
            <div class="shrink-0 mt-1.5">
              <!--        <img-->
              <!--          class="w-8 h-8 rounded-full"-->
              <!--          src="../../images/user-32-02.jpg"-->
              <!--          width="32"-->
              <!--          height="32"-->
              <!--          alt="User 02"-->
              <!--        />-->
              <span
                data-v-bff71982=""
                class="fa-brands fa-google fa-fw fa-3x text-gray-700 dark:text-gray-300"
              ></span>
            </div>
            <!-- Content -->
            <div class="grow">
              <!-- Title -->
              <h2 class="font-semibold text-slate-800 mb-2">
                <p
                  class="text-3xl font-semibold text-gray-700 dark:text-gray-300"
                >
                  <span
                    v-if="loading"
                    class="fas fa-circle-notch fa-spin fa-xs"
                  />
                  <span
                    v-if="!loading"
                    :class="analyticsEnabled ? 'text-yellow-500' : ''"
                  >
                    {{ analyticsEnabled ? 'Enabled' : 'Disabled' }}
                    <div
                      style="
                        font-size: 0.25em;
                        line-height: 1;
                        margin-left: 2px;
                        margin-top: -4px;
                        position: absolute;
                      "
                    >
                      {{ analyticsTag }}
                    </div>
                  </span>
                </p>
              </h2>
              <!-- Footer -->
              <footer class="flex flex-wrap text-sm">
                <div
                  class="flex items-center after:block after:content-['·'] last:after:content-[''] after:text-sm after:text-slate-400 after:px-2"
                >
                  <a
                    class="font-medium text-indigo-500 hover:text-indigo-600"
                    href="#0"
                    >Google Analytics</a
                  >
                </div>
              </footer>
            </div>
            <!-- Upvote button -->
          </div>
        </article>
      </router-link>
      <router-link to="/admin/app-settings">
        <article class="bg-white shadow-md rounded border border-slate-200 p-5">
          <div class="flex flex-start space-x-4">
            <!-- Avatar -->
            <div class="shrink-0 mt-1.5">
              <svg
                data-v-bff71982=""
                class="css-1mxa28m e10nushx4 float-left mr-1"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 65 65"
                width="60"
                height="65"
                style="margin-top: -1px; margin-right: 5px"
              >
                <path
                  data-v-bff71982=""
                  d="M29,2.26a4.67,4.67,0,0,0-8,0L14.42,13.53A32.21,32.21,0,0,1,32.17,40.19H27.55A27.68,27.68,0,0,0,12.09,17.47L6,28a15.92,15.92,0,0,1,9.23,12.17H4.62A.76.76,0,0,1,4,39.06l2.94-5a10.74,10.74,0,0,0-3.36-1.9l-2.91,5a4.54,4.54,0,0,0,1.69,6.24A4.66,4.66,0,0,0,4.62,44H19.15a19.4,19.4,0,0,0-8-17.31l2.31-4A23.87,23.87,0,0,1,23.76,44H36.07a35.88,35.88,0,0,0-16.41-31.8l4.67-8a.77.77,0,0,1,1.05-.27c.53.29,20.29,34.77,20.66,35.17a.76.76,0,0,1-.68,1.13H40.6q.09,1.91,0,3.81h4.78A4.59,4.59,0,0,0,50,39.43a4.49,4.49,0,0,0-.62-2.28Z"
                  transform="translate(11, 11)"
                  fill="#362d59"
                ></path>
              </svg>
            </div>
            <!-- Content -->
            <div class="grow">
              <!-- Title -->
              <h2 class="font-semibold text-slate-800 mb-2">
                <p
                  class="text-3xl font-semibold text-gray-700 dark:text-gray-300"
                >
                  <span
                    v-if="loading"
                    class="fas fa-circle-notch fa-spin fa-xs"
                  />
                  <span
                    v-if="!loading"
                    :class="sentryEnabled ? 'text-red-500' : ''"
                  >
                    {{ sentryEnabled ? 'Enabled' : 'Disabled' }}
                    <div
                      style="
                        font-size: 0.25em;
                        line-height: 1;
                        margin-left: 1px;
                        margin-top: -4px;
                        position: absolute;
                      "
                    >
                      {{ sentryDSN }}
                      {{ sentryDSN && sentryFormEnabled ? ' / ' : '' }}
                      {{ sentryFormEnabled ? 'Feedback Enabled' : '' }}
                    </div>
                  </span>
                </p>
              </h2>
              <!-- Footer -->
              <footer class="flex flex-wrap text-sm">
                <div
                  class="flex items-center after:block after:content-['·'] last:after:content-[''] after:text-sm after:text-slate-400 after:px-2"
                >
                  <a
                    class="font-medium text-indigo-500 hover:text-indigo-600"
                    href="#0"
                    >Setry.io Monitoring</a
                  >
                </div>
              </footer>
            </div>
          </div>
        </article>
      </router-link>
    </div>
  </div>

  <div class="row mt-3">
    <div class="columns-2 mx-4">
      <router-link to="/admin/roles">
        <article class="bg-white shadow-md rounded border border-slate-200 p-5">
          <div class="flex flex-start space-x-4">
            <!-- Avatar -->
            <div class="shrink-0 mt-1.5">
              <!--        <img-->
              <!--          class="w-8 h-8 rounded-full"-->
              <!--          src="../../images/user-32-02.jpg"-->
              <!--          width="32"-->
              <!--          height="32"-->
              <!--          alt="User 02"-->
              <!--        />-->
              <span
                data-v-bff71982=""
                class="fas fa-shield-alt fa-fw fa-3x text-gray-700 dark:text-gray-300"
              ></span>
            </div>
            <!-- Content -->
            <div class="grow">
              <!-- Title -->
              <h2 class="font-semibold text-slate-800 mb-2">
                <p
                  class="text-3xl font-semibold text-gray-700 dark:text-gray-300"
                >
                  <span
                    v-if="loading"
                    class="fas fa-circle-notch fa-spin fa-xs"
                  />
                  <span v-if="!loading">
                    {{ rolesData.length }}
                  </span>
                </p>
              </h2>
              <!-- Footer -->
              <footer class="flex flex-wrap text-sm">
                <div
                  class="flex items-center after:block after:content-['·'] last:after:content-[''] after:text-sm after:text-slate-400 after:px-2"
                >
                  <a
                    class="font-medium text-indigo-500 hover:text-indigo-600"
                    href="#0"
                    >Roles</a
                  >
                </div>
              </footer>
            </div>
            <!-- Upvote button -->
          </div>
        </article>
      </router-link>
      <router-link to="/admin/permissions">
        <article class="bg-white shadow-md rounded border border-slate-200 p-5">
          <div class="flex flex-start space-x-4">
            <!-- Avatar -->
            <div class="shrink-0 mt-1.5">
              <span
                data-v-bff71982=""
                class="fas fa-shield-alt fa-fw fa-3x text-gray-700 dark:text-gray-300"
              ></span>
            </div>
            <!-- Content -->
            <div class="grow">
              <!-- Title -->
              <h2 class="font-semibold text-slate-800 mb-2">
                <p
                  class="text-3xl font-semibold text-gray-700 dark:text-gray-300"
                >
                  <span
                    v-if="loading"
                    class="fas fa-circle-notch fa-spin fa-xs"
                  />
                  <span v-if="!loading">
                    {{ permissionsData.length }}
                  </span>
                </p>
              </h2>
              <!-- Footer -->
              <footer class="flex flex-wrap text-sm">
                <div
                  class="flex items-center after:block after:content-['·'] last:after:content-[''] after:text-sm after:text-slate-400 after:px-2"
                >
                  <a
                    class="font-medium text-indigo-500 hover:text-indigo-600"
                    href="#0"
                    >Permissions</a
                  >
                </div>
              </footer>
            </div>
          </div>
        </article>
      </router-link>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import axios from 'axios';
// import Chart from 'chart.js';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
import RolesBadges from '@components/roles/RolesBadges.vue';
import zohoLight from '@img/vendor-logos/zoho-monocrome-white.png';
import zohoDark from '@img/vendor-logos/zoho-monocrome-black.png';

export default {
  name: 'Admin',
  components: {
    ChevronRightIcon,
    RolesBadges,
  },
  props: {},
  setup() {
    return {};
  },
  data() {
    return {
      dataReady: false,
      loading: false,
      users: [],
      rolesData: [],
      permissionsData: [],
      authSettings: [],
      analyticsData: [],
      monitoringData: [],
      GA_TAG: GA_TAG, // eslint-disable-line
      GA_ENABLED: GA_ENABLED, // eslint-disable-line
      APP_URL: APP_URL, // eslint-disable-line
      SENTRY_DSN: SENTRY_DSN, // eslint-disable-line
      SENTRY_ENABLED: SENTRY_ENABLED, // eslint-disable-line
      SENTRY_FEEDBACK_ENABLED: SENTRY_FEEDBACK_ENABLED, // eslint-disable-line
      // buyersData: {
      //   type: 'line',
      //   data: {
      //     labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      //     datasets: [
      //       {
      //         backgroundColor: 'rgba(99,179,237,0.4)',
      //         strokeColor: '#63b3ed',
      //         pointColor: '#fff',
      //         pointStrokeColor: '#63b3ed',
      //         data: [203, 156, 99, 251, 305, 247, 256],
      //       },
      //       {
      //         backgroundColor: 'rgba(198,198,198,0.4)',
      //         strokeColor: '#f7fafc',
      //         pointColor: '#fff',
      //         pointStrokeColor: '#f7fafc',
      //         data: [86, 97, 144, 114, 94, 108, 156],
      //       },
      //     ],
      //   },
      //   options: {
      //     legend: {
      //       display: false,
      //     },
      //     scales: {
      //       yAxes: [
      //         {
      //           gridLines: {
      //             display: false,
      //           },
      //           ticks: {
      //             display: false,
      //           },
      //         },
      //       ],
      //       xAxes: [
      //         {
      //           gridLines: {
      //             display: false,
      //           },
      //         },
      //       ],
      //     },
      //   },
      // },
      // reviewsData: {
      //   type: 'bar',
      //   data: {
      //     labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      //     datasets: [
      //       {
      //         backgroundColor: 'rgba(99,179,237,0.4)',
      //         strokeColor: '#63b3ed',
      //         pointColor: '#fff',
      //         pointStrokeColor: '#63b3ed',
      //         data: [203, 156, 99, 251, 305, 247, 256],
      //       },
      //     ],
      //   },
      //   options: {
      //     legend: {
      //       display: false,
      //     },
      //     scales: {
      //       yAxes: [
      //         {
      //           gridLines: {
      //             display: false,
      //           },
      //           ticks: {
      //             display: false,
      //           },
      //         },
      //       ],
      //       xAxes: [
      //         {
      //           gridLines: {
      //             display: false,
      //           },
      //         },
      //       ],
      //     },
      //   },
      // },
    };
  },
  computed: {
    ...mapGetters({
      authenticated: 'auth/authenticated',
      user: 'auth/user',
      roles: 'auth/roles',
    }),
    greeting() {
      const date = new Date();
      const currentTime = date.getHours();
      let greeting;
      if (currentTime >= 0 && currentTime <= 12) {
        greeting = 'Good Morning';
      } else if (currentTime > 12 && currentTime <= 18) {
        greeting = 'Good Afternoon';
      } else {
        greeting = 'Good Evening';
      }
      return greeting;
    },
    analyticsEnabled() {
      const found = this.analyticsData.find(
        (obj) => obj.key == 'enableGoogleAnalytics',
      );
      if (found && found.val && found.val == 1) {
        return true;
      }
      return false;
    },
    analyticsTag() {
      const found = this.analyticsData.find(
        (obj) => obj.key == 'appGoogleAnalyticsKey',
      );
      if (found && found.val && found.val != '') {
        return null;
        // return found.val;
      }
      return 'MISSING TAG ID';
    },
    sentryEnabled() {
      const found = this.monitoringData.find(
        (obj) => obj.key == 'enableSentryMonitoring',
      );
      if (found && found.val && found.val == 1) {
        return true;
      }
      return false;
    },
    sentryFormEnabled() {
      const found = this.monitoringData.find(
        (obj) => obj.key == 'enableSentryMonitoringFeedbakForm',
      );
      if (found && found.val && found.val == 1) {
        return true;
      }
      return false;
    },
    sentryDSN() {
      const found = this.monitoringData.find((obj) => obj.key == 'sentryIoDSN');
      if (found && found.val && found.val != '') {
        return null;
      }
      return 'MISSING DSN (URL)';
    },
    zohoImgUrl() {
      if (this.user && this.user.theme_dark) {
        return zohoLight;
      } else {
        return zohoDark;
      }
    },
  },
  mounted() {
    this.getDashboardData();
    // new Chart(document.getElementById('buyers-chart'), this.buyersData);
    // new Chart(document.getElementById('reviews-chart'), this.reviewsData);
  },
  methods: {
    ...mapActions({
      popToast: 'toast/popToast',
    }),
    async getDashboardData() {
      this.loading = true;
      await axios
        .get('/api/dashboard/data')
        .then(({ data }) => {
          this.users = data.users;
          this.rolesData = data.roles;
          this.authSettings = data.authSettings;
          this.permissionsData = data.permissions;
          this.analyticsData = data.analytics;
          this.monitoringData = data.monitoring;
          this.dataReady = true;
          this.loading = false;
        })
        .catch(({ response }) => {
          this.popToast({
            message: 'Error Getting Users',
            timer: 5000,
            icon: 'error',
          });
          this.dataReady = true;
        });
      this.dataReady = true;
    },
    checkSettingEnabled(key = null) {
      let found = false;
      let enabled = false;
      if (key) {
        found = this.authSettings.find((obj) => obj.key == key);
        if (found && found.val == 1) {
          enabled = true;
        }
      }
      return enabled;
    },
  },
};
</script>

<style scoped>
.fa-xs {
  font-size: 0.75em !important;
}
</style>
<style lang="scss" scoped></style>
