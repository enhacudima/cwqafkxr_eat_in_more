<template>
  <div class="text-center">
    <v-dialog
      v-model="showDialogCart"
      width="500"
    >

      <v-card>
        <v-card-title class="headline grey lighten-2">
          <div v-if="existeKitchen">Booking Confirmation</div>
          <div v-else>Kitchen</div>
        </v-card-title>
        <v-card-text  class="px-4 pt-6" v-if="waiting">
            <v-row

                class="fill-height"
                align-content="center"
                justify="center"
            >
                <v-col
                class="subtitle-1 text-center"
                cols="12"
                >
                Getting read..
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
        </v-card-text>

        <v-card-text class="px-4 pt-6" v-else-if="existeKitchen">

            <v-form ref="bookingForm" v-model="valid" lazy-validation>
                <v-row>
                    <v-col cols="12" sm="12" md="12">
                        <v-dialog
                            ref="dialog"
                            v-model="modal"
                            :return-value.sync="date"
                            persistent
                            width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-model="date"
                                label="Picker date"
                                prepend-icon="mdi-calendar"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                required
                            ></v-text-field>
                            </template>
                            <v-date-picker
                            v-model="bookingForm.date"
                            scrollable
                            >
                            <v-spacer></v-spacer>
                            <v-btn
                                text
                                color="primary"
                                @click="modal = false"
                            >
                                Cancel
                            </v-btn>
                            <v-btn
                                text
                                color="primary"
                                @click="$refs.dialog.save(date)"
                            >
                                OK
                            </v-btn>
                            </v-date-picker>
                        </v-dialog>
                    </v-col>

                    <v-col cols="12" sm="12" md="12">
                        <v-dialog
                            ref="dialog"
                            v-model="modal2"
                            :return-value.sync="time"
                            persistent
                            width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-model="time"
                                label="Picker time"
                                prepend-icon="mdi-clock-outline"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                required
                            ></v-text-field>
                            </template>
                            <v-time-picker
                            v-if="modal2"
                            v-model="bookingForm.time"
                            full-width
                            >
                            <v-spacer></v-spacer>
                            <v-btn
                                text
                                color="primary"
                                @click="modal2 = false"
                            >
                                Cancel
                            </v-btn>
                            <v-btn
                                text
                                color="primary"
                                @click="$refs.dialog.save(time)"
                            >
                                OK
                            </v-btn>
                            </v-time-picker>
                        </v-dialog>
                    </v-col>

                    <v-col cols="12" sm="12" md="12">
                        <v-autocomplete
                        prepend-icon="mdi-map-marker-outline"
                        v-model="bookingForm.kitchen_id"
                        :items="kitchen"
                        label="Kitchen"
                        required
                        item-text="aliase"
                        item-value="id"
                        dense
                        >
                        </v-autocomplete>
                    </v-col>

                    <v-col cols="12">
                        <v-checkbox dense v-model="bookingForm.terms_conditions" :rules="[rules.required]">
                        <template v-slot:label>
                            <div>
                            {{$t('i_have_read_and_agree')}}
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                <a
                                    target="_blank"
                                    href="/terms"
                                    @click.stop
                                    v-on="on"
                                >
                                    {{$t('terms_service')}}
                                </a>
                                </template>
                                {{$t('open_terms_and_conditions')}}
                            </v-tooltip>
                            </div>
                        </template>
                        </v-checkbox>
                    </v-col>
                </v-row>

                <v-spacer></v-spacer>
                <v-col class="d-flex" cols="12" sm="12" xsm="12" align-end>
                    <v-btn elevation="1" block :disabled="!valid" color="primary" @click="validate">Confirm Booking</v-btn>
                </v-col>

            </v-form>
        </v-card-text>

        <v-card-text class="px-4 pt-6" v-else>
            <newkitchen  v-bind:existeKitchen.sync="existeKitchen" />
        </v-card-text>


        <v-divider></v-divider>

        <v-card-actions>
          <v-btn
            color="primary"
            text
            @click="existeKitchen= !existeKitchen"
          >

            <div v-if="existeKitchen">
                <v-icon small>mdi-plus</v-icon>
                Kitchen
            </div>
            <div v-else>
                Cancel
            </div>

          </v-btn>

          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="showDialogCart = false"
          >
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import newkitchen from './kitchen.vue';
  export default {

    components:{newkitchen},
    props: {
        value: Boolean,
    },
    data () {
      return {
        bookingForm:[
            {kitchen_id:null},
            {data:null},
            {time:null},
            {bookingData:null},
            {terms_conditions:true}
        ],
        waiting:true,
        existeKitchen:false,
        kitchen:[],
        valid: true,
        modal:false,
        date: new Date().toISOString().substr(0, 10),
        time: null,
        modal2: false,
        rules: {
            required: value => !!value || "Required.",
        },
      }
    },
    methods:{

        getData(){
            var cache = localStorage.getItem("cart");
            var existing = cache ? JSON.parse(cache) : {};
            this.bookingForm.bookingData=existing;
        },
        getkitchen(){
            var userID = JSON.parse(localStorage.getItem('user')).logged_in_user.id ;
            axios
                .get('getKitchen/'+userID)
                .then(response => {
                    this.kitchen = response.data;
                    this.waiting =false;
                    if(this.kitchen.length){
                        this.existeKitchen = true
                    }else{
                        this.existeKitchen = false
                    }
                });

        }

    },
    watch:{
        showDialogCart(val){
            if(val)
                this.getData();
                this.getkitchen()

        },
        existeKitchen(val){
            if(val===true)
                this.getkitchen()

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
  }
</script>
