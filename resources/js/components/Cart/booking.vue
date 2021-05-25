<template>
  <div class="text-center">
    <v-dialog
      v-model="showDialogCart"
      width="500"
    >

      <v-card>
        <v-card-title class="headline grey lighten-2">
          <div v-if="existeKitchen">Booking </div>
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

            <v-form ref="formBooking" v-model="valid" lazy-validation>
                <v-row>

                    <v-col
                        cols="12"
                        sm="6"
                        md="6"
                        >
                       <v-menu
                                ref="menu"
                                v-model="menu"
                                :close-on-content-click="false"
                                :return-value.sync="date"
                                transition="scale-transition"
                                offset-y
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="date"
                                    label="Picker a date"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                ></v-text-field>
                                </template>
                                <v-date-picker
                                v-model="date"
                                no-title
                                scrollable
                                >
                                <v-spacer></v-spacer>
                                <v-btn
                                    text
                                    color="primary"
                                    @click="menu = false"
                                >
                                    Cancel
                                </v-btn>
                                <v-btn
                                    text
                                    color="primary"
                                    @click="$refs.menu.save(date)"
                                >
                                    OK
                                </v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>

                    <v-col cols="12" sm="6" md="6">
                        <v-menu
                            ref="menu2"
                            v-model="menu2"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            :return-value.sync="time"
                            transition="scale-transition"
                            offset-y
                            max-width="290px"
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-model="time"
                                required
                                :rules="[rules.required]"
                                label="Picker a time"
                                prepend-icon="mdi-clock-time-four-outline"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                            ></v-text-field>
                            </template>
                            <v-time-picker
                            v-if="menu2"
                            v-model="time"
                            full-width
                            @click:minute="$refs.menu2.save(time)"
                            ></v-time-picker>
                        </v-menu>
                    </v-col>

                    <v-col cols="12" sm="12" md="12">
                        <v-autocomplete
                        prepend-icon="mdi-map-marker-outline"
                        v-model="bookingForm.kitchen_id"
                        :items="kitchen"
                        label="Kitchen"
                        required
                        :rules="[rules.required]"
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
                    <v-btn elevation="1" block :loading="loading" :disabled="!valid || loading" color="primary" @click="validate">Continue Booking</v-btn>
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

    <v-snackbar
      v-model="snackbar"
      :vertical="vertical"
      :multi-line="multiLine"
       color="info"
    >
      {{ text }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="red"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
import newkitchen from './kitchen.vue';
  export default {

    components:{newkitchen},
    props: {
        value: Boolean,
        showDialogCartProp:Boolean,
    },
    data () {
      return {
        multiLine: true,
        snackbar: false,
        text: null,
        loading: false,
        menu: false,
        menu2: false,
        date: new Date().toISOString().substr(0, 10),
        bookingForm:{
            kitchen_id:null,
            cook_start_date:null,
            Cook_start_time:null,
            bookingData:null,
            terms_conditions:true,
        },
        waiting:true,
        existeKitchen:false,
        kitchen:[],
        valid: true,
        modal:false,
        time: null,
        modal2: false,
        rules: {
            required: value => !!value || "Required.",
        },
      }
    },
    methods:{
    reset() {
      this.$refs.formBooking.reset();
    },
    resetValidation() {
      this.$refs.formBooking.resetValidation();
    },

    validate() {
      if (this.$refs.formBooking.validate()) {
          this.bookingForm.cook_start_date=this.date;
          this.bookingForm.Cook_start_time=this.time;
        // submit form to server/API here...
        //console.log(this.formReg);

        this.loading = true
        this.sendData(this.bookingForm);
      }
    },
    sendData(data) {

      axios
      .post("createBooking", { data: { bookingData: data} })
      .then(response => {
          this.allerros = [];
          this.sucess = true;
          this.loading = false
          if (response.data.errors) {
              //console.log(response.data.errors);
              response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});

          } else {
            this.text="Congratulations, you just booked a chef on the "+this.date+', You can see it on your Dashboard.'
            this.snackbar=true
            localStorage.removeItem('cart');
            this.$emit('update:showDialogCartProp', false)
            this.reset()
            this.resetValidation()
            this.showDialogCart=false;

          }
      })
      .catch((error) => {
        this.loading = false
        this.success = false;
        var errors =null;
        var status=error.response.status;
        //console.log(status);
            if (status == 422){
            errors=error.response.data.errors;
            //console.log(errors);
            errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
          }else{
            this.openNotification('error','Error on Save',error);
          }
      });
    },

  openNotification: function (type, m, d) {
      this.$notification.config({
          placement: 'topRight',
          top: 35,
          duration: 8,
      });
      this.$notification[type]({
        message: m,
        description: d,
      });
  },

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
