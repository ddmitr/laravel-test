<template>
  <div class="container">
    <div
      class="flex flex-row bg-white rounded justify-content-center p-10 border border-gray-300"
    >
      <div>
        <table class="table-auto">
          <thead>
            <tr class="bg-gray-100">
              <th class="border px-4 py-2">Team</th>
              <th class="border px-4 py-2">Played</th>
              <th class="border px-4 py-2">Won</th>
              <th class="border px-4 py-2">Drawn</th>
              <th class="border px-4 py-2">Lost</th>
              <th class="border px-4 py-2">Points</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, index) in table" :key="index">
              <td class="border px-4 py-2">{{ row.team }}</td>
              <td class="border px-4 py-2">{{ row.played }}</td>
              <td class="border px-4 py-2">{{ row.won }}</td>
              <td class="border px-4 py-2">{{ row.drawn }}</td>
              <td class="border px-4 py-2">{{ row.lost }}</td>
              <td class="border px-4 py-2">{{ row.points }}</td>
            </tr>
          </tbody>
        </table>
        <div class="week-nav pt-2">
          <button
            @click="loadTable(true)"
            class="float-right bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
          >
            Next week
          </button>
        </div>
      </div>
      <div class="px-2">
        <table class="table-auto">
          <thead>
            <tr class="bg-gray-100">
              <th class="border px-4 py-2" colspan="3">
                {{ matchweek }}th week match result
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, index) in matches" :key="index">
              <td class="border px-4 py-2">{{ row.home_team }}</td>
              <td class="border px-2 py-2 score">
                {{ row.goals_home }}-{{ row.goals_away }}
              </td>
              <td class="border px-4 py-2">{{ row.away_team }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="px-2" v-if="matchweek > 3">
        <table class="table-auto">
          <thead>
            <tr class="bg-gray-100">
              <th class="border px-4 py-2" colspan="2">
                {{ matchweek }}th week predictions of championschip
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border px-4 py-2 w-10/12">Chelsea</td>
              <td class="border px-4 py-2">90%</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      matchweek: 1,
      matches: [],
      table: [],
      predictions: []
    }
  },
  mounted() {
    console.log('Component mounted.')
    this.loadTable()
  },
  methods: {
    loadTable(loadNext = false) {
      if (loadNext) {
        this.matchweek += 1
      }
      axios
        .get('/api/matches', { params: { matchweek: this.matchweek } })
        .then(({ data }) => {
          console.log(data)
          this.table = data.table
          this.matches = data.matches
          this.predictions = data.predictions
        })
    }
  }
}
</script>
