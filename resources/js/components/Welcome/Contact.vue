<template>
<div  >
    <v-row>
    <v-col cols="12" >
    <section id="contactform">
        <v-card
        elevation="2"
        >
        <v-card-title>Send message for us</v-card-title>
        <v-card-subtitle>Our team will answer you as soon as possible</v-card-subtitle>
            <form class="pa-6">
                <v-text-field
                v-model="name"
                :error-messages="nameErrors"
                :counter="10"
                label="Name"
                required
                @input="$v.name.$touch()"
                @blur="$v.name.$touch()"
                ></v-text-field>
                <v-text-field
                v-model="email"
                :error-messages="emailErrors"
                label="E-mail"
                required
                @input="$v.email.$touch()"
                @blur="$v.email.$touch()"
                ></v-text-field>

                <v-textarea
                rows="2"
                v-model="message"
                label="Message"
                :counter="255"
                :error-messages="messageErrors"
                @change="$v.message.$touch()"
                @blur="$v.message.$touch()"
                required
                ></v-textarea>


            <v-card-actions>
                <v-btn
                outlined
                class="mr-4"
                @click="submit"
                >
                submit
                </v-btn>
                <v-btn
                outlined
                @click="clear"
                color="indigo"
                >
                clear
                </v-btn>

            </v-card-actions>

            </form>
            </v-card>

    </section>
    </v-col>
    <v-col cols="12">

        <v-row class="mt-10">
            <v-col cols="6" class="pl-6">
                <v-row>
                    <v-icon

                    >
                    mdi-map-marker
                    </v-icon>

                    <div class="font-weight-medium"> Countries</div>
                </v-row>
                <v-row class="pl-6 pt-6">
                    <strong>South Africa</strong> - 234 STRELITZIA CNR BLACK ROCK,ROAD, EMERALD BLVD, GREENSTONE HILL, GAUTENG, 1609
                </v-row>

                <v-row class="pl-6 pt-3">
                    <strong>Mozambique</strong>
                </v-row>

            </v-col>
            <v-col cols="1">

            <v-divider  vertical></v-divider>
            </v-col>
            <v-col cols="5" class="">
                <v-row>
                    <v-icon

                    >
                    mdi-dialpad
                    </v-icon>

                    <div class="font-weight-medium"> Dialing</div>
                </v-row>
                <v-row class="pt-6">
                    <strong>South Africa</strong> - comercial.sa@eatinmore.com
                </v-row>

                <v-row class="pt-3">
                    <strong>Mozambique</strong>-comercial.mz@eatinmore.com
                </v-row>

            </v-col>
        </v-row>

    </v-col>

    <v-row class="mt-10">
        <v-col cols="12">

            <section id="team">
                <p class="font-weight-medium" >
                Thank You.
                </p>
                <p class="font-weight-light">
                EatInMore Team is grateful for using our services and we wish you lovely day. <v-icon  color="red">mdi-heart</v-icon><v-icon small color="red">mdi-heart</v-icon><v-icon x-small color="red">mdi-heart</v-icon></p>
            </section>

        </v-col>
    </v-row>

    <v-navigation-drawer
      app
      clipped
      right
      dense
    >

      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title">
            Contents
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

    <v-divider></v-divider>
      <v-list shaped dense>
            <v-list-item-group
                color="primary"
            >

        <v-list-item
            v-for="(item, i) in items"
            :key="i"
            @click="$vuetify.goTo(item.link)"

        >
            <v-list-item-content>
                <v-list-item-title v-text="item.title"></v-list-item-title>
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
    </v-row>
</div>
</template>
<script>
  import { validationMixin } from 'vuelidate'
  import { required, maxLength, email } from 'vuelidate/lib/validators'

  export default {
    mixins: [validationMixin],

    validations: {
      name: { required, maxLength: maxLength(10) },
      email: { required, email ,maxLength: maxLength(255)},
      message: { required,maxLength: maxLength(255) },
    },

    data: () => ({
        icons: [
            'mdi-facebook',
            'mdi-twitter',
            'mdi-linkedin',
            'mdi-instagram',
        ],
        items: [
            { title: 'Contact Form',link:'#contactform', icon: 'mdi-ray-start-vertex-end' },
            { title: 'Team',link:'#team', icon: 'mdi-account' },
        ],
      name: '',
      email: '',
      message: '',
    }),

    computed: {
      messageErrors () {
        const errors = []
        if (!this.$v.message.$dirty) return errors
        !this.$v.message.required && errors.push('Message is required')
        return errors
      },
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.maxLength && errors.push('Name must be at most 10 characters long')
        !this.$v.name.required && errors.push('Name is required.')
        return errors
      },
      emailErrors () {
        const errors = []
        if (!this.$v.email.$dirty) return errors
        !this.$v.email.email && errors.push('Must be valid e-mail')
        !this.$v.email.required && errors.push('E-mail is required')
        return errors
      },
    },

    methods: {
      submit () {
        this.$v.$touch()
      },
      clear () {
        this.$v.$reset()
        this.name = ''
        this.email = ''
        this.name = null
        this.checkbox = false
      },
    },
  }
</script>

