<template>
<div>
    <v-row >
        <v-col cols="12">
            <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            :label="$t('search')"
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
        >
            <v-img
            v-if="meal.meal_file"
            :src="'storage/'+meal.meal_file.path+meal.meal_file.name"
            :lazy-src="'storage/'+meal.meal_file.path+meal.meal_file.name"
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
            <strong>{{meal.name && meal.name.length < 20 ? meal.name : meal.name.substring(0,20)+".." }}</strong>
            </div>
                <div> <v-list-item-action-text >{{meal.alias && meal.alias.length < 38 ? meal.alias : meal.alias.substring(0,38)+".." }}</v-list-item-action-text> </div>
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
                    <v-chip
                    label
                    small
                    class="ma-2"
                    color="indigo"
                    outlined
                    >
                    <v-avatar left>
                        <v-icon small>mdi-account-multiple</v-icon>
                    </v-avatar>
                    {{meal.people}}
                    </v-chip>
                </div>

            </v-card-subtitle>



            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    small
                    outlined
                    color="warning"
                    @click.stop="modfShowDialog(meal.id)"
                >
                    <v-icon
                    small
                    >mdi-cart-plus</v-icon>
                </v-btn>

            <v-btn
                icon
                @click="postUserId = meal.id; show = !show"
            >
                <v-icon>{{ show && postUserId == meal.id ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
            </v-btn>
            </v-card-actions>

            <v-expand-transition>
            <div v-show="show && postUserId == meal.id">
                <v-divider></v-divider>

                <v-card-text dense>
                        <div>
                            <div class="font-weight-normal">
                            <strong>{{$t('cusine')}}</strong>
                            </div>
                            <div>{{meal.meal_cuisine.name}}</div>
                        </div>
                        <div>
                            <div class="font-weight-normal">
                            <strong>{{$t('type')}}</strong>
                            </div>
                            <div>{{meal.meal_type.meal_type}}</div>
                        </div>
                        <div>
                            <div class="font-weight-normal">
                            <strong>{{$t('common_timing')}}</strong>
                            </div>
                            <div>{{meal.mealtiming.common_timing}}</div>
                        </div>


                    <v-list-item-action-text>{{meal.details}}</v-list-item-action-text>
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


    </v-responsive>
        <v-pagination
            v-model="pagination.current"
            :length="pagination.total"
            @input="onPageChange"
            v-show="isSearch"
        ></v-pagination>

    </v-container>
</div>
</template>
<script>
  import dialogView from './dialogCart.vue';
export default {
    components: { dialogView },
    data() {
        return {
            showDialog: false,
            mealIDShow: null,
            columuns:4,
            showNew:false,
            isSearch:true,
            isLoadingSearch: true,
            search: null,
            show:false,
            postUserId: null,
            meals: [],
            pagination: {
                current: 1,
                total: 0
            }
        }
    },
    methods: {
        modfShowDialog(mealId){
            this.showDialog=true;
            this.mealIDShow=mealId;
            //console.log(this.mealIDShow);
        },
        getMeals() {
                window.axios.get('/getPagmMalsW?page=' + this.pagination.current)
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
    },
    changeShow: function(idx) {
      this.list[idx].show = !this.list[idx].show;
    },

    watch: {
        search (val){
            //console.log(val.length);
            if (val.length == 0) return this.getMeals();
            this.isLoadingSearch = true;
            axios.get('/getPagmMalsSearchW/'+val)
                .then(response => {
                    this.meals = response.data;
                    this.isSearch = false;
                    this.isLoadingSearch = false;
                })
                .catch((error) => {
                    this.meals = null;
                    this.isSearch = true;
                    this.isLoadingSearch = false;
                });



        }
    }
}
</script>
