<template>
  <div>
    <v-row class="pt-6 pb-6 pl-2">
      <v-btn
      class="mx-2"
      fab
      dark
      small
      color="primary"
      @click="dialog = true"
    >
      <v-icon dark>
        mdi-plus
      </v-icon>
    </v-btn>
      <v-btn
      class="mx-2"
      fab
      dark
      small
      color="green"
    >
      <v-icon dark>
        mdi-check
      </v-icon>
    </v-btn>
      <v-btn
      class="mx-2"
      fab
      dark
      small
      color="pink"
    >
      <v-icon dark>
        mdi-close
      </v-icon>
    </v-btn>

    </v-row>
    <v-row colos="12">
      <v-data-table
      dense
      class="elevation-1"
        :headers="headers"
        :items="prices"
        item-key="name"
        show-select
      >
      </v-data-table>
    </v-row>

  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-form ref="priceForm" v-model="valid" lazy-validation>
        <v-card-title>
          <span class="headline">Add price</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="formPrice.price"
                  label="Price*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
              >
                                     
              <v-autocomplete
                v-model="formPrice.currency"
                :items="currencys"
                label="Currency"
                required
                :rules="[rules.required]"
                item-text="currency"
                return-object
              >
              </v-autocomplete>

              </v-col>
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="validate"
            :disabled="!valid"
          >
            Save
          </v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
    
  </div>
</template>
<script>
  export default {
    props: {
        codMealId: null
    },
    data () {
      return {
        valid: true,
        rules: {
          required: value => !!value || "Required.",
        },
        formPrice:{
          price:null,
          currency:null

        },
        currencys:[],
        dialog:false,
        selected: [],
        prices: [],
        headers: [
          {
            text: 'Country',
            align: 'start',
            //sortable: false,
            value: 'price_currency.entity',
          },
          { text: 'Currency', value: 'price_currency.currency' },
          { text: 'Creator Name', value: 'users.name' },
          { text: 'Creator Last Name', value: 'users.lastName' },
          { text: 'Amount', value: 'amount' },
          { text: 'Created_at', value: 'created_at' },
          { text: 'Updated_at', value: 'updated_at' },
        ],
      }
    },
    watch: {
    codMealId: {
      handler (val) {
        //console.log('watch', val);
        axios
            .get('getThisMealPrices/'+this.codMealId)
            .then(response => (this.prices = response.data));
      },
      deep: true,
      immediate: true
    },

    },
    methods:{
    validate() {
      if (this.$refs.priceForm.validate()) {
        // submit form to server/API here...
        //console.log(this.formReg);
        this.sendData(this.formPrice);
        this.dialog = false;
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },  
    sendData(data) {
      axios
      .post("meal/price/new", { data: { priceData: data} })
      .then(response => {
          this.allerros = [];
          this.sucess = true;
          if (response.data.errors) {
              //console.log(response.data.errors);
              response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
              
          } else {
              
              this.openNotification('success', 'Save', 'You have been store all data successfully');
              this.$router.push({ name: 'register/result' });
          }
      })
      .catch((error) => {
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

    },
    mounted() {
    axios
        .get('getCurrencyArr')
        .then(response => (this.currencys = response.data));
      }
  }
</script>