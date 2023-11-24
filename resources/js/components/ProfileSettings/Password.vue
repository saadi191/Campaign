<template>
  <div class="grow">
    <!-- Panel body -->
    <div class="card p-4 m-4 shadow-black">
      <div class="p-6 space-y-6">
        <!-- Business Profile -->
        <section>
          <h3 class="text-xl leading-snug text-slate-800 font-bold mb-1">
            Change Password
          </h3>

          <Success v-if="success" :content="success" @close="success = null" />
          <Errors v-if="errors" :content="errors" @close="errors = null" />
          <form @submit.prevent="update">
            <div
              class="sm:flex sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-5"
            >
              <div class="sm:w-1/3">
                <label class="block text-sm font-medium mb-1" for="name"
                  >Password</label
                >
                <input
                  id="name"
                  v-model="form.password"
                  class="form-input w-full"
                  :type="showPassword ? 'text' : 'password'"
                  name="password"
                  autocomplete="on"
                />
                <!--                <span-->
                <!--                  class="fa fa-fw ml-3"-->
                <!--                  :class="showPassword ? 'fa-eye' : 'fa-eye-slash'"-->
                <!--                  style="width: 1.45em"-->
                <!--                  @click="showPassword = !showPassword"-->
                <!--                />-->
              </div>
              <div class="sm:w-1/3">
                <label class="block text-sm font-medium mb-1" for="business-id">
                  Confirm password</label
                >
                <input
                  v-model="form.password_confirmation"
                  class="form-input w-full"
                  :type="showConfirmPassword ? 'text' : 'password'"
                  name="password_confirmation"
                />
                <!--                <span-->
                <!--                  class="fa fa-fw ml-3"-->
                <!--                  style="width: 1.45em"-->
                <!--                  :class="showConfirmPassword ? 'fa-eye' : 'fa-eye-slash'"-->
                <!--                  @click="showConfirmPassword = !showConfirmPassword"-->
                <!--                />-->
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
    </div>
    <!-- Panel footer -->
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Errors from '@components/Errors.vue';
import Success from '@components/Success.vue';
import CircleSvg from '@components/CircleSvg.vue';

export default {
  components: {
    Errors,
    Success,
    CircleSvg,
  },
  data() {
    return {
      form: {
        password: '',
        password_confirmation: '',
      },
      errors: null,
      success: '',
      loading: false,

      showPassword: false,
      showConfirmPassword: false,
    };
  },
  computed: {
    submitEnabled() {
      if (
        this.form.password &&
        this.form.password_confirmation &&
        this.form.password.length > 5 &&
        this.form.password == this.form.password_confirmation
      ) {
        return true;
      }
      return false;
    },
  },
  methods: {
    ...mapActions({
      updatePassword: 'auth/password',
      popToast: 'toast/popToast',
    }),
    async update() {
      this.loading = true;
      this.errors = null;
      this.success = '';
      try {
        await this.updatePassword(this.form).then((response) => {
          if (response && response == 'Success') {
            this.form.password = '';
            this.form.password_confirmation = '';
            this.popToast({
              message: 'Password Updated Successfully',
              timer: 2000,
              icon: 'success',
            });
          }
        });
      } catch (e) {
        this.errors = e.data;
        let msg = 'Error Updating Password';
        if (e && e.response && e.response.data && e.response.data.message) {
          msg = e.response.data.message;
        }
        this.popToast({
          message: msg,
          timer: 5000,
          icon: 'error',
        });
      }
      this.loading = false;
    },
  },
};
</script>
