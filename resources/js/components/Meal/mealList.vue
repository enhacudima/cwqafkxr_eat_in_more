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
            sm="4"
            md="4"
            lg="4"
            xl="4"
        >
            <v-card
                class="pa-2"            
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
                <v-card-title v-text="meal.name"></v-card-title>
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

                <v-card-actions>
                    <v-spacer></v-spacer>              
                    <v-btn 
                        icon
                        @click.stop="modfShowDialog(meal.id)"
                    >
                        <v-icon
                        >mdi-pencil</v-icon>
                    </v-btn>
                    <v-btn
                        icon
                        @click="postUserId = meal.id; show = !show"
                    >
                        <v-icon>{{ show && postUserId == meal.id ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                    </v-btn>
                </v-card-actions>
                <v-expand-transition>
                <div v-show="show && postUserId == meal.id ">
                    <v-divider></v-divider>

                    <v-card-text>
                    {{meal.alias}}.
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
  import dialogView from './dialog.vue';
export default {
    components: { dialogView },
    data() {
        return {
            showDialog: false,
            mealIDShow: null,
            columuns:4,
            showNew:false,
            isSearch:true,
            isLoadingSearch: false,
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
                window.axios.get('/getPagmMals?page=' + this.pagination.current)
                    .then(response => {
                        this.meals = response.data.data;
                        this.isSearch = true;
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
            axios.get('/getPagmMalsSearch/'+val)
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