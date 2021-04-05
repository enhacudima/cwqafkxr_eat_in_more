
import Vue from 'vue';
import VueI18n from 'vue-i18n';

Vue.use(VueI18n);


const messages = {
    'en': {
        login:'Sign in to start your session'
    },
    'pt': {
        login:'Faça login para iniciar sua sessão'
    }
};

const i18n = new VueI18n({
    locale: 'en', // set locale
    fallbackLocale: 'pt', // set fallback locale
    messages, // set locale messages
});

export {i18n};
