<template>
<div  >
    <v-row>
    <v-col cols="12" >
    <section id="Brand">
        <v-card
        elevation="2"
        >
        <v-card-title>leave message here</v-card-title>
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


                <v-btn
                class="mr-4"
                @click="submit"
                >
                submit
                </v-btn>
                <v-btn @click="clear">
                clear
                </v-btn>
            </form>
            </v-card>

    </section>

    <section id="Mission">
        <p class="font-weight-medium" >
        Mission.
        </p>
        <p class="font-weight-light">
            EatInMore is a chefs’ application with the aim to provide an excellent cooking experience and a remarkable service to our clients, by giving them the best chefs the world has to offer to cook for them at the comfort of their own home and also provide an innovative approach into the culinary field.
        </p>
    </section>

    </v-col>

    <v-navigation-drawer
      app
      clipped
      right
      dense
    >
    <v-subheader><strong>Contents</strong></v-subheader>
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

        items: [
            { title: 'Brand',link:'#Brand', icon: 'mdi-ray-start-vertex-end' },
            { title: 'Mission',link:'#Mission', icon: 'mdi-account' },
            { title: 'Vision',link:'#Vision', icon: 'mdi-hvac' },
            { title: 'Works',link:'#Works', icon: 'mdi-playlist-check'}
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

