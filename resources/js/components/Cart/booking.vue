<template>
  <div class="text-center">
    <v-dialog
      v-model="showDialogCart"
      width="500"
    >

      <v-card>
        <v-card-title class="headline grey lighten-2">
          Booking Details
        </v-card-title>

        <v-card-text class="px-4 pt-6">

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
                        v-model="bookingForm.kitchen"
                        :items="kitchen"
                        label="Kitchen"
                        required
                        item-text="name"
                        return-object
                        dense
                        >
                        </v-autocomplete>
                    </v-col>
                </v-row>

                <v-spacer></v-spacer>
                <v-col class="d-flex" cols="12" sm="12" xsm="12" align-end>
                    <v-btn elevation="1" block :disabled="!valid" color="primary" @click="validate">Confirm Booking</v-btn>
                </v-col>

            </v-form>
         </v-card-text>


        <v-divider></v-divider>

        <v-card-actions>
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
  export default {
    props: {
        value: Boolean,
    },
    data () {
      return {
        bookingForm:[
            {kitchen_id:null},
            {data:null},
            {time:null},
            {bookingData:null}
        ],
        kitchen:[],
        valid: true,
        modal:false,
        date: new Date().toISOString().substr(0, 10),
        time: null,
        modal2: false,
      }
    },
    methods:{

        getData(){
            var cache = localStorage.getItem("cart");
            var existing = cache ? JSON.parse(cache) : {};
            this.bookingForm.bookingData=existing;
        },

    },
    watch:{
        showDialogCart(val){
            if(val)
                this.getData()

        },

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
