<template>
  <div class="grow">
    <!-- Panel body -->
    <div class="p-6 space-y-6">
      <h2 class="text-2xl text-slate-800 font-bold mb-5">
        Authentication Settings
      </h2>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableFbLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-square-facebook fa-fw text-blue-600 dark:text-blue-600"
              />
              Facebook
              <a
                v-tippy="'Get Credentials'"
                href="https://developers.facebook.com/"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableFbLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appGoogleAnalyticsKey'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appFbId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appFbSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appFbRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
        </div>
      </div>
    </div>

    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div class="setting-group mb-3">
        <div
          v-for="setting in authSettings"
          :key="'auth_setting_' + setting.id"
          class="mb-3"
        >
          <div v-if="setting.key == 'enableTwitterLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-twitter fa-fw text-blue-300 dark:text-blue-300"
              />
              Twitter
              <a
                v-tippy="'Get Credentials'"
                href="https://apps.twitter.com/"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableTwitterLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appTwitterId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appTwitterSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appTwitterRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
        </div>
      </div>
    </div>

    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div class="setting-group mb-3">
        <div
          v-for="setting in authSettings"
          :key="'auth_setting_' + setting.id"
          class="mb-3"
        >
          <div v-if="setting.key == 'enableGoogleLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-google fa-fw text-green-600 dark:text-green-500"
              />
              Google
              <a
                v-tippy="'Get Credentials'"
                href="https://console.developers.google.com/"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableGoogleLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appGoogleId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appGoogleSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appGoogleRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
        </div>
      </div>
    </div>

    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div class="setting-group mb-3">
        <div
          v-for="setting in authSettings"
          :key="'auth_setting_' + setting.id"
          class="mb-3"
        >
          <div v-if="setting.key == 'enableInstagramLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-instagram fa-fw text-yellow-600 dark:text-yellow-400"
              />
              Instagram
              <a
                v-tippy="'Get Credentials'"
                href="https://instagram.com/developer/register/"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>

          <AppSettingToggle
            v-if="setting.key == 'enableInstagramLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appInstagramId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appInstagramSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appInstagramRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableGitHubLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-github fa-fw text-gray-100 dark:text-gray-100"
              />
              Github
              <a
                v-tippy="'Get Credentials'"
                href="https://github.com/settings/applications/new"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableGitHubLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appGitHubId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appGitHubSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appGitHubRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appGitHubRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableLinkedInLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-linkedin fa-fw text-blue-600 dark:text-blue-600"
              />
              LinkedIn
              <a
                v-tippy="'Get Credentials'"
                href="https://www.linkedin.com/developers/apps/"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>

          <AppSettingToggle
            v-if="setting.key == 'enableLinkedInLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appLinkedInId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appLinkedInSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appLinkedInRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appLinkedInRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableTwitchLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-twitch fa-fw text-blue-600 dark:text-blue-600"
              />
              Twitch
              <a
                v-tippy="'Get Credentials'"
                href="https://dev.twitch.tv/docs/authentication/"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>

          <AppSettingToggle
            v-if="setting.key == 'enableTwitchLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appTwitchId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appTwitchSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appTwitchRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appTwitchRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableYouTubeLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-youtube fa-fw text-red-500 dark:text-red-500"
              />
              YouTube
              <a
                v-tippy="'Get Credentials'"
                href="https://developers.google.com/youtube/v3/getting-started"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableYouTubeLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appYouTubeId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appYouTubeSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appYouTubeRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appYouTubeRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableAppleLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-apple fa-fw text-white-500 dark:text-white-500"
              />
              Apple
              <a
                v-tippy="'Get Credentials'"
                href="https://developer.okta.com/blog/2019/06/04/what-the-heck-is-sign-in-with-apple"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableAppleLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appAppleId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appAppleSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appAppleTeamId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appAppleKeyId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appApplePrivateKey'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appAppleRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appAppleRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableMicrosoftLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-microsoft fa-fw text-blue-300 dark:text-blue-300"
              />
              Microsoft
              <a
                v-tippy="'Get Credentials'"
                href=""
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableMicrosoftLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appMicrosoftId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appMicrosoftSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appMicrosoftRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appMicrosoftRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableTikTokLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-tiktok fa-fw text-pink-500 dark:text-pink-500"
              />
              TikTok
              <a
                v-tippy="'Get Credentials'"
                href="https://developers.tiktok.com/"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableTikTokLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appTikTokId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appTikTokSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appTikTokRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appTikTokRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableZoHoLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fas fa-z fa-fw text-yellow-400 dark:text-yellow-300"
              />
              <img
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
              <span class="sr-only"> ZoHo </span>
              <a
                v-tippy="'Get Credentials'"
                href="https://api-console.zoho.com/"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableZoHoLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appZoHoId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appZoHoSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appZoHoRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appZoHoRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableStackExchangeLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-stack-exchange fa-fw text-blue-400 dark:text-blue-400"
              />
              Stack Exchange
              <a
                v-tippy="'Get Credentials'"
                href="https://stackapps.com/apps/oauth/register/"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableStackExchangeLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appStackExchangeId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appStackExchangeKey'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appStackExchangeSite'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appStackExchangeSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appStackExchangeRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appStackExchangeRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableGitLabLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-square-gitlab fa-fw text-orange-400 dark:text-orange-400"
              />
              GitLab
              <a
                v-tippy="'Get Credentials'"
                href="https://gitlab.com/oauth/applications"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableGitLabLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appGitLabId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appGitLabSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appGitLabRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appGitLabRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableRedditLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-square-reddit fa-fw text-orange-700 dark:text-orange-600"
              />
              Reddit
              <a
                v-tippy="'Get Credentials'"
                href="https://www.reddit.com/prefs/apps"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableRedditLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appRedditId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appRedditSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appRedditResponseType'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appRedditState'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appRedditRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appRedditRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableSnapchatLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-square-snapchat fa-fw text-yellow-400 dark:text-yellow-400"
              />
              Snapchat
              <a
                v-tippy="'Get Credentials'"
                href="https://devportal.snap.com/manage/"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableSnapchatLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appSnapchatId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appSnapchatSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appSnapchatRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appSnapchatRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableMeetupLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-meetup fa-fw text-red-400 dark:text-red-400"
              />
              Meetup
              <a
                v-tippy="'Get Credentials'"
                href="https://www.meetup.com/api/oauth/list/"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableMeetupLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appMeetupId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appMeetupSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appMeetupRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appMeetupRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
      </div>
    </div>
    <div class="card bg-gray-100 p-4 m-4 shadow-black">
      <div
        v-for="setting in authSettings"
        :key="'auth_setting_' + setting.id"
        class="mb-3"
      >
        <div class="setting-group mb-3">
          <div v-if="setting.key == 'enableAtlassianLogin'">
            <h4 class="w-100 mb-3 text-xl font-semibold">
              <span
                class="fa-brands fa-atlassian fa-fw text-blue-800 dark:text-blue-800"
              />
              Atlassian
              <a
                v-tippy="'Get Credentials'"
                href="https://developer.atlassian.com/console/myapps/"
                target="_blank"
                class="text-blue-300 duration-300 ease-in-out hover:text-blue-400"
              >
                <span class="fa-solid fa-circle-info fa-fw fa-sm" />
              </a>
            </h4>
          </div>
          <AppSettingToggle
            v-if="setting.key == 'enableAtlassianLogin'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appAtlassianId'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appAtlassianSecret'"
            class="ml-8 mr-5 mb-3"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <AppSettingTextInput
            v-if="setting.key == 'appAtlassianRedirect'"
            class="ml-8 mr-5"
            :setting="setting"
            :loading="loading"
            :disabled="!dataReady"
            @update-setting="appSettingUpdateTriggered"
          />
          <div
            v-if="setting.key == 'appAtlassianRedirect'"
            class="ml-8 mr-5 mt-4 mb-5 border border-b-slate-300"
          />
        </div>
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
  name: 'Authentication',
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
