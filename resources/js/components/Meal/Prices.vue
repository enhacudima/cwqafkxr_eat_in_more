<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left">
            Country
          </th>
          <th class="text-left">
            Currency
          </th>
          <th class="text-left">
            Create by
          </th>
          <th class="text-left">
            People
          </th>
          <th class="text-left">
            Amount
          </th>
          <th class="text-left">
            Created_at
          </th>
          <th class="text-left">
            Updated_at
          </th>
          <th class="text-left">
            Actions
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in prices"
          :key="item.id"
        >
          <td>{{ item.price_currency.entity }}</td>
          <td>{{ item.price_currency.currency }}</td>
          <td>{{ item.users.name }} {{ item.users.lastName }}</td>
          <td>{{ item.people}}</td>
          <td>{{ item.amount}}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>
<script>
  export default {
    props: {
        codMealId: Number
    },
    data () {
      return {
        prices: [],
      }
    },
    mounted() {
    axios
        .get('getThisMealPrices/'+this.codMealId)
        .then(response => (this.prices = response.data));
      }
  }
</script>