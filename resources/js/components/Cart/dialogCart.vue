<template>
  <v-row justify="center">
    <v-dialog
      v-model="showDialogCart"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
    >
      <v-card>
        <v-toolbar
          dark
          background-color="indigo"
          fixed-tabs
        >
             <v-icon>mdi-cart-outline</v-icon>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn
              dark
              text
              @click="showDialogCart = false"
            >
            <v-icon>mdi-close</v-icon>
              Close
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
            <v-progress-linear
            :active="dialogW"
            height="3"
            indeterminate
            color="primary"
            ></v-progress-linear>

        <v-card-title>
        </v-card-title>
        <v-card-text>
          <v-container>
                <v-row
                justify="center"
                align="center"
                v-if="items"
                >
                    <v-col
                    xs="12"
                    sm="12"
                    md="12"
                    lg="12"
                    xl="12"
                    >
                    <v-list three-line dense >
                        <template v-for="(item, index) in items">
                          <v-list-item
                            :key="item.meal_name"
                            v-if="item"
                          >
                            <v-list-item-avatar rounded>
                              <v-img :src="'storage/'+item.file"></v-img>
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title  class=" blue--text text--darken-4" v-html="item.meal_name"></v-list-item-title>
                                <v-list-item-subtitle v-html="item.meal_alias"></v-list-item-subtitle>
                                <v-list-item-subtitle v-html="item.meal_details"></v-list-item-subtitle>

                                <v-list-item-title class="pt-2 orange--text text--darken-2"> ${{numberFormat(item.amount)}}, {{item.currency}}/portion</v-list-item-title>
                                <v-list-item-title ><v-icon small>mdi-noodles</v-icon> {{item.quantity_to_book}}</v-list-item-title>
                                <v-list-item-subtitle > <v-icon small>mdi-account-multiple</v-icon> {{item.quantity_to_book * item.meal_people}}</v-list-item-subtitle>
                                <v-list-item-subtitle ><v-icon small>mdi-clock</v-icon> ~{{item.quantity_to_book * item.time_min}} min/portion</v-list-item-subtitle>
                                <v-list-item-title  class="red--text text--darken-2" ><v-icon small>mdi-currency-usd</v-icon> {{numberFormat(item.quantity_to_book*item.amount)}}</v-list-item-title>

                                <v-list-item-title class="pt-2" v-if="item.chef_to_cook">
                                    <v-chip
                                        pill
                                        small
                                    >
                                        <v-avatar left>
                                        <v-img :src="'storage/'+item.chef_to_cook.avatar" :lazy-src="'storage/'+item.chef_to_cook.avatar"></v-img>
                                        </v-avatar>
                                        <strong>Chef</strong> - {{item.chef_to_cook.name}} {{item.chef_to_cook.lastName}}
                                    </v-chip>
                                </v-list-item-title>
                                <v-list-item-subtitle v-else   class="pt-2 orange--text text--lighten-4"> <strong>Note:</strong> We did not find any chef available for the next 24 hours, but you can proceed with booking.</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-action>
                            <v-btn icon>
                                <v-icon color="grey lighten-1"
                                    @click="remove(item.meal_id)"
                                >
                                    mdi-close-circle
                                </v-icon>
                            </v-btn>
                            </v-list-item-action>

                          </v-list-item>
                            <v-divider
                            :key="index"
                          ></v-divider>
                        </template>
                        <template v-if="items.length">
                            <v-list three-line dense >
                                <v-subheader>Summary</v-subheader>
                                <v-list-item
                                >
                                    <v-list-item-content>
                                        <v-list-item-title ><v-icon small>mdi-noodles</v-icon> {{allData.numMeals}}</v-list-item-title>
                                        <v-list-item-title ><v-icon small>mdi-clock</v-icon> ~{{allData.totalTime}} min</v-list-item-title>
                                        <v-list-item-title  class="red--text text--darken-2" ><v-icon small>mdi-currency-usd</v-icon> {{numberFormat(allData.totalPrice)}}</v-list-item-title>
                                    </v-list-item-content>

                                </v-list-item>
                            </v-list>

                            <v-btn
                            depressed
                            small
                            color="primary"
                            @click="dialogBooking=true"
                            >

                            <v-icon left>
                                mdi-calendar-plus
                            </v-icon>
                            Book
                            </v-btn>

                        </template>
                        <template v-if="!items.length" >
                                <v-row
                                justify="center"
                                align="center"
                                >
                                    <v-col cols="2">

                                        <v-img src="storage/icons/cart_blank.png" lazy-src="storage/icons/cart_blank.png"
                                        aspect-ratio="1.4"
                                        contain
                                        ></v-img>
                                    </v-col>
                                </v-row>
                                <v-col cols="12"
                                    justify="center"
                                    align="center"
                                    >
                                        <div class="title">
                                            Cart is Blank
                                        </div>
                                    </v-col>
                                <v-col cols="12"
                                    justify="center"
                                    align="center"
                                    >
                                        <div class="subheading" >
                                            Sorry, Your cart is blank, close it and try to add any meal.
                                        </div>
                                </v-col>
                        </template>
                    </v-list>

                    </v-col>


                </v-row>
                <v-row
                    v-else
                    class="fill-height"
                    align-content="center"
                    justify="center"
                >
                    <v-col
                    class="subtitle-1 text-center"
                    cols="12"
                    >
                    Getting your list
                    </v-col>
                    <v-col cols="6">
                    <v-progress-linear
                        color="deep-purple accent-4"
                        indeterminate
                        rounded
                        height="6"
                    ></v-progress-linear>
                    </v-col>
                </v-row>

          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <booking v-model="dialogBooking" v-bind:dialogBooking="dialogBooking"/>
  </v-row>
</template>

<script>

import numeral from 'numeral';
import booking from './booking.vue';

  export default {
    components: {booking },
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
         dialogBooking:false,
         dialogW:false,
         items: null,
         userID:null,
         cacheData:[],
         allData:null,

        }
    },

    computed: {
        showDialogCart: {
        get () {
            return this.value
        },
        set (value) {
            this.$emit('input', value)
        }
        },
    },
    methods: {
        numberFormat(value){
            return numeral(value).format('0,0')
        },
        remove(meal_id){
            var cache = localStorage.getItem("cart");
            if(cache){
                var projects = JSON.parse(cache)
                this.changeDesc(projects, meal_id)

                var existing = cache;
                existing = existing ? projects : {};
                this.cacheData=existing;
                localStorage.setItem('cart', JSON.stringify(existing));
                this.getNames()
            }
        },
        changeDesc(projects, meal_id ) {
            for (var i in projects) {
                if (projects[i].meal_id == meal_id && projects[i].user == this.userID) {
                  //console.log(projects[i])
                  delete projects[i]
                  break; //Stop this loop, we found it!
                }
            }
        },
        getData(){
            var cache = localStorage.getItem("cart");
            var existing = cache ? JSON.parse(cache) : {};
            this.cacheData=existing;
        },
        getNames(){
            this.dialogW=true
            this.getData();
                axios
                .post("cart/get", { data: { cart: this.cacheData,} })
                .then(response => { this.items = response.data.data,this.allData = response.data, this.dialogW=false
                })
                .catch((error) => {
                });
        },

    },
    mounted() {
        const userData = JSON.parse(localStorage.getItem('user'));
        this.userID = userData.logged_in_user.id;


    },
    watch: {
        showDialogCart(val){
            if(val)
                this.getNames()

        },
        codMeal (val, oldVal) {
        //console.log(val)
        }
    }

  }
</script>
