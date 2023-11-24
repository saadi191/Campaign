<template>
  <div class="grow">
    <!-- Panel body -->
    <div class="p-6 space-y-6">
      <!-- Business Profile -->
      <section>
        <h3 class="text-xl leading-snug text-slate-800 font-bold mb-1">
          Profile
        </h3>
        <div class="text-sm font-medium text-gray-600 dark:text-gray-400">
          {{
            verified
              ? `Verified on: ${moment(verified).format('MMM Do YYYY, h:mma')}`
              : 'Not verified !'
          }}
        </div>

        <Success v-if="success" :content="success" @close="success = null" />
        <Errors v-if="errors" :content="errors" @close="errors = null" />
        <form @submit.prevent="update">
          <div
            class="sm:flex sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-5"
          >
            <div class="sm:w-1/3">
              <label class="block text-sm font-medium mb-1" for="name"
                >Name</label
              >
              <input
                id="name"
                v-model="form.name"
                class="form-input w-full"
                type="text"
                name="name"
              />
            </div>
            <div class="sm:w-1/3">
              <label class="block text-sm font-medium mb-1" for="business-id"
                >Email</label
              >
              <input
                id="email"
                v-model="form.email"
                class="form-input w-full"
                type="email"
                name="email"
              />
            </div>
          </div>
          <footer class="mt-4">
            <div class="flex flex-col px-6 py-5">
              <div class="flex self-end">
                <Button
                  class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-3"
                  :loading="loading"
                  :disabled="loading"
                  :text="loading ? 'Update' : 'Update'"
                >
                  Update
                  <template #text>
                    <CircleSvg v-if="loading" class="mr-2 h-5 w-5" />
                    Update
                  </template>
                </Button>
              </div>
            </div>
          </footer>
        </form>
      </section>
    </div>
    <!-- Panel footer -->
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Errors from '@components/Errors.vue';
import Success from '@components/Success.vue';
import CircleSvg from '@components/CircleSvg.vue';
import moment from 'moment';
import swal from 'sweetalert2';

export default {
  components: {
    Errors,
    Success,
    CircleSvg,
  },
  data() {
    return {
      form: {
        email: '',
        name: '',
        theme_dark: false,
      },
      errors: null,
      success: '',
      loading: false,
    };
  },
  computed: {
    ...mapGetters({
      verified: 'auth/verified',
      user: 'auth/user',
    }),
  },
  mounted() {
    this.form.name = this.user.name;
    this.form.email = this.user.email;
    this.form.theme_dark = this.user.theme_dark;
  },
  methods: {
    ...mapActions({
      updateProfile: 'auth/profile',
      popToast: 'toast/popToast',
    }),
    async update() {
      this.loading = true;
      this.errors = null;
      this.success = '';
      try {
        await this.updateProfile(this.form).then((response) => {
          if (
            response &&
            response.data &&
            response.data.user &&
            response.data.user.id
          ) {
            this.popToast({
              message: 'Profile Updated Successfully',
              timer: 2000,
              icon: 'success',
            });
          }
        });
      } catch (e) {
        this.errors = e.data;
        this.popToast({
          message: 'Error Updating Profile',
          timer: 5000,
          icon: 'error',
        });
      }
      this.loading = false;
    },
    moment() {
      return moment();
    },
  },
};
</script>

<style scoped>
:deep() .text-white {
  color: #ffffff !important;
}
</style>
