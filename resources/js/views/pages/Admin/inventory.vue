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
            :to="{ name: 'view.inventory' }"
            class="text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400"
          >
            <span
              :class="[
                isActive &&
                  'cursor-default text-gray-800 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-500',
              ]"
            >
              Inventory
            </span>
          </router-link>
        </li>
      </ol>
    </nav>
    <div class="mb-1 sm:mb-0 ml-20">
      <h1 class="text-2xl md:text-3xl text-slate-800 font-bold float-left">
        Inventory ✨
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
          placeholder="Search a gift by name"
        />
      </form>
    </div>

    <InventoryTable
      :gifts="gifts"
      :pagination="pagination"
      :total="pagination.total"
      :columns="columns"
      @update-inventory="updateInventory"
      @pageChange="handlePageChange"
    />
  </div>
</template>
<script>
import { mapGetters } from 'vuex';
import axios from 'axios';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
import InventoryTable from '@/components/admin/InventoryTable.vue';

// import lity from 'lity'
// import LoadingForm from '~admin/components/LoadingForm'
// import pagination from '~admin/components/PaginationComponent'

export default {
  name: 'Inventory',

  components: {
    // LoadingForm,
    // pagination,
    ChevronRightIcon,
    InventoryTable,
  },
  metaInfo() {
    return { title: 'Admin' };
  },
  filters: {
    toCapitalize(text) {
      return text.charAt(0).toUpperCase() + text.slice(1);
    },
  },
  data() {
    return {
      // title: window.config.appName,
      participants: [],
      participantsNew: [],
      isLoading: true,
      search: '',
      selected_gift: [],
      errors: {},

      selectedGift: '',
      notfound: null,
      // inventory: '1',
      gifts: [],
      giftsTest: [],
      toggle: 0,

      currentSort: 'name',
      currentSortDir: 'asc',
      pagination: {
        current_page: 1,
      },
      pageSize: 150,
      currentPage: 1,
      lastPage: '',
      locations: [],
      selectedLocation: 'all',
      columns: ['name'],
      inventory: [],
    };
  },
  computed: {
    ...mapGetters({
      authenticated: 'auth/authenticated',
      user: 'auth/user',
      roles: 'auth/roles',
      logins: 'auth/logins',
    }),
  },
  watch: {
    search: function () {
      const _this = this;
      this.isLoading = true;
      axios
        .post('/api/admin/inventory?search=' + this.search)
        .then((result) => {
          this.isLoading = false;
          if (result.data.data.data.length == 0 && this.search !== '') {
            _this.inventory = null;
            _this.notfound = '1';
          } else {
            _this.notfound = null;
          }
          if (result.data.data.gifts > 0) {
            _this.inventory = null;
          }
          this.gifts = result.data.data.data.map((r) => {
            const { allocation, ...otherProps } = r;
            return {
              ...otherProps,
              isEditable: false,
              ...Object.fromEntries(
                allocation.map((a) => [`location${a.location_id}`, a.qty]),
              ),
            };
          });
          this.pagination = result.data.pagination;
        })
        .catch((error) => {
          this.isLoading = false;
        });
      this.currentPage = 1;
    },
  },

  async mounted() {
    await this.getGifts();
    await this.getLocations();
  },
  created() {
    if (this.$route.query.page) {
      this.pagination.current_page = this.$route.query.page;
    }
  },

  methods: {
    getLocations() {
      const _this = this;
      this.isLoading = true;
      axios
        .get('/api/admin/locations')
        .then((result) => {
          this.locations = result.data.map((location) => ({
            isEditable: false,
            ...location,
          }));
          this.locations.forEach((value, index) => {
            this.columns.push(value.description);
          });

          /*
                this.gifts = this.gifts.reduce(
                  (acc, gift) => {
                      const locArr = (gift.allocation).reduce(
                          (acc, loc) => {
                            acc[`location${loc.location_id}`] = loc.qty
                            return acc;
                          }, []
                      )
                      delete gift.allocation;
                    let mergeArr = {...gift, ...locArr}
                    return acc.concat(mergeArr)
                   }, [])
        */

          this.gifts = this.gifts.map((r) => {
            const { allocation, ...otherProps } = r;
            return {
              ...otherProps,
              isEditable: false,
              ...Object.fromEntries(
                allocation.map((a) => [`location${a.location_id}`, a.qty]),
              ),
            };
          });

          const fruit = [];
          for (
            let i = 0, len = Math.max(this.locations.length, this.gifts.length);
            i < len;
            i++
          ) {
            fruit.push({
              locations: this.locations[i],
              gifts: this.gifts[i],
            });
          }

          /*
            const res = this.gifts.reduce(
              (acc, gift) => {
                  const locArr = (gift.allocation).reduce(
                      (acc, loc) => {
                        acc[`location${loc.location_id}`] = loc.qty
                        return acc;
                      }, []
                  )
                  delete gift.allocation;
                let mergeArr = {...gift, ...locArr}
                return acc.concat(mergeArr)
               }, [])
        */
        })
        .catch((error) => {
          this.isLoading = false;
        });
    },
    searchCity() {
      this.search = this.selectedGift;
    },
    clearSearch() {
      this.selectedGift = '';
      this.search = '';
    },
    getGifts() {
      const _this = this;
      this.isLoading = true;

      if (this.search !== '') {
        axios
          .post(
            '/api/admin/inventory?page=' +
              this.pagination.current_page +
              '&search=' +
              this.search,
          )
          .then((result) => {
            this.isLoading = false;
            if (result.data.data.data.length == 0 && this.search !== '') {
              _this.inventory = null;
              _this.notfound = '1';
            } else {
              _this.notfound = null;
            }
            if (result.data.data.data > 0) {
              _this.inventory = null;
            }
            this.gifts = result.data.data.data.map((r) => {
              const { allocation, ...otherProps } = r;
              return {
                ...otherProps,
                isEditable: false,
                ...Object.fromEntries(
                  allocation.map((a) => [`location${a.location_id}`, a.qty]),
                ),
              };
            });
            this.pagination = result.data.pagination;
          })
          .catch((error) => {
            this.isLoading = false;
          });
      } else {
        axios
          .post('/api/admin/inventory?page=' + this.pagination.current_page)
          .then((result) => {
            this.isLoading = false;
            if (result.data.data.data.length == 0) {
              _this.inventory = '1';
            } else {
              _this.inventory = null;
            }
            console.log('test', result.data.data.data);
            this.gifts = result.data.data.data.map((r) => {
              const { allocation, ...otherProps } = r;
              return {
                ...otherProps,
                isEditable: false,
                ...Object.fromEntries(
                  allocation.map((a) => [`location${a.location_id}`, a.qty]),
                ),
              };
            });
            this.pagination = result.data.pagination;
          })
          .catch((error) => {
            _this.inventory = '1';
            this.isLoading = false;
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

    handlePageChange(page) {
      this.pagination.current_page = page;
      this.getGifts();
    },

    updateInventory(gift) {
      console.log(gift);
      axios
        .post('/api/admin/inventory/update', { inventory: gift })
        .then((response) => {})
        .catch((error) => {
          this.isLoading = false;
        });
    },
    editItem(index) {
      this.gifts[index].isEditable = !this.gifts[index].isEditable;
      if (this.gifts[index].isEditable == false) {
        this.updateInventory(this.gifts[index]);

        /*
              const gifts = this.gifts[index].map(r => {
                const { location, ...otherProps } = r
                return {
                  ...otherProps,
                  ...Object.fromEntries(
                    location.map(a => [`location${a.location_id}`, a.qty])
                  )
                }
              });
              console.log(gifts);
        */
      }
    },
  },
};
</script>
