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
            :to="{ name: 'admin.participants' }"
            class="text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400"
          >
            <span
              :class="[
                isActive &&
                  'cursor-default text-gray-800 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-500',
              ]"
            >
              Participants
            </span>
          </router-link>
        </li>
      </ol>
    </nav>
    <div class="mb-1 sm:mb-0 ml-20">
      <h1 class="text-2xl md:text-3xl text-slate-800 font-bold float-left">
        Participants ✨
      </h1>
    </div>

    <div
      class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2"
    >
      <form class="relative">
        <label for="action-search" class="sr-only">Search</label>
        <input
          id="action-search"
          v-model="search"
          class="form-input pl-4 focus:border-slate-300 w-[250px]"
          type="search"
          placeholder="Search Mobile Number or City"
        />
      </form>

      <div class="relative inline-flex w-[250px]">
        <button
          ref="trigger"
          class="btn w-full justify-between min-w-44 bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600"
          aria-label="Select date range"
          aria-haspopup="true"
          :aria-expanded="dropdownOpen"
          @click.prevent="dropdownOpen = !dropdownOpen"
        >
          <span class="flex items-center">
            <span>{{ selectedCity.name }}</span>
          </span>
          <svg
            class="shrink-0 ml-1 fill-current text-slate-400"
            width="11"
            height="7"
            viewBox="0 0 11 7"
          >
            <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
          </svg>
        </button>

        <transition
          enter-active-class="transition ease-out duration-100 transform"
          enter-from-class="opacity-0 -translate-y-2"
          enter-to-class="opacity-100 translate-y-0"
          leave-active-class="transition ease-out duration-100"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <div
            v-show="dropdownOpen"
            class="z-10 absolute top-full left-0 w-full bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
          >
            <div
              ref="dropdown"
              class="font-medium text-sm text-slate-600 divide-y divide-slate-200"
              @focusin="dropdownOpen = true"
              @focusout="dropdownOpen = false"
            >
              <button
                v-for="city in cities"
                :key="city.id"
                class="flex items-center justify-between w-full hover:bg-slate-50 py-2 px-3 cursor-pointer"
                :class="city.id === selected && 'text-indigo-500'"
                :value="city.description"
                @click="
                  selected = city.id;
                  selectedCity = city;
                  dropdownOpen = false;
                  searchCity();
                "
              >
                <span>{{ city.name }} </span>
                <svg
                  class="shrink-0 ml-2 fill-current text-indigo-400"
                  :class="city.id !== selected && 'invisible'"
                  width="12"
                  height="9"
                  viewBox="0 0 12 9"
                >
                  <path
                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z"
                  />
                </svg>
              </button>
            </div>
          </div>
        </transition>
      </div>
      <div class="relative inline-flex w-[100px]">
        <button
          class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white hover:text-white rounded transition duration-200"
          @click="clearSearch"
        >
          Clear
        </button>
      </div>
    </div>

    <ParticipantsTable
      :participants="participants"
      :pagination="pagination"
      :total="total"
      @fetchParticipants="handleFetchParticipants"
      @pageChange="handlePageChange"
    />
  </div>
</template>

<script>
import { mapActions, mapGetters, mapState } from 'vuex';
import axios from 'axios';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
import { ref, onMounted, onUnmounted } from 'vue';
import ParticipantsTable from '../../../components/admin/ParticipantsTable.vue';

// import lity from 'lity';
// import LoadingForm from '~admin/components/LoadingForm'
// import pagination from '~admin/components/PaginationComponent'

export default {
  name: 'Admin',
  components: {
    ChevronRightIcon,
    // LoadingForm,
    // pagination,
    ParticipantsTable,
  },
  layout: 'admin',
  middleware: 'check-auth',
  metaInfo() {
    return { title: 'Admin' };
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

  setup() {
    const dropdownOpen = ref(false);
    const trigger = ref(null);
    const dropdown = ref(null);
    const selected = ref(0);

    // close on click outside
    const clickHandler = ({ target }) => {
      if (
        !dropdownOpen.value ||
        dropdown.value.contains(target) ||
        trigger.value.contains(target)
      )
        return;
      dropdownOpen.value = false;
    };

    // close if the esc key is pressed
    const keyHandler = ({ keyCode }) => {
      if (!dropdownOpen.value || keyCode !== 27) return;
      dropdownOpen.value = false;
    };

    onMounted(() => {
      document.addEventListener('click', clickHandler);
      document.addEventListener('keydown', keyHandler);
    });

    onUnmounted(() => {
      document.removeEventListener('click', clickHandler);
      document.removeEventListener('keydown', keyHandler);
    });

    return {
      dropdownOpen,
      trigger,
      dropdown,
      selected,
      // options,
    };
  },

  data() {
    return {
      // title: window.config.appName,
      participants: [],
      perPage: 25,
      participantsNew: [],
      isLoading: true,
      search: '',
      errors: {},
      cities: [],
      selectedGift: '',
      notfound: null,
      winners: '1',
      gifts: [],
      toggle: 0,
      currentSort: 'name',
      currentSortDir: 'asc',
      pagination: {
        current_page: 1,
      },
      pageSize: 8,
      currentPage: 1,
      lastPage: '',
      selectedCity: '',
      total: '',
    };
  },
  watch: {
    search: function () {
      const _this = this;
      this.isLoading = true;
      axios
        .post('/api/admin/participants?search=' + this.search)
        .then((result) => {
          this.isLoading = false;
          if (result.data.data.data.length == 0 && this.search !== '') {
            _this.winners = null;
            _this.notfound = '1';
          } else {
            _this.notfound = null;
          }
          if (result.data.data.data > 0) {
            _this.winners = null;
          }
          this.total = result.data.data.total;
          this.participants = result.data.data.data;
          this.pagination = result.data.pagination;
        })
        .catch((error) => {
          this.isLoading = false;
        });
      this.currentPage = 1;
    },
  },
  created() {
    if (this.$route.query.page) {
      this.pagination.current_page = this.$route.query.page;
    }
  },
  mounted() {
    this.fetchParticipants();
    this.getCities();
  },

  methods: {
    ...mapActions({
      popToast: 'toast/popToast',
    }),
    removeNumber(id) {
      this.isLoading = true;
      $('#removeParticipant' + id).modal('hide');
      axios
        .post('/admin_api/admin/participant/remove/' + id)
        .then((response) => {
          this.isLoading = false;
          this.$toast.error('Participant removed');
          this.fetchParticipants();
        })
        .catch((error) => {
          this.isLoading = false;
          this.$toast.error('Something went wrong! Please try again later.');
        });
    },
    removeLeaflet(id) {
      this.isLoading = true;
      $('#removeLeaflet' + id).modal('hide');
      axios
        .post('/admin_api/admin/participant/leaflet/remove/' + id)
        .then((response) => {
          this.isLoading = false;
          this.$toast.error('Leaflet removed');
          this.fetchParticipants();
        })
        .catch((error) => {
          this.isLoading = false;
          this.$toast.error('Something went wrong! Please try again later.');
        });
    },
    acceptWinner(id) {
      this.isLoading = true;
      axios
        .post('/admin_api/admin/selectwinner/' + id)
        .then((response) => {
          this.isLoading = false;
          this.$toast.success('Winner selected');
          this.fetchParticipants();
          this.notfound = null;
          setTimeout(this.$scrollTo('.main-content'), 1000);
        })
        .catch((error) => {
          this.isLoading = false;
          this.$toast.error('Something went wrong! Please try again later.');
        });
    },
    favWinner(id, toggle) {
      this.isLoading = true;
      toggle = toggle == 1 ? (toggle = 0) : (toggle = 1);
      axios
        .post('/admin_api/admin/winnerslist/fav/' + id + /toggle/ + toggle)
        .then((response) => {
          this.isLoading = false;
          this.$toast.success('Winner toggled successfully');
          this.fetchParticipants();
        })
        .catch((error) => {
          this.isLoading = false;
          this.$toast.error('Something went wrong! Please try again later.');
        });
    },
    getCities() {
      // this.isLoading = true;
      axios
        .get('/api/admin/locations')
        .then((response) => {
          // this.isLoading = false;

          // var removeValFrom = [8, 15, 16, 17, 18, 19];
          // response.data = response.data.filter(function(value, index) {
          //      return removeValFrom.indexOf(index) == -1;
          // })

          this.cities = response.data;
        })
        .catch((error) => {
          this.isLoading = false;
          this.$toast.error('Something went wrong! Please try again later.');
        });
    },
    searchCity() {
      // alert(this.selectedCity.name);
      this.search = this.selectedCity.name;
      // if(this.selectedCity == 'dammam'){
      // 	this.search = "dhahran" + "," + "dammam";
      // }
      // if(this.selectedCity == 'riyadh'){
      // 	this.search = "dwadme" + "," + "riyadh";
      // }
      // if(this.selectedCity == 'jeddah'){
      // 	this.search = "rabegh" + "," + "jeddah";
      // }
      // if(this.selectedCity == 'abha'){
      // 	this.search = "khamis" + "," + "abha";
      // }
    },
    clearSearch() {
      this.selectedCity = '';
      this.search = '';
    },

    handleFetchParticipants() {
      this.fetchParticipants();
    },

    handlePageChange(page) {
      this.pagination.current_page = page;
      this.fetchParticipants();
    },
    fetchParticipants() {
      // alert('here');
      const _this = this;
      // this.isLoading = true;

      if (this.search !== '') {
        axios
          .post(
            '/api/admin/participants?page=' +
              this.pagination.current_page +
              '&search=' +
              this.search,
          )
          .then((result) => {
            // this.isLoading = false;
            if (result.data.data.data.length == 0 && this.search !== '') {
              _this.winners = null;
              _this.notfound = '1';
            } else {
              _this.notfound = null;
            }
            if (result.data.data.data > 0) {
              _this.winners = null;
            }
            this.participants = result.data.data.data;
            this.total = result.data.data.total;
            this.pagination = result.data.pagination;
          })
          .catch((error) => {
            // this.isLoading = false;
          });
      } else {
        axios
          .post('/api/admin/participants?page=' + this.pagination.current_page)
          .then((result) => {
            // this.isLoading = false;
            if (result.data.data.data.length == 0) {
              _this.winners = '1';
            } else {
              _this.winners = null;
            }
            this.total = result.data.data.total;
            this.participants = result.data.data.data;
            this.pagination = result.data.pagination;
          })
          .catch((error) => {
            _this.winners = '1';
            // this.isLoading = false;
          });
      }
    },
    nextPage: function () {
      if (this.currentPage * this.pageSize < this.participantsNew.length)
        this.currentPage++;
    },
    prevPage: function () {
      if (this.currentPage > 1) this.currentPage--;
    },
  },
};
</script>
