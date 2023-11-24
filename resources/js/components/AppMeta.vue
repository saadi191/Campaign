<template>
  <!--    <h3 class="text-2xl font-semibold">App Meta Settings</h3>-->
  <!--    <hr class="mt-3 w-10 pb-4" />-->
  <!--    <div-->
  <!--      v-for="setting in metaSettings"-->
  <!--      :key="'monitoring_settings_' + setting.id"-->
  <!--      class="mb-3"-->
  <!--    >-->
  <!--      <div class="setting-group mb-3">-->
  <!--        <AppSettingTextInput-->
  <!--          v-if="setting.key == 'appName'"-->
  <!--          class="ml-8 mr-5"-->
  <!--          :setting="setting"-->
  <!--          :loading="loading"-->
  <!--          :disabled="!dataReady"-->
  <!--          @update-setting="appSettingUpdateTriggered"-->
  <!--        />-->

  <!--        <AppSettingTextInput-->
  <!--          v-if="setting.key == 'author'"-->
  <!--          class="ml-8 mr-5"-->
  <!--          :setting="setting"-->
  <!--          :loading="loading"-->
  <!--          :disabled="!dataReady"-->
  <!--          @update-setting="appSettingUpdateTriggered"-->
  <!--        />-->

  <!--        <AppSettingTextarea-->
  <!--          v-if="setting.key == 'description'"-->
  <!--          class="ml-8 mr-5"-->
  <!--          :setting="setting"-->
  <!--          :loading="loading"-->
  <!--          :disabled="!dataReady"-->
  <!--          @update-setting="appSettingUpdateTriggered"-->
  <!--        />-->
  <!--        &lt;!&ndash;-->
  <!--            keywords-->
  <!--           &ndash;&gt;-->
  <!--      </div>-->
  <!--    </div>-->

  <div class="grow">
    <!-- Panel body -->
    <div class="p-6 space-y-6">
      <h2 class="text-2xl text-slate-800 font-bold mb-5">App Meta Settings</h2>
    </div>
    <div
      v-for="setting in metaSettings"
      :key="'appMeta_settings_' + setting.id"
      class="mb-3"
    >
      <div class="setting-group mb-3">
        <AppSettingTextInput
          v-if="setting.key == 'appName'"
          class="ml-8 mr-5"
          :setting="setting"
          :loading="loading"
          :disabled="!dataReady"
          @update-setting="appSettingUpdateTriggered"
        />
        <AppSettingTextInput
          v-if="setting.key == 'author'"
          class="ml-8 mr-5"
          :setting="setting"
          :loading="loading"
          :disabled="!dataReady"
          @update-setting="appSettingUpdateTriggered"
        />

        <AppSettingTextarea
          v-if="setting.key == 'description'"
          class="ml-8 mr-5"
          :setting="setting"
          :loading="loading"
          :disabled="!dataReady"
          @update-setting="appSettingUpdateTriggered"
        />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
import { mapGetters, mapActions } from 'vuex';
import axios from 'axios';
import { track } from '@services/analytics';
import AppSettingToggle from '@components/form/AppSettingToggle.vue';
import AppSettingTextInput from '@components/form/AppSettingTextInput.vue';
import AppSettingTextarea from '@components/form/AppSettingTextarea.vue';
import zohoLight from '@img/vendor-logos/zoho-monocrome-white.png';
import zohoDark from '@img/vendor-logos/zoho-monocrome-black.png';
import { asteroids } from '@services/asteroids';
import toasty from 'toasty';

export default {
  name: 'AppMeta',
  components: {
    ChevronRightIcon,
    AppSettingToggle,
    AppSettingTextInput,
    AppSettingTextarea,
  },
  props: {},
  data() {
    return {
      dataReady: false,
      authSettings: null,
      analyticsSettings: null,
      generalSettings: null,
      monitoringSettings: null,
      metaSettings: null,
      secretSettings: null,
      loading: false,
      activeTab: 'Authentication',
      appGaEnabled: GA_ENABLED, // eslint-disable-line
      tabs: [
        { name: 'Authentication', icon: 'fa-solid fa-circle-user' },
        { name: 'Analytics', icon: 'fa-solid fa-chart-simple' },
        { name: 'Monitoring', icon: 'fa-solid fa-shield-halved' },
        // { name: 'General', icon: 'fa-solid fa-shield-halved' },
        { name: 'App Meta', icon: 'fa-solid fa-server' },
        { name: 'Secrets', icon: 'fa-solid fa-egg' },
      ],
    };
  },
  computed: {
    ...mapGetters({
      authenticated: 'auth/authenticated',
      user: 'auth/user',
      roles: 'auth/roles',
    }),
    sentryEnabled() {
      const status = this.monitoringSettings.find(
        (s) => s.key == 'enableSentryMonitoring',
      );
      if (status && status.val && status.val == 1) {
        return true;
      }
      return false;
    },
    zohoImgUrl() {
      if (this.user && this.user.theme_dark) {
        return zohoLight;
      } else {
        return zohoDark;
      }
    },
  },
  watch: {},
  created() {},
  mounted() {
    this.getAppSettings();
  },
  beforeUnmount() {},
  updated() {},
  methods: {
    ...mapActions({
      popToast: 'toast/popToast',
    }),
    track,
    async getAppSettings() {
      this.dataReady = false;
      await axios
        .get('/api/app-settings')
        .then(({ data }) => {
          this.authSettings = data.authSettings;
          this.analyticsSettings = data.analyticsSettings;
          this.generalSettings = data.generalSettings;
          this.monitoringSettings = data.monitoringSettings;
          this.metaSettings = data.metaSettings;
          this.secretSettings = data.secretSettings;
          this.dataReady = true;
        })
        .catch(({ response }) => {
          this.popToast({
            message: 'Error Getting App Settings',
            timer: 5000,
            icon: 'error',
          });
          this.dataReady = true;
        });
    },
    async updateSetting(newValue, setting) {
      let index = null;
      if (setting && setting.group && setting.group == 'auth') {
        // index = this.authSettings.indexOf(setting);
        index = this.authSettings.map((o) => o.name).indexOf(setting.name);
      }
      if (setting && setting.group && setting.group == 'analytics') {
        // index = this.analyticsSettings.indexOf(setting);
        index = this.analyticsSettings.map((o) => o.name).indexOf(setting.name);
      }
      if (setting && setting.group && setting.group == 'general') {
        // index = this.generalSettings.indexOf(setting);
        index = this.generalSettings.map((o) => o.name).indexOf(setting.name);
      }
      if (setting && setting.group && setting.group == 'monitoring') {
        // index = this.monitoringSettings.indexOf(setting);
        index = this.monitoringSettings
          .map((o) => o.name)
          .indexOf(setting.name);
      }
      if (setting && setting.group && setting.group == 'app-meta') {
        // index = this.metaSettings.indexOf(setting);
        index = this.metaSettings.map((o) => o.name).indexOf(setting.name);
      }

      if (setting && setting.group && setting.group == 'secrets') {
        // index = this.secretSettings.indexOf(setting);
        index = this.secretSettings.map((o) => o.name).indexOf(setting.name);
      }

      const a = setting;
      if (newValue != a.val) {
        setting.val = newValue;
        await axios
          .patch(`/api/app-settings/${setting.id}`, setting)
          .then(({ data }) => {
            const message = 'App Setting Updated';
            if (index !== -1) {
              if (setting && setting.group && setting.group == 'auth') {
                this.authSettings[index] = data.data;
              }
              if (setting && setting.group && setting.group == 'analytics') {
                this.analyticsSettings[index] = data.data;
              }
              if (setting && setting.group && setting.group == 'general') {
                this.generalSettings[index] = data.data;
              }
              if (setting && setting.group && setting.group == 'monitoring') {
                this.monitoringSettings[index] = data.data;
                // message = message + '. Reloading App.';
              }
              if (setting && setting.group && setting.group == 'app-meta') {
                this.metaSettings[index] = data.data;
              }
              if (setting && setting.group && setting.group == 'secrets') {
                this.secretSettings[index] = data.data;
              }
            }
            this.loading = false;
            this.popToast({
              message,
              timer: 5000,
              icon: 'success',
            });
            this.track(
              `App setting "${setting.name}" was updated from "${a.val}" to "${setting.val}"`,
              'app event',
              'app setting updated',
            );
          })
          .catch(({ response }) => {
            this.popToast({
              message: 'Error Updating Setting',
              timer: 5000,
              icon: 'error',
            });
            this.loading = false;
          });
      }
    },
    changeTab(tab) {
      this.activeTab = tab;
      this.track(`clicked tab: ${tab}`);
    },
    appSettingUpdateTriggered(val) {
      this.updateSetting(val.val, val.setting);
    },
    throwTestError() {
      this.popToast({
        message: 'Sentry Test Error Triggered',
        timer: 5000,
        icon: 'success',
      });
      throw new Error('Sentry Test Error');
    },
    triggerEasterEgg(egg = null) {
      if (egg == 'asteroids') {
        this.asteroids();
      } else if (egg == 'toasty') {
        this.toasty().trigger();
      }
    },
    asteroids,
    toasty,
  },
};
</script>
