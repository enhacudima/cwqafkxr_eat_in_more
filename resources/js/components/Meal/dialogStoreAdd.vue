<template>
  <v-row justify="center">
    <v-dialog
      v-model="showDialogStoreAdd"
      max-width="400px"
      transition="dialog-bottom-transition"
    >
      <v-card>
        <v-card-title>Portion ({{portion}} People)</v-card-title>
        <v-divider></v-divider>
        <v-card-text style="">
            <v-row
                class="mb-4"
                justify="space-between"
            >
                <v-col class="text-left">
                <span
                    class="display-3 font-weight-light"
                    v-text="bpm"
                ></span>
                <span class="subheading font-weight-light mr-1">Portion</span>
                <v-fade-transition>
                    <v-avatar
                    v-if="isPlaying"
                    :color="color"
                    :style="{
                        animationDuration: animationDuration
                    }"
                    class="mb-1 v-avatar--metronome"
                    size="12"
                    ></v-avatar>
                </v-fade-transition>
                </v-col>
                <v-col class="text-right">
                <v-btn
                    :color="color"
                    dark
                    depressed
                    fab
                    @click="toggle"
                >
                    <v-icon large>
                        mdi-noodles
                    </v-icon>
                </v-btn>
                </v-col>
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
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
        bpm: 1,
        interval: null,
        isPlaying: true,
        portion:1,
        multpl:1,
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
            if (this.bpm < 5) return 'indigo'
            if (this.bpm < 10) return 'teal'
            if (this.bpm < 20) return 'green'
            if (this.bpm < 30) return 'orange'
            return 'red'
        },
        animationDuration () {
            return `${20 / this.bpm}s`
        },
    },
    methods: {
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
      //console.log(this.codMeal)

    },
    watch: {
    codMeal (val, oldVal) {
        this.bpm=1;
        this.multpl=val[1];
        this.portion=this.bpm*this.multpl;
      //console.log(val[1])
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
</style>
