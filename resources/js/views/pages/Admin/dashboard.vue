<template>
  <div class="flex h-screen overflow-hidden">
    <div
      class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden"
    >
      <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
          <!-- Left: Title -->
          <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
              Participants ✨
            </h1>
          </div>
        </div>

        <div class="grid grid-cols-12 gap-6">
          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                TOTAL PARTICIPATIONS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                UNIQUE MOBILE NUMBERS
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ total }}
                </div>
              </div>
            </div>
            <!-- Chart built with Chart.js 3 -->
            <!--    <div class="grow">-->
            <!--      &lt;!&ndash; Change the height attribute to adjust the chart height &ndash;&gt;-->
            <!--      <LineChart :data="chartData" width="389" height="128" />-->
            <!--    </div>-->
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                PARTICIPATIONS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                TODAY
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ registered_today }}
                </div>
              </div>
            </div>
            <!-- Chart built with Chart.js 3 -->
            <!--    <div class="grow">-->
            <!--      &lt;!&ndash; Change the height attribute to adjust the chart height &ndash;&gt;-->
            <!--      <LineChart :data="chartData" width="389" height="128" />-->
            <!--    </div>-->
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                PARTICIPATIONS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                YESTERDAY
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ registered_yesterday }}
                </div>
              </div>
            </div>
          </div>
          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-5">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                PARTICIPANTS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                LANGUAGE
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  Er
                  <!--                  <p-->
                  <!--                    v-for="(language, index) in byLanguage"-->
                  <!--                    v-if="index !== ''"-->
                  <!--                    class="mt-1 mb-0 text-muted text-sm d-inline-block"-->
                  <!--                  >-->
                  <!--                    <span v-if="index == 'en'" class="text-success mr-2"-->
                  <!--                      >En</span-->
                  <!--                    >-->
                  <!--                    <span v-if="index == 'ar'" class="text-success mr-2"-->
                  <!--                      >Ar</span-->
                  <!--                    >-->
                  <!--                    <span class="text-nowrap mr-4">{{ language }}</span>-->
                  <!--                  </p>-->
                </div>
              </div>
            </div>
            <!-- Chart built with Chart.js 3 -->
            <!--    <div class="grow">-->
            <!--      &lt;!&ndash; Change the height attribute to adjust the chart height &ndash;&gt;-->
            <!--      <LineChart :data="chartData" width="389" height="128" />-->
            <!--    </div>-->
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                TRU STORES
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                PARTICIPANTS WITH LOCATION
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ going_tru }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                OLD STATUS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                BETWEEN 15 AUG TO 31 AUG
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ old_status }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                PARTICIPATIONS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                TRU CITIES
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ tru_cities }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                PARTICIPATIONS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                NON TRU CITIES
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ non_tru_cities }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                PARTICIPATIONS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                WITHOUT CITIES
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ no_city }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                PARTICIPATIONS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                BANNED
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ banned }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="sm:flex sm:justify-between sm:items-center mb-8 mt-4">
          <!-- Left: Title -->
          <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
              LEAFLETS ✨
            </h1>
          </div>
        </div>

        <div class="grid grid-cols-12 gap-6">
          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                LEAFLETS CONSUMED
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                TOTAL
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ leaflets_consumed }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                LEAFLETS PENDING
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                TOTAL
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ leaflets_pending }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                LEAFLETS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                CONSUMED + PENDING
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ leaflets_pending + leaflets_consumed }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                LEAFLETS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                WITH INSTANT GIFT
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ leaflets_instant }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                LEAFLETS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                WITHOUT INSTANT GIFT
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ leaflets_without_instant }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="sm:flex sm:justify-between sm:items-center mb-8 mt-4">
          <!-- Left: Title -->
          <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
              INVENTORY ✨
            </h1>
          </div>
        </div>

        <div class="grid grid-cols-12 gap-6">
          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                RAFFLE'S DONE
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                TOTAL
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ online_raffle }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                RAFFLE'S PENDING
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                TOTAL
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ online_raffle_pending }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                RAFFLE'S
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                DONE + PENDING
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ online_raffle + online_raffle_pending }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                TOYSRUS GIFTS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                TOTAL INVENTORY
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ total_gifts }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                TOYSRUS GIFTS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                CONSUMED
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ consumed_gifts }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                TOYSRUS GIFTS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                REMAINING
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ remaining_gifts }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                TOYSRUS GIFTS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                REMAINING %
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ percentage_gifts }}%
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                STG 7 DAYS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                TOTAL INVENTORY
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ total_stg_7 }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                STG 7 DAYS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                REMAINING
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ remaining_stg_7 }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                STG 7 DAYS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                REMAINING %
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ percentage_stg_7 }}%
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                STG 1 MONTH
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                TOTAL INVENTORY
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ total_stg_1 }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                STG 1 MONTH
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                REMAINING
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ remaining_stg_1 }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                STG 1 MONTH
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                REMAINING %
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ percentage_stg_1 }}%
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                STG 6 MONTHS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                TOTAL INVENTORY
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ total_stg_6 }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                STG 6 MONTHS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                REMAINING
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ remaining_stg_6 }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                STG 6 MONTHS
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                REMAINING %
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ percentage_stg_6 }}%
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="sm:flex sm:justify-between sm:items-center mb-8 mt-4">
          <!-- Left: Title -->
          <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
              MODERATION ✨
            </h1>
          </div>
        </div>
        <div class="grid grid-cols-12 gap-6">
          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                MODERATION
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                OLD PARTICIPATIONS
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ old_participants }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                MODERATION
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                PENDING
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ pending }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                MODERATION
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                Approved
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ approved }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200"
          >
            <div class="px-5 pt-2 mb-2">
              <header class="flex justify-between items-start mb-2"></header>
              <h2 class="text-lg font-semibold text-slate-800 mb-2">
                MODERATION
              </h2>
              <div class="text-xs font-semibold text-slate-400 uppercase mb-1">
                Rejected
              </div>
              <div class="flex items-start">
                <div class="text-3xl font-bold text-slate-800 mr-2">
                  {{ rejected }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!--        <div class="grid grid-cols-8 gap-6 mt-4">-->
        <!--          <div-->
        <!--            class="flex flex-col col-span-full sm:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200"-->
        <!--          >-->
        <!--            <header-->
        <!--              class="px-5 py-4 border-b border-slate-100 flex items-center"-->
        <!--            >-->
        <!--              <h2 class="font-semibold text-slate-800">Daily Participants</h2>-->
        <!--            </header>-->
        <!--            &lt;!&ndash; Chart built with Chart.js 3 &ndash;&gt;-->
        <!--            &lt;!&ndash; Change the height attribute to adjust the chart height &ndash;&gt;-->
        <!--            <LineChart-->
        <!--              v-if="chartData.labels.length > 0"-->
        <!--              :data="chartData"-->
        <!--              width="595"-->
        <!--              height="248"-->
        <!--            />-->
        <!--          </div>-->
        <!--        </div>-->
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex';
import axios from 'axios';
import { ref } from 'vue';
import LineChart from '../charts/LineChart.vue';
// Import utilities
import { tailwindConfig } from '../utils/Utils';

import { Chart } from 'chart.js';
import { black } from '@tailwindcss/postcss7-compat/colors';
// import LoadingForm from '~admin/components/LoadingForm';
// import DownloadCsv from '~admin/components/DownloadCsv';

export default {
  name: 'AdminDashboard',

  components: {
    // LoadingForm,
    // DownloadCsv,
    LineChart,
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
    const chartData = ref({
      labels: [],
      datasets: [],
    });

    return {
      chartData,
    };
  },

  data() {
    return {
      // title: window.config.appName,
      isLoading: true,
      total: null,
      registered_today: null,
      registered_yesterday: null,
      leaflets_pending: null,
      leaflets_consumed: null,
      leaflets_instant: null,
      leaflets_without_instant: null,
      total_gifts: null,
      consumed_gifts: null,
      remaining_gifts: null,
      percentage_gifts: null,
      going_tru: null,
      total_stg_7: null,
      remaining_stg_7: null,
      percentage_stg_7: null,
      total_stg_1: null,
      remaining_stg_1: null,
      percentage_stg_1: null,
      total_stg_6: null,
      remaining_stg_6: null,
      percentage_stg_6: null,
      online_raffle: null,
      online_raffle_pending: null,
      old_status: null,
      tru_cities: null,
      non_tru_cities: null,
      no_city: null,
      old_participants: null,
      banned: null,
      pending: null,
      approved: null,
      rejected: null,
      byCity: [],
      byAge: [],
      byLanguage: [],
      json_data: [],
    };
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
            //
            // console.log(
            //   'date',
            //   response.data.daily_participations.map((x) => x['created_at']),
            // );
            //
            // console.log(
            //   'participants',
            //   response.data.daily_participations.map((x) => x['participants']),
            // );

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
              // Add more datasets if needed
            ];

            self.isLoading = false;
            self.total = response.data.total;
            self.registered_today = response.data.registered_today;
            self.registered_yesterday = response.data.registered_yesterday;

            self.leaflets_pending = response.data.leaflets_pending;
            self.leaflets_consumed = response.data.leaflets_consumed;
            self.leaflets_instant = response.data.leaflets_instant;
            self.leaflets_without_instant =
              response.data.leaflets_without_instant;

            self.total_gifts = response.data.total_gifts;
            self.consumed_gifts = response.data.consumed_gifts;
            self.remaining_gifts = self.total_gifts - self.consumed_gifts;
            self.percentage_gifts = Math.round(
              (self.remaining_gifts / self.total_gifts) * 100,
            );

            self.total_stg_7 = response.data.total_stg_7;
            self.remaining_stg_7 = response.data.remaining_stg_7;
            self.percentage_stg_7 = Math.round(
              (self.remaining_stg_7 / self.total_stg_7) * 100,
            );

            self.total_stg_1 = response.data.total_stg_1;
            self.remaining_stg_1 = response.data.remaining_stg_1;
            self.percentage_stg_1 = Math.round(
              (self.remaining_stg_1 / self.total_stg_1) * 100,
            );

            self.total_stg_6 = response.data.total_stg_6;
            self.remaining_stg_6 = response.data.remaining_stg_6;
            self.percentage_stg_6 = Math.round(
              (self.remaining_stg_6 / self.total_stg_6) * 100,
            );

            self.online_raffle = response.data.online_raffle;
            self.online_raffle_pending = response.data.online_raffle_pending;

            self.going_tru = response.data.going_tru;

            self.old_status = response.data.oldstatus;

            self.tru_cities = response.data.tru_cities;
            self.non_tru_cities = response.data.non_tru_cities;
            self.no_city = response.data.no_city;

            self.byCity = response.data.city;
            self.byAge = response.data.age;

            self.old_participants = response.data.old_participants;
            self.banned = response.data.banned;
            self.pending = response.data.pending;
            self.approved = response.data.approved;
            self.rejected = response.data.rejected;

            self.byLanguage = response.data.language;
          })
          .catch((error) => {});
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
  },
};
</script>
