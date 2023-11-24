<template>
  <!--  <div class="mx-auto max-w-screen-md text-gray-900">-->
  <!--    <div class="flex justify-center">-->
  <!--      <div class="flex-1">-->
  <!--        <div class="w-auto rounded border">-->
  <!--          <div class="border-b p-4 font-semibold text-gray-600">Register</div>-->

  <!--          <div class="rounded bg-white p-4 dark:bg-slate-800">-->
  <!--            <errors-->
  <!--              v-if="errors && useInlineMessage"-->
  <!--              :content="errors"-->
  <!--              type="error"-->
  <!--              @close="errors = null"-->
  <!--            />-->

  <!--            <form-->
  <!--              class="mx-auto w-full rounded md:w-10/12 md:p-4"-->
  <!--              @submit.prevent="register"-->
  <!--            >-->
  <!--              <div-->
  <!--                class="my-1 w-full py-2 sm:flex sm:items-center sm:justify-between"-->
  <!--              >-->
  <!--                <label-->
  <!--                  for="Name"-->
  <!--                  class="w-4/12"-->
  <!--                  :class="-->
  <!--                    errors && errors.name-->
  <!--                      ? 'text-red-500'-->
  <!--                      : 'text-gray-700 dark:text-gray-200'-->
  <!--                  "-->
  <!--                >-->
  <!--                  Name-->
  <!--                </label>-->
  <!--                <input-->
  <!--                  v-model="form.name"-->
  <!--                  type="text"-->
  <!--                  name="name"-->
  <!--                  :class="{ 'border-red-500': errors && errors.name }"-->
  <!--                  :disabled="loading"-->
  <!--                  class="mt-3 w-full rounded border border-gray-300 bg-white p-2 focus:outline-none sm:mt-0 sm:w-8/12"-->
  <!--                />-->
  <!--              </div>-->
  <!--              <div-->
  <!--                class="my-1 w-full py-2 sm:flex sm:items-center sm:justify-between"-->
  <!--              >-->
  <!--                <label-->
  <!--                  for="Email"-->
  <!--                  class="w-4/12"-->
  <!--                  :class="-->
  <!--                    errors && errors.email-->
  <!--                      ? 'text-red-500'-->
  <!--                      : 'text-gray-700 dark:text-gray-200'-->
  <!--                  "-->
  <!--                >-->
  <!--                  Email-->
  <!--                </label>-->
  <!--                <input-->
  <!--                  v-model="form.email"-->
  <!--                  type="email"-->
  <!--                  name="email"-->
  <!--                  :class="{ 'border-red-500': errors && errors.email }"-->
  <!--                  :disabled="loading"-->
  <!--                  class="mt-3 w-full rounded border border-gray-300 bg-white p-2 focus:outline-none sm:mt-0 sm:w-8/12"-->
  <!--                />-->
  <!--              </div>-->
  <!--              <div-->
  <!--                class="my-1 w-full py-2 sm:flex sm:items-center sm:justify-between"-->
  <!--              >-->
  <!--                <label-->
  <!--                  for="Password"-->
  <!--                  class="w-4/12"-->
  <!--                  :class="-->
  <!--                    errors && errors.password-->
  <!--                      ? 'text-red-500'-->
  <!--                      : 'text-gray-700 dark:text-gray-200'-->
  <!--                  "-->
  <!--                >-->
  <!--                  Password-->
  <!--                </label>-->
  <!--                <input-->
  <!--                  v-model="form.password"-->
  <!--                  type="password"-->
  <!--                  name="password"-->
  <!--                  autocomplete="on"-->
  <!--                  :class="{ 'border-red-500': errors && errors.password }"-->
  <!--                  :disabled="loading"-->
  <!--                  class="mt-3 w-full rounded border border-gray-300 bg-white p-2 focus:outline-none sm:mt-0 sm:w-8/12"-->
  <!--                />-->
  <!--              </div>-->
  <!--              <div-->
  <!--                class="my-1 w-full py-2 sm:flex sm:items-center sm:justify-between"-->
  <!--              >-->
  <!--                <label-->
  <!--                  for="Password confirm"-->
  <!--                  class="w-4/12"-->
  <!--                  :class="-->
  <!--                    errors && errors.password-->
  <!--                      ? 'text-red-500'-->
  <!--                      : 'text-gray-700 dark:text-gray-200'-->
  <!--                  "-->
  <!--                >-->
  <!--                  Confirm Password-->
  <!--                </label>-->
  <!--                <input-->
  <!--                  v-model="form.password_confirmation"-->
  <!--                  type="password"-->
  <!--                  name="password_confirmation"-->
  <!--                  :class="{ 'border-red-500': errors && errors.password }"-->
  <!--                  :disabled="loading"-->
  <!--                  class="mt-3 w-full rounded border border-gray-300 bg-white p-2 focus:outline-none sm:mt-0 sm:w-8/12"-->
  <!--                />-->
  <!--              </div>-->

  <!--              <div-->
  <!--                class="my-1 w-full rounded py-2 sm:flex sm:items-center sm:justify-end"-->
  <!--              >-->
  <!--                <div-->
  <!--                  class="mt-3 flex w-full items-center justify-between rounded sm:mt-0 sm:w-8/12"-->
  <!--                >-->
  <!--                  <AppButton-->
  <!--                    primary-->
  <!--                    :loading="loading"-->
  <!--                    :disabled="loading"-->
  <!--                    :text="loading ? 'Register' : 'Register'"-->
  <!--                    btn-class="uppercase leading-snug inline-block rounded bg-blue-600 px-7 py-3 text-sm font-medium uppercase leading-snug text-white shadow-md transition duration-150 ease-in-out hover:bg-indigo-700 hover:shadow-lg focus:bg-indigo-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-indigo-800 active:shadow-lg "-->
  <!--                    type="submit"-->
  <!--                  >-->
  <!--                    <template #text>-->
  <!--                      <ArrowRightOnRectangleIcon-->
  <!--                        v-if="!loading"-->
  <!--                        class="mr-2 h-6 w-6"-->
  <!--                      />-->
  <!--                      <CircleSvg v-if="loading" class="mr-2 h-6 w-6" />-->
  <!--                      Register-->
  <!--                    </template>-->
  <!--                  </AppButton>-->

  <!--                  <span class="text-sm">-->
  <!--                    <span-->
  <!--                      class="mr-1 cursor-default text-gray-700 dark:text-gray-200"-->
  <!--                    >-->
  <!--                      Already a member?-->
  <!--                    </span>-->
  <!--                    <router-link-->
  <!--                      :to="{ name: 'login' }"-->
  <!--                      class="text-sm font-bold text-blue-500 hover:text-blue-300"-->
  <!--                    >-->
  <!--                      Sign In-->
  <!--                    </router-link>-->
  <!--                  </span>-->
  <!--                </div>-->
  <!--              </div>-->
  <!--            </form>-->

  <!--            <div v-if="socialLoginsEnabled" class="mt-5">-->
  <!--              <div-->
  <!--                class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-gray-300 after:mt-0.5 after:flex-1 after:border-t after:border-gray-300"-->
  <!--              >-->
  <!--                <p class="mx-4 mb-0 text-center font-semibold">Or</p>-->
  <!--              </div>-->
  <!--              <h3 class="mb-3 font-bold text-gray-700">Register with</h3>-->
  <!--              <SocialiteLogins />-->
  <!--            </div>-->
  <!--          </div>-->
  <!--        </div>-->
  <!--      </div>-->
  <!--    </div>-->
  <!--  </div>-->

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
              Create your Account ✨
            </h1>
            <!-- Form -->
            <errors
              v-if="errors && useInlineMessage"
              :content="errors"
              type="error"
              @close="errors = null"
            />
            <form @submit.prevent="register">
              <div class="space-y-4">
                <div>
                  <label
                    for="Name"
                    class="block text-sm font-medium mb-1"
                    :class="
                      errors && errors.name
                        ? 'text-red-500'
                        : 'text-gray-700 dark:text-gray-200'
                    "
                  >
                    Name
                    <span class="text-rose-500">*</span>
                  </label>
                  <input
                    v-model="form.name"
                    type="text"
                    name="name"
                    :class="{ 'border-red-500': errors && errors.name }"
                    :disabled="loading"
                    class="form-input w-full"
                  />
                </div>
                <div>
                  <label
                    for="Email"
                    class="block text-sm font-medium mb-1"
                    :class="
                      errors && errors.email
                        ? 'text-red-500'
                        : 'text-gray-700 dark:text-gray-200'
                    "
                  >
                    Email<span class="text-rose-500">*</span>
                  </label>
                  <input
                    v-model="form.email"
                    type="email"
                    name="email"
                    :class="{ 'border-red-500': errors && errors.email }"
                    :disabled="loading"
                    class="form-input w-full"
                  />
                </div>
                <div>
                  <label
                    for="Password"
                    class="block text-sm font-medium mb-1"
                    :class="
                      errors && errors.password
                        ? 'text-red-500'
                        : 'text-gray-700 dark:text-gray-200'
                    "
                  >
                    Password<span class="text-rose-500">*</span>
                  </label>
                  <input
                    v-model="form.password"
                    type="password"
                    name="password"
                    autocomplete="on"
                    :class="{ 'border-red-500': errors && errors.password }"
                    :disabled="loading"
                    class="form-input w-full"
                  />
                </div>
                <div>
                  <label
                    for="Password confirm"
                    class="block text-sm font-medium mb-1"
                    :class="
                      errors && errors.password
                        ? 'text-red-500'
                        : 'text-gray-700 dark:text-gray-200'
                    "
                  >
                    Confirm Password<span class="text-rose-500">*</span>
                  </label>
                  <input
                    v-model="form.password_confirmation"
                    type="password"
                    name="password_confirmation"
                    :class="{ 'border-red-500': errors && errors.password }"
                    :disabled="loading"
                    class="form-input w-full"
                  />
                </div>
              </div>
              <div class="flex items-center justify-between mt-6">
                <div class="mr-1">
                  <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox" />
                    <span class="text-sm ml-2"
                      >Email me about product news.</span
                    >
                  </label>
                </div>
                <AppButton
                  primary
                  :loading="loading"
                  :disabled="loading"
                  :text="loading ? 'Register' : 'Register'"
                  btn-class="uppercase leading-snug inline-block rounded bg-blue-600 px-7 py-3 text-sm font-medium uppercase leading-snug text-white shadow-md transition duration-150 ease-in-out hover:bg-indigo-700 hover:shadow-lg focus:bg-indigo-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-indigo-800 active:shadow-lg "
                  type="submit"
                >
                  <template #text>
                    <ArrowRightOnRectangleIcon
                      v-if="!loading"
                      class="mr-2 h-6 w-6"
                    />
                    <CircleSvg v-if="loading" class="mr-2 h-6 w-6" />
                    Register
                  </template>
                </AppButton>
              </div>
            </form>
            <!-- Footer -->
            <div class="pt-5 mt-6 border-t border-slate-200">
              <div class="text-sm">
                Have an account?
                <router-link
                  class="font-medium text-indigo-500 hover:text-indigo-600"
                  to="/login"
                  >Sign In
                </router-link>
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
import { mapGetters, mapActions } from 'vuex';
import CircleSvg from '@components/CircleSvg.vue';
import { ArrowRightOnRectangleIcon } from '@heroicons/vue/24/outline';
import Errors from '@components/Errors.vue';
import SocialiteLogins from '@components/auth/SocialiteLogins.vue';
import AppButton from '@/components/common/AppButton.vue';

export default {
  components: {
    AppButton,
    ArrowRightOnRectangleIcon,
    CircleSvg,
    Errors,
    SocialiteLogins,
  },
  props: {
    showSmLogin: { type: Boolean, default: true },
  },
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
      errors: null,
      loading: false,
      useInlineMessage: false,
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
  methods: {
    ...mapActions({
      registerApp: 'auth/register',
      popToast: 'toast/popToast',
    }),
    async register() {
      this.loading = true;
      this.errors = null;
      this.success = '';
      try {
        await this.registerApp(this.form).then((response) => {
          this.loading = false;
          this.$router.push({ name: 'dashboard' });
        });
      } catch (e) {
        if (e.response.status === 422) {
          this.errors = e.response.data.errors;
          // this.errors = {}
          // this.errors.message = Object.values(e.response.data.errors)
          //   .flat()
          //   .toString()
          // this.errors.errors = Object.values(e.response.data.errors)
          this.popToast({
            message: Object.values(e.response.data.errors).flat().toString(),
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
