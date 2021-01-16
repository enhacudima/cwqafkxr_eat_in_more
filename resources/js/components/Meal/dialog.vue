<template>
  <v-row justify="center">
    <v-dialog
      v-model="showDialog"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title>
          <span class="headline">Update Meal</span>
        </v-card-title>
        <v-card-text>
          <v-container>
              <mealEdit v-bind:codMealId="codMeal"/>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="showDialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="showDialog = false"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  import mealEdit from './MealEdit.vue';
  export default {
    components: { mealEdit},
    props: {
        value: Boolean,
        codMeal: {
            type:Number
        },
    },
    created () {
        //console.log(this.codMeal)
    },
    data() {
        return {
           
        }
    },
 
    computed: {
        showDialog: {
        get () {
            return this.value
        },
        set (value) {
            this.$emit('input', value)
        }
        },
    },
    mounted() {
        
    }
  }
</script>