<template>
  <v-row justify="center">
    <v-dialog
      v-model="showDialog"
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
            EatInMore Store
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn
              dark
              text
              @click="showDialog = false"
            >
            <v-icon>mdi-close</v-icon>
              Close
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-title>
        </v-card-title>
        <v-card-text>
          <v-container>
                <v-row
                justify="center"
                align="center"
                >
                    <v-col
                    xs="12"
                    sm="12"
                    md="12"
                    lg="12"
                    xl="12"
                    align="center"
                    >

                        <template >
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
                                        <div class="subheading">
                                            Sorry, You cart is blank, It is currently not possible to process your order, please login.
                                        </div>
                                </v-col>

                                <v-col cols="12"
                                    justify="center"
                                    align="center"
                                    >

                                    <div class="pr-2">
                                        <router-link to="/login" tag="button">
                                        <v-btn
                                        tile
                                        small
                                        color="primary"
                                        >
                                        <v-icon>mdi-login</v-icon>
                                        {{$t('login')}}
                                        </v-btn>

                                        </router-link>
                                    </div>
                                </v-col>
                        </template>

                    </v-col>

                </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  export default {
    components: { },
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
      //console.log(this.codMeal)

    },
    watch: {
    codMeal (val, oldVal) {
      //console.log(val)
    }
    }

  }
</script>
