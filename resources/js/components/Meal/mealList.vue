<template>
<div>
    <v-row >
        <v-col cols="12">
            <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
            class="pl-10 pr-10"
            :loading = "isLoadingSearch"
            ></v-text-field>
        </v-col>

    </v-row>

    <v-container fluid>
    <v-responsive
        class="overflow-y-auto spacing-playground pa-6"
        max-height="650"
    >
      <v-row
         v-if="!meals.length"
      >
          <v-col
            cols="12"
          >
            <v-alert
            border="right"
            colored-border
            type="error"
            elevation="2"
            icon="mdi-cloud-off-outline"
            >
            Sorry, nothing to display here :(
            </v-alert>
          </v-col>
      </v-row>
      <v-row dense>
        <v-col
            v-for="(meal, index) in meals"
            :key="index"
            xs="12"
            sm="3"
            md="3"
            lg="3"
            xl="3"
        >
       <v-card
            class="mx-auto"
            max-width="344"
            v-if="index>=0"
        >
            <v-img
            v-if="meal.file"
            :src="'storage/'+meal.file"
            :lazy-src="'storage/'+meal.file"
            aspect-ratio="1"
            class="white--text align-end"
            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
            height="200px"
            >
            <template v-slot:placeholder>
            <v-row
                class="fill-height ma-0"
                align="center"
                justify="center"
            >
                <v-progress-circular
                indeterminate
                color="grey lighten-5"
                ></v-progress-circular>
            </v-row>
            </template>
            </v-img>

            <v-card-subtitle>
            <div class="overline mb-1">
            <strong>{{meal.meal_name && meal.meal_name.length < 20 ? meal.meal_name : meal.meal_name.substring(0,20)+".." }}</strong>
            </div>
                <div> <v-list-item-action-text >{{meal.meal_alias && meal.meal_alias.length < 38 ? meal.meal_alias : meal.meal_alias.substring(0,38)+".." }}</v-list-item-action-text> </div>
                <v-row
                    align="center"
                    class="mx-0 pt-2"
                >
                    <v-rating
                    :value="4.5"
                    color="amber"
                    dense
                    half-increments
                    readonly
                    size="14"
                    ></v-rating>

                    <div class="grey--text ml-4">
                    4.5 (413)
                    </div>
                </v-row>
                <div class="my-2 subtitle-1">
                   <v-list-item-action-text > $ • {{meal.amount}} {{meal.currency && meal.currency.length < 20 ? meal.currency : meal.currency.substring(0,20)+".." }}, {{meal.alphabetic_code}} </v-list-item-action-text>
                </div>

                <div class="my-2 subtitle-1">
                    <v-chip
                    label
                    small
                    class="ma-2"
                    color="indigo"
                    text-color="white"
                    >
                    <v-avatar left>
                        <v-icon small>mdi-account-multiple</v-icon>
                    </v-avatar>
                    {{meal.meal_people}}
                    </v-chip>
                </div>

            </v-card-subtitle>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    small
                    icon
                    @click.stop="modfShowDialogAdd(meal.meal_id,meal.meal_people,meal.meal_name)"
                >
                    <v-icon
                    small
                    >mdi-cart</v-icon>
                </v-btn>
                <v-btn
                    small
                    icon
                    @click.stop="modfShowDialog(meal.meal_id)"
                >
                    <v-icon
                    small
                    >mdi-pencil</v-icon>
                </v-btn>

            <v-btn
                icon
                @click="postUserId = meal.meal_id; show = !show"
            >
                <v-icon>{{ show && postUserId == meal.meal_id ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
            </v-btn>
            </v-card-actions>

            <v-expand-transition>
            <div v-show="show && postUserId == meal.meal_id">
                <v-divider></v-divider>

                <v-card-text dense>
                        <div>
                            <div class="font-weight-normal">
                            <strong>{{$t('cusine')}}</strong>
                            </div>
                            <div>{{meal.cuisine}}</div>
                        </div>
                        <div>
                            <div class="font-weight-normal">
                            <strong>{{$t('type')}}</strong>
                            </div>
                            <div>{{meal.meal_type}}</div>
                        </div>
                        <div>
                            <div class="font-weight-normal">
                            <strong>{{$t('common_timing')}}</strong>
                            </div>
                            <div>{{meal.common_timing}}</div>
                        </div>


                    <v-list-item-action-text>{{meal.meal_details}}</v-list-item-action-text>
                </v-card-text>
                <v-divider class="mx-4"></v-divider>

                <v-card-text>
                <strong>{{$t('allergies')}}</strong>
                <v-chip-group
                    active-class="deep-purple accent-4 white--text"
                    column
                    small
                >
                    <v-chip
                    color="indigo"
                    small
                    label
                    text-color="white"
                    v-for="(allergies, index) in meal.meal_allergies"
                    :key="index"
                    >
                     {{allergies.allergies_ingredients.name}}
                    </v-chip>
                </v-chip-group>
                </v-card-text>

                <v-card-text>
                <strong>Tags</strong>
                <v-chip-group
                    active-class="deep-purple accent-4 white--text"
                    column
                    small
                >


                    <v-chip
                    class="ma-2"
                    color="pink"
                    small
                    label
                    text-color="white"
                    v-for="(allergies, index) in meal.meal_tags"
                    :key="index"
                    >
                    <v-icon left>
                        mdi-label
                    </v-icon>
                    {{allergies.tag_name.name}}
                    </v-chip>
                </v-chip-group>
                </v-card-text>

            </div>
            </v-expand-transition>
        </v-card>
        </v-col>

      </v-row>

    <!--dialog-->
    <dialogView v-model="showDialog" v-bind:codMeal="mealIDShow"/>
     <dialogStoreAdd v-model="showDialogStoreAdd" v-bind:codMeal="[mealIDShow,mealPeoShow,mealName]"/>


    </v-responsive>
        <v-pagination
            class="pt=6"
            v-model="pagination.current"
            :length="pagination.total"
            @input="onPageChange"
            v-show="isSearch"
        ></v-pagination>
    </v-container>

    <v-navigation-drawer
      app
      clipped
      right
      dense
    >

      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title">
            Filters
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    <v-divider></v-divider>
      <v-list dense>
            <v-list-item-group
                color="primary"
            >

                <v-list-item
                >
                    <v-list-item-content>
                        <v-list-item-title>
                            <v-autocomplete
                                v-model="currency_x"
                                :items="currencys"
                                label="Currency"
                                required
                                :rules="[]"
                                item-text="entity"
                                item-value="id"

                            >
                                <template v-slot:selection="{ item }">
                                    <v-list-item-action-text >{{item.entity && item.entity.length < 38 ? item.entity : item.entity.substring(0,38)+".." }}</v-list-item-action-text>
                                </template>
                            </v-autocomplete>
                        </v-list-item-title>
                        <v-list-item-action-text >By selecting different currency, we are only deliver services to the country are you selected.</v-list-item-action-text>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
      </v-list>
      <v-divider class="mx-4"></v-divider>
            <v-row  dense justify="center" align="center">
                <v-btn
                v-for="icon in icons"
                :key="icon"
                class="mx-1"
                icon
                >
                <v-icon size="24px">
                    {{ icon }}
                </v-icon>
                </v-btn>
            </v-row>
    </v-navigation-drawer>
</div>
</template>
<script>
  import dialogView from './dialog.vue';
  import dialogStoreAdd from './dialogStoreAdd.vue';
export default {
    components: { dialogView,dialogStoreAdd },
    data() {
        return {
            currency_x:null,
            currencys:[],
            icons: [
                'mdi-facebook',
                'mdi-twitter',
                'mdi-linkedin',
                'mdi-instagram',
            ],
            showDialog: false,
            showDialogStoreAdd: false,
            mealIDShow: null,
            columuns:4,
            showNew:false,
            isSearch:true,
            isLoadingSearch: true,
            search: null,
            show:false,
            mealPeoShow:0,
            postUserId: null,
            meals: [],
            mealName:null,
            pagination: {
                current: 1,
                total: 0
            }
        }
    },
    methods: {
        updateCurrency(){
            axios.get('/setCurrency/'+this.currency_x)
            .then(response => (this.getMeals()))
        },
        modfShowDialog(mealId){
            this.showDialog=true;
            this.mealIDShow=mealId;
            //console.log(this.mealIDShow);
        },
        modfShowDialogAdd(mealId,mealPeo,mealName){
            this.showDialogStoreAdd=true;
            this.mealIDShow=mealId;
            this.mealPeoShow=mealPeo;
            this.mealName=mealName;
            //console.log(this.mealIDShow);
        },
        getMeals() {
                window.axios.get('/getPagmMals?page=' + this.pagination.current)
                    .then(response => {
                        this.meals = response.data.data;
                        this.isSearch = false;
                        this.isLoadingSearch = false;
                        this.pagination.current = response.data.current_page;
                        this.pagination.total = response.data.last_page;
                    });
            },
            onPageChange() {
                this.getMeals();
            }
        },
    mounted() {
        this.getMeals();
        axios
            .get('getCurrencyArr')
            .then(response => (this.currencys = response.data));

    },
    changeShow: function(idx) {
      this.list[idx].show = !this.list[idx].show;
    },

    watch: {
        search (val){
            //console.log(val.length);
            if (val.length == 0) return this.getMeals();
            this.isLoadingSearch = true;
            axios.get('/getPagmMalsSearch/'+val)
                .then(response => {
                    this.meals = response.data.data;
                    this.isSearch = false;
                    this.pagination.current = response.data.current_page;
                    this.pagination.total = response.data.last_page;
                    this.isLoadingSearch = false;
                })
                .catch((error) => {
                    this.meals = null;
                    this.isSearch = true;
                    this.isLoadingSearch = false;
                });



        },
        currency_x(val){
            this.updateCurrency()
            this.isSearch = true;
            this.isLoadingSearch = true;
        }
    }
}
</script>



