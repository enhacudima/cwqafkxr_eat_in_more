<template>
  <v-row justify="center">
    <v-dialog
      v-model="showDialogStoreAdd"
      max-width="400px"
    >
      <v-card>
        <v-card-title v-if="mealName"> {{mealName && mealName.length < 15 ? mealName : mealName.substring(0,15)+".." }} Portion ({{portion}} People)</v-card-title>
        <v-divider></v-divider>
        <v-card-text style="">
            <v-row
                class="text-center"
            >
                <v-col
                cols="4"
                ></v-col>
                <v-col
                cols="4"

                >
                    <v-text-field
                    dense
                        v-model="bpm"
                        type="number"
                        class="centered-input display-1 font-weight-light "
                    >
                    </v-text-field>
                </v-col>
                <v-col
                cols="4"
                ></v-col>

            </v-row>


            <v-slider
                v-model="bpm"
                :color="color"
                track-color="grey"
                always-dirty
                min="1"
                max="50"
            >
                <template v-slot:prepend>
                <v-icon
                    :color="color"
                    @click="decrement"
                >
                    mdi-minus
                </v-icon>
                </template>

                <template v-slot:append>
                <v-icon
                    :color="color"
                    @click="increment"
                >
                    mdi-plus
                </v-icon>
                </template>
            </v-slider>


        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn
            color="blue darken-1"
            text
            @click="showDialogStoreAdd = false"
          >
            Close
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn
            dark
            color="warning"
            @click="add()"
          >
            <v-icon
                left
                >mdi-cart-plus
            </v-icon>

            Add to Cart
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-snackbar
      v-model="snackbar"
      :multi-line="multiLine"
      :timeout="timeout"
      color="info"
    >
      {{ text }}
    </v-snackbar>
  </v-row>

</template>

<script>
  export default {

    props: {
        value: Boolean,
        codMeal: {
            type:Array
        },
    },
    created () {
        //console.log(this.codMeal)
    },
    data() {
        return {
        loader: null,
        loading: false,
        snackbar: false,
        text: 'Add to cart!',
        timeout: 1000,
        multiLine: false,
        counter: 0,
        updated:false,
        bpm: 1,
        interval: null,
        isPlaying: true,
        portion:1,
        multpl:1,
        mealName:'',
        mealID:null,
        userID:null,
        }
    },

    computed: {
        showDialogStoreAdd: {
        get () {
            return this.value
        },
        set (value) {
            this.$emit('input', value)
        }
        },
        color () {
            if (this.bpm < 3) return 'indigo'
            if (this.bpm < 6) return 'teal'
            if (this.bpm < 12) return 'green'
            if (this.bpm < 24) return 'orange'
            return 'red'
        },
        animationDuration () {
            return `${20 / this.bpm}s`
        },
    },
    methods: {
        add(){
            this.snackbar=true
           this.showDialogStoreAdd = false
          //get from localy store
          //localStorage.removeItem('cart')
          var cache = localStorage.getItem("cart");
          if(cache){
              var projects = JSON.parse(cache)
              this.changeDesc(projects, this.mealID,this.bpm)
          }
          // new val
          var newVal ={
            meal_id:this.mealID,
            quantity:this.bpm,
            user:this.userID,
          }
          // Get the existing data
          var existing = cache;
          var index = 0;
          // If no existing data, create an array
          // Otherwise, convert the localStorage string to an array
          existing = existing ? projects : {};
          index = projects ? Object.keys(existing).length: 0;

          if(!this.updated){
            // Add new data to localStorage Array
            existing[index] = newVal;
          }

          // Save back to localStorage
          localStorage.setItem('cart', JSON.stringify(existing));
          //existing = localStorage.getItem('cart');
          //console.log(JSON.parse(existing))

  /*          this.$ls.set('counter', JSON.stringify(existing))

            this.counter = this.$ls.get('counter', 0);
            var _this = this;
            this.$ls.on('counter', function(val) {
             _this.counter = val;
            });
    */
            //console.log(_this.counter);





        },
        changeDesc(projects, meal_id, quantity ) {
            for (var i in projects) {
                if (projects[i].meal_id == meal_id && projects[i].user == this.userID) {
                  projects[i].quantity = quantity,
                  this.updated=true
                  break; //Stop this loop, we found it!
                }
                this.updated=false
            }
        },

      decrement () {
        this.bpm --
      },
      increment () {
        this.bpm ++
      },
      toggle () {
        this.isPlaying = !this.isPlaying
      },
    },
    mounted() {
        const userData = JSON.parse(localStorage.getItem('user'));
        this.userID = userData.logged_in_user.id;

    },
    watch: {
        loader () {
            const l = this.loader
            this[l] = !this[l]

            setTimeout(() => (this[l] = false), 3000)

            this.loader = null
        },
        codMeal (val, oldVal) {
            this.mealID=val[0];
            this.bpm=1;
            this.multpl=val[1];
            this.portion=this.bpm*this.multpl;
            this.mealName=val[2];
        //console.log(val[2])
        },
        bpm(val,oldVal){
            this.portion = this.bpm*this.multpl
        }
    }

  }
</script>

<style>
  @keyframes metronome-example {
    from {
      transform: scale(.5);
    }

    to {
      transform: scale(1);
    }
  }

  .v-avatar--metronome {
    animation-name: metronome-example;
    animation-iteration-count: infinite;
    animation-direction: alternate;
  }
  .v-input input {
    max-height: 50px;
  }
</style>
<style scoped>
    .centered-input >>> input {
      text-align: center
    }
</style>
