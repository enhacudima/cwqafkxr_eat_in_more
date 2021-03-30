<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
      class="pt-4"
      color="grey lighten-3"
      mini-variant
    >
      <v-avatar
        class="d-block text-center mx-auto mb-9"
      >
      <img
        src="storage/icons/icon.jpg"
        lazy-src="storage/icons/icon.jpg"
        alt="logo"
      ></v-avatar>
    </v-navigation-drawer>

    <v-main>
        <v-card class="mx-auto" max-width="1000" tile>
            <v-img height="200" src="storage/icons/fundo.jpeg"
            lazy-src="storage/icons/fundo.jpeg"
            ></v-img>
            <v-row style="margin:2.5%;position:absolute; top: 130px">

                        <v-list-item dense>
                        <v-list-item-avatar size="100">
                            <img
                                :src="'storage/'+user.user.avatar"
                                alt="avatar"
                            >
                            </v-list-item-avatar>
                            <v-list-item-content>
                            <v-list-item-title class="title" style="margin-top:20px;">{{user.user.name}} {{user.user.lastName}}</v-list-item-title>
                            <v-list-item-subtitle>{{user.user.user_type}} | {{user.user.title}}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-phone
                            </v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                            <v-list-item-title>(650) 555-1234</v-list-item-title>
                            <v-list-item-subtitle>Mobile</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-icon>
                            <v-icon>mdi-message-text</v-icon>
                            </v-list-item-icon>
                        </v-list-item>

                        <v-list-item dense>
                            <v-list-item-action></v-list-item-action>

                            <v-list-item-content>
                            <v-list-item-title>(323) 555-6789</v-list-item-title>
                            <v-list-item-subtitle>Work</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-icon>
                            <v-icon>mdi-message-text</v-icon>
                            </v-list-item-icon>
                        </v-list-item>

                        <v-divider inset></v-divider>

                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-email
                            </v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                            <v-list-item-title>aliconnors@example.com</v-list-item-title>
                            <v-list-item-subtitle>Personal</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>

                        <v-list-item dense>
                            <v-list-item-action></v-list-item-action>

                            <v-list-item-content>
                            <v-list-item-title>ali_connors@example.com</v-list-item-title>
                            <v-list-item-subtitle>Work</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>

                        <v-divider inset></v-divider>

                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-map-marker
                            </v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                            <v-list-item-title>1400 Main Street</v-list-item-title>
                            <v-list-item-subtitle>Orlando, FL 79938</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>

                        <v-divider inset></v-divider>

                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-email
                            </v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                            <v-list-item-title>About My CV</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                        <v-list-item dense>
                            <v-list-item-action></v-list-item-action>

                            <v-list-item-content>
                            <v-list-item-title>{{user.chef.title}}</v-list-item-title>
                            <v-list-item-subtitle>{{user.chef.summary}}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
            </v-row>
        </v-card>
    </v-main>
  </v-app>
</template>

<script>
  export default {

    data() {

        return {
            drawer:true,
            user:[],
        }

    },
    computed: {
        token(){
            return this.$route.params.token;
        },
    },
    mounted() {
    axios
        .get('user/profile/'+this.token)
        .then(response => (this.user = response.data));
    },

  }
</script>
