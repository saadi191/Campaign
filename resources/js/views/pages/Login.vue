<template>
  <main class="bg-white">
    <div class="relative flex">
      <!-- Content -->
      <div class="w-full md:w-1/2">
        <div class="min-h-screen h-full flex flex-col after:flex-1">
          <div class="flex-1">
            <div
              class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8"
            >
              <!-- Logo -->
              <router-link class="block" to="/">
                <svg width="32" height="32" viewBox="0 0 32 32">
                  <defs>
                    <linearGradient
                      id="logo-a"
                      x1="28.538%"
                      y1="20.229%"
                      x2="100%"
                      y2="108.156%"
                    >
                      <stop stop-color="#A5B4FC" stop-opacity="0" offset="0%" />
                      <stop stop-color="#A5B4FC" offset="100%" />
                    </linearGradient>
                    <linearGradient
                      id="logo-b"
                      x1="88.638%"
                      y1="29.267%"
                      x2="22.42%"
                      y2="100%"
                    >
                      <stop stop-color="#38BDF8" stop-opacity="0" offset="0%" />
                      <stop stop-color="#38BDF8" offset="100%" />
                    </linearGradient>
                  </defs>
                  <rect fill="#6366F1" width="32" height="32" rx="16" />
                  <path
                    d="M18.277.16C26.035 1.267 32 7.938 32 16c0 8.837-7.163 16-16 16a15.937 15.937 0 01-10.426-3.863L18.277.161z"
                    fill="#4F46E5"
                  />
                  <path
                    d="M7.404 2.503l18.339 26.19A15.93 15.93 0 0116 32C7.163 32 0 24.837 0 16 0 10.327 2.952 5.344 7.404 2.503z"
                    fill="url(#logo-a)"
                  />
                  <path
                    d="M2.223 24.14L29.777 7.86A15.926 15.926 0 0132 16c0 8.837-7.163 16-16 16-5.864 0-10.991-3.154-13.777-7.86z"
                    fill="url(#logo-b)"
                  />
                </svg>
              </router-link>
            </div>
          </div>

          <div class="max-w-sm mx-auto px-4 py-8">
            <h1 class="text-3xl text-slate-800 font-bold mb-6">
              Welcome back! ✨
            </h1>
            <!-- Form -->
            <form @submit.prevent="login">
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium mb-1" for="email"
                    >Email Address</label
                  >
                  <input
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="form-control m-0 block w-full rounded border border-solid border-gray-300 bg-white bg-clip-padding px-4 py-2 text-xl font-normal text-gray-700 transition ease-in-out focus:border-blue-600 focus:bg-white focus:text-gray-700 focus:outline-none"
                    :class="{ 'border-red-500': errors && errors.email }"
                    :disabled="loading"
                    placeholder="Email Address"
                  />
                  <div
                    v-if="errors && errors.email"
                    class="mt-1 text-sm text-red-500"
                  >
                    {{ errors.email[0] }}
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-medium mb-1" for="password"
                    >Password</label
                  >
                  <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    autocomplete="on"
                    class="form-control m-0 block w-full rounded border border-solid border-gray-300 bg-white bg-clip-padding px-4 py-2 text-xl font-normal text-gray-700 transition ease-in-out focus:border-blue-600 focus:bg-white focus:text-gray-700 focus:outline-none"
                    :class="{ 'border-red-500': errors && errors.password }"
                    :disabled="loading"
                    placeholder="Password"
                  />
                  <div
                    v-if="errors && errors.password"
                    class="mt-1 text-sm text-red-500"
                  >
                    {{ errors.password[0] }}
                  </div>
                </div>
              </div>
              <div class="flex items-center justify-between mt-6">
                <div class="mr-1">
                  <router-link
                    class="text-sm underline hover:no-underline"
                    to="/reset-password"
                    >Forgot Password?
                  </router-link>
                </div>
                <AppButton
                  primary
                  :loading="loading"
                  :disabled="loading"
                  :text="loading ? 'Login' : 'Login'"
                  btn-class="leading-snug px-7 py-3 text-sm uppercase leading-snug shadow-md"
                  type="submit"
                >
                  <template #text>
                    <ArrowRightOnRectangleIcon
                      v-if="!loading"
                      class="mr-2 h-6 w-6"
                    />
                    <CircleSvg v-if="loading" class="mr-2 h-6 w-6" />
                    Login
                  </template>
                </AppButton>
              </div>
            </form>
            <!-- Footer -->
            <div class="pt-5 mt-6 border-t border-slate-200">
              <div class="text-sm">
                Don’t you have an account?
                <router-link
                  class="font-medium text-indigo-500 hover:text-indigo-600"
                  to="/register"
                  >Sign Up
                </router-link>
              </div>
              <!-- Warning -->
              <div class="mt-5">
                <div class="bg-amber-100 text-amber-600 px-3 py-2 rounded">
                  <svg
                    class="inline w-3 h-3 shrink-0 fill-current mr-2"
                    viewBox="0 0 12 12"
                  >
                    <path
                      d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"
                    />
                  </svg>
                  <span class="text-sm">
                    To support you during the pandemic super pro features are
                    free until March 31st.
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Image -->
      <div
        class="hidden md:block absolute top-0 bottom-0 right-0 md:w-1/2"
        aria-hidden="true"
      >
        <img
          class="object-cover object-center w-full h-full"
          src="../../../img/auth/auth-image.jpg"
          width="760"
          height="1024"
          alt="Authentication decoration"
        />
        <img
          class="absolute top-1/4 left-0 -translate-x-1/2 ml-8 hidden lg:block"
          src="../../../img/auth/auth-decoration.png"
          width="218"
          height="224"
          alt="Authentication decoration"
        />
      </div>
    </div>
  </main>
</template>

<script>
import { ArrowRightOnRectangleIcon } from '@heroicons/vue/24/outline';
import { mapGetters, mapActions } from 'vuex';
import CircleSvg from '@components/CircleSvg.vue';
import SocialiteLogins from '@components/auth/SocialiteLogins.vue';
import AppButton from '@/components/common/AppButton.vue';

export default {
  name: 'Login',
  components: {
    AppButton,
    ArrowRightOnRectangleIcon,
    CircleSvg,
    SocialiteLogins,
  },
  props: {
    showSmLogin: { type: Boolean, default: true },
  },
  setup() {
    return {};
  },
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      errors: null,
      loading: false,
    };
  },
  computed: {
    ...mapGetters({
      logins: 'auth/logins',
    }),
    socialLoginsEnabled() {
      if (!this.showSmLogin) {
        return false;
      }
      const a = Object.values(this.logins);
      const b = a.find((v) => v == '1');
      if (b) {
        return true;
      }
      return false;
    },
  },
  watch: {},
  methods: {
    ...mapActions({
      appLogin: 'auth/login',
      popToast: 'toast/popToast',
    }),
    async login() {
      this.loading = true;
      this.errors = null;
      try {
        await this.appLogin(this.form).then((response) => {
          this.loading = false;
          // this.$router.push({ name: 'home' })
        });
      } catch (e) {
        if (e.status === 422) {
          this.errors = e.data.errors;
          this.popToast({
            message: Object.values(this.errors).flat().toString(),
            timer: 5000,
            icon: 'error',
          });
        }
        if (e.status === 401) {
          this.popToast({
            message: 'Invalid Email or Password',
            timer: 5000,
            icon: 'error',
          });
        }
        this.loading = false;
      }
    },
  },
};
</script>
