import Welcome from './components/Welcome/mealListWelcome.vue';
import About from './components/Welcome/About.vue';
import Terms from './components/Welcome/Terms.vue';
import Contact from './components/Welcome/Contact.vue';
import Home from './components/Home.vue';
import Login from './components/Auth/Login.vue';
import Register from './components/Auth/Register.vue';
import UserEdit from './components/Auth/UserEdit.vue';
import ForgotPassword from './components/Auth/ForgotPassword.vue';
import RegisterResult from './components/Auth/RegisterResult.vue';
import VerifyResult from './components/Auth/VerifyResult.vue';
import CreateChefe from './components/Chefe/Index.vue';
import MealNew from './components/Meal/MealNew';
import MealIndex from './components/Meal/index';
import Tools from './components/Tools/index.vue';
import ForgotPasswordResult from './components/Auth/ForgotPasswordResult.vue';
import NotFound from './components/NotFound';
import ResetPassword from './components/Auth/ResetPassword.vue';
import UserProfile from  './components/Profile/User.vue';
import NoPermission from './components/NoPermission';
import Cart from './components/Cart/index.vue';


export const routes = [
    {
        path :'*',
        component:NotFound
    },
    {
        name: 'welcome',
        path: '/',
        component: Welcome,
        props: true,
        meta: {
            antWelcomeLayout: true,
        },
    },
    {
        name: 'terms&conditions',
        path: '/terms',
        component: Terms,
        props: true,
        meta: {
            antWelcomeLayout: true,
        },
    },
    {
        name: 'contact',
        path: '/contact',
        component: Contact,
        props: true,
        meta: {
            antWelcomeLayout: true,
        },
    },
    {
        name: 'about',
        path: '/about',
        component: About,
        props: true,
        meta: {
            antWelcomeLayout: true,
        },
    },
    {
        name: 'register/result',
        path: '/registerResult',
        component: RegisterResult
    },
    {
        name: '403',
        path: '/403',
        component: NoPermission
    },
    {
        name: 'ForgotPasswordResult',
        path: '/ForgotPasswordResult',
        component: ForgotPasswordResult
    },
    {
        name: 'verifyResult',
        path: '/verifyResult',
        component: VerifyResult
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
        props: true,
        meta: {
            antLoginLayout: true,
        },
    },
    {
        name: 'forgetPassword',
        path: '/forgetPassword',
        component: ForgotPassword,
        props: true,
        meta: {
            antLoginLayout: true,
        },
    },
    {
        name: 'register',
        path: '/register',
        component: Register,
        props: true,
        meta: {
            antRegisterLayout: true,
        },
    },
    {
        name: 'home',
        path: '/home',
        component: Home,
        props: true,
        meta: {
            antMasterLayout: true,
            auth: true,
            resource: 'home',
        },
    },
    {
        name: 'chefe/new',
        path: '/chefeNew',
        component: CreateChefe,
        props: true,
        meta: {
            antMasterLayout: true,
            auth: true,
        },
    },
    {
        name: 'meal/new',
        path: '/mealNew',
        component: MealNew,
        props: true,
        meta: {
            antMasterLayout: true,
            auth: true,
        },
    },
    {
        name: 'meal/index',
        path: '/mealIndex',
        component: MealIndex,
        props: true,
        meta: {
            antMasterLayout: true,
            auth: true,
        },
    },
    {
        name: 'tools/index',
        path: '/tools',
        component: Tools,
        props: true,
        meta: {
            antMasterLayout: true,
            auth: true,
        },
    },
    {
        name: 'password/reset/',
        path: '/password/reset/:token',
        component: ResetPassword,
        props: true,
        meta: {
            antLoginLayout: true,
        },
    },
    {
        name: '/profile/',
        path: '/profile/:token',
        component: UserProfile,
        props: true,
    },
    {
        name: 'cart',
        path: '/cart',
        component: Cart,
        props: true,
        meta: {
            antMasterLayout: true,
            auth: true,
        },
    },

];



