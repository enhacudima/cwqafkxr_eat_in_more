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
        :src="baseUrl+'storage/icons/40x40px.png'"
        :lazy-src="baseUrl+'storage/icons/40x40px.png'"
        alt="logo"
      ></v-avatar>
    </v-navigation-drawer>

    <v-main>
        <v-card class="mx-auto" max-width="1000" tile>
            <v-img height="200" :src="baseUrl+'storage/icons/fundo.jpeg'"
            :lazy-src="baseUrl+'storage/icons/fundo.jpeg'"
            ></v-img>
            <v-row style="margin:2.5%;position:absolute; top: 130px">

                        <v-list-item dense>
                        <v-list-item-avatar size="100">
                            <img
                                :src="baseUrl+'storage/'+profile.avatar"
                                :lazy-src="baseUrl+'storage/'+profile.avatar"
                            >
                            </v-list-item-avatar>
                            <v-list-item-content>
                            <v-list-item-title class="title" style="margin-top:20px;">{{profile.name}} {{profile.lastName}} - {{profile.country}}</v-list-item-title>
                            <v-list-item-subtitle>{{profile.user_type}} | {{profile.title}}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-phone
                            </v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                            <v-list-item-title>+{{profile.phone1}}</v-list-item-title>
                            <v-list-item-subtitle>Mobile</v-list-item-subtitle>
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
                            <v-list-item-title>{{profile.email}}</v-list-item-title>
                            <v-list-item-subtitle>Personal</v-list-item-subtitle>
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
                            <v-list-item-title>{{profile.country}}</v-list-item-title>
                            <v-list-item-subtitle>{{profile.fullAddress}}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <div v-if="chef">
                            <v-divider inset></v-divider>

                            <v-list-item dense >
                                <v-list-item-icon>
                                <v-icon color="indigo">
                                </v-icon>
                                </v-list-item-icon>

                                <v-list-item-content>
                                <v-list-item-title>About My CV</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        <v-list-item dense>
                            <v-list-item-content v-if="chef.picture">
                                <v-img
                                :lazy-src="baseUrl+'storage/'+chef.picture.path+chef.picture.name"
                                :src="baseUrl+'storage/'+chef.picture.path+chef.picture.name"
                                max-height="150"
                                max-width="250"
                                aspect-ratio="1"
                                contain

                                ></v-img>
                            </v-list-item-content>

                        </v-list-item>

                        <v-list-item dense>
                            <v-list-item-icon>
                            </v-list-item-icon>

                            <v-list-item-content v-if="chef.title">
                            <v-list-item-title>{{chef.title}}</v-list-item-title>
                            <v-list-item-action-text>{{chef.summary}}</v-list-item-action-text>
                            </v-list-item-content>
                        </v-list-item>

                        <v-divider inset></v-divider>
                        <div v-if="chef.cv_experiences" >
                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-briefcase
                            </v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                            <v-list-item-title>Experiences</v-list-item-title>
                            </v-list-item-content>

                        </v-list-item>
                        <v-list-item  dense  v-for="(experience, index) in chef.cv_experiences" :key="index" >
                            <v-list-item-action></v-list-item-action>

                            <v-list-item-content>
                                <div class="overline mb-4">
                                    {{experience.company_name}}
                                </div>
                            <v-list-item-subtitle>{{experience.country.entity}} · From {{experience.start}} to {{experience.end}}</v-list-item-subtitle>
                            <v-list-item-title>
                                {{experience.position}}
                            </v-list-item-title>
                            <v-list-item-action-text>{{experience.description}}</v-list-item-action-text>
                            </v-list-item-content>


                            <v-list-item-icon>
                            <v-icon>mdi-chef-hat</v-icon>
                            </v-list-item-icon>

                        </v-list-item>
                        </div>

                        <v-divider inset></v-divider>
                        <div v-if="chef.cv_school" >
                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-school
                            </v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                            <v-list-item-title>School</v-list-item-title>
                            </v-list-item-content>

                        </v-list-item>
                        <v-list-item dense  v-for="(experience, index) in chef.cv_school" :key="experience.key">
                            <v-list-item-action></v-list-item-action>

                            <v-list-item-content>
                                <div class="overline mb-4">
                                    {{experience.school_name}}
                                </div>
                            <v-list-item-subtitle>{{experience.country.entity}} · From {{experience.start}} to {{experience.end}}</v-list-item-subtitle>
                            <v-list-item-title>
                                {{experience.education}}
                            </v-list-item-title>
                            <v-list-item-action-text>{{experience.description}}</v-list-item-action-text>
                            </v-list-item-content>


                            <v-list-item-icon>
                            <v-icon>mdi-book-open-outline</v-icon>
                            </v-list-item-icon>

                        </v-list-item>
                        <v-divider inset></v-divider>
                        </div>
                        </div>


            </v-row>
        </v-card>
    </v-main>
  </v-app>
</template>

<script>
  export default {
    components: {
    },

    data() {

        return {
            //baseUrl:'http://localhost/cwqafkxr_eat_in_more/public/',
            baseUrl:'http://eatinmore.com/',
            drawer:true,
            user:[],
            profile:[],
            chef:[],
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
        .then(response => (this.user = response.data,this.profile = response.data.user,this.chef = response.data.chef));
    },

  }
</script>
