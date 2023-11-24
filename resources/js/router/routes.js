// general routes
const Home = () =>
  import(/* webpackChunkName: "js/HomePage" */ '@pages/Home.vue');
const About = () =>
  import(/* webpackChunkName: "js/AboutPage" */ '@pages/About.vue');
const Terms = () =>
  import(/* webpackChunkName: "js/TermsPage" */ '@pages/Terms.vue');
const Dashboard = () =>
  import(/* webpackChunkName: "js/DashboardPage" */ '@pages/Dashboard.vue');
const Login = () =>
  import(/* webpackChunkName: "js/LoginPage" */ '@pages/Login.vue');
const ForgotPassword = () =>
  import(
    /* webpackChunkName: "js/ForgotPasswordPage" */ '@pages/ForgotPassword.vue'
  );
const ResetPassword = () =>
  import(
    /* webpackChunkName: "js/ResetPasswordPage" */ '@pages/ResetPassword.vue'
  );
const Register = () =>
  import(/* webpackChunkName: "js/RegisterPage" */ '@pages/Register.vue');
const VerifyEmail = () =>
  import(/* webpackChunkName: "js/VerifyEmailPage" */ '@pages/VerifyEmail.vue');

const Settings = () =>
  import(
    /* webpackChunkName: "js/SettingsPage" */ '@pages/settings/Settings.vue'
  );

const profileSettings = () =>
  import(
    /* webpackChunkName: "js/SettingsPage" */ '@pages/profileSettings.vue'
  );

const Profile = () =>
  import(
    /* webpackChunkName: "js/ProfilePage" */ '@pages/settings/Profile.vue'
  );
const Password = () =>
  import(
    /* webpackChunkName: "js/PasswordPage" */ '@pages/settings/Password.vue'
  );
const Account = () =>
  import(
    /* webpackChunkName: "js/AccountPage" */ '@pages/settings/Account.vue'
  );
const NotFound = () =>
  import(/* webpackChunkName: "js/NotFoundPage" */ '@pages/NotFound.vue');

const AdminDashboard = () => import('@pages/Admin/dashboard.vue');
const Participants = () => import('@pages/Admin/participants.vue');
const ModerationPending = () => import('@pages/Admin/moderation/pending.vue');
const ModerationApproved = () => import('@pages/Admin/moderation/approved.vue');
const ModerationRejected = () => import('@pages/Admin/moderation/rejected.vue');
const WinnersClaimed = () => import('@pages/Admin/winners/claimed.vue');
const WinnersPending = () => import('@pages/Admin/winners/pending.vue');
const HelpDesk = () => import('@pages/Admin/helpdesk.vue');
const Exports = () => import('@pages/Admin/exports.vue');
const Inventory = () => import('@pages/Admin/inventory.vue');
const Statistics = () => import('@pages/Admin/statistics.vue');

const AdminLayout = () =>
  import(
    /* webpackChunkName: "js/AdminLayoutPage" */ '@/layouts/AdminLayout.vue'
  );
const Admin = () =>
  import(/* webpackChunkName: "js/AdminPage" */ '@/views/admin/Admin.vue');
const Users = () =>
  import(/* webpackChunkName: "js/UsersPage" */ '@/views/admin/Users.vue');
const Roles = () =>
  import(/* webpackChunkName: "js/RolesPage" */ '@/views/admin/Roles.vue');
const Permissions = () =>
  import(
    /* webpackChunkName: "js/PermissionsPage" */ '@/views/admin/Permissions.vue'
  );
const AppSettings = () =>
  import(
    /* webpackChunkName: "js/AppSettingsPage" */ '@/views/admin/AppSettings.vue'
  );
// const PhpInfo = () =>
// import(/* webpackChunkName: "js/PhpInfoPage" */ '@/views/admin/PhpInfo.vue');
const UsersAbout = () =>
  import(/* webpackChunkName: "js/UsersTermsPage" */ '@/views/pages/About.vue');

const UsersTerms = () =>
  import(/* webpackChunkName: "js/UsersTermsPage" */ '@/views/pages/Terms.vue');

import { defineAsyncComponent } from 'vue';

import auth from '@/middleware/auth';
import guest from '@/middleware/guest';
import roleAdmin from '@/middleware/roleAdmin';
import roleSuperAdmin from '@/middleware/roleSuperAdmin';
import roleUser from '@/middleware/roleUser';

export default [
  {
    path: '/',
    // component: () => Home,
    component: Home,
    name: 'home',
  },
  {
    path: '/about',
    component: About,
    name: 'about',
  },
  {
    path: '/terms',
    component: Terms,
    name: 'terms',
  },
  {
    path: '/dashboard',
    component: Dashboard,
    name: 'dashboard',
    meta: {
      middleware: [auth],
    },
  },

  {
    path: '/admin',
    component: AdminLayout,
    children: [
      {
        path: '',
        name: 'admin',
        component: Admin,
      },
      {
        path: 'dashboard',
        name: 'admin.dashboard',
        component: AdminDashboard,
        meta: {
          middleware: [roleSuperAdmin],
        },
      },

      {
        path: 'participants',
        name: 'admin.participants',
        component: Participants,
        meta: {
          middleware: [roleSuperAdmin],
        },
      },

      {
        path: 'moderation/pending',
        name: 'admin.moderation.pending',
        component: ModerationPending,
        meta: {
          middleware: [roleSuperAdmin],
        },
      },

      {
        path: 'moderation/approved',
        name: 'admin.moderation.approved',
        component: ModerationApproved,
        meta: {
          middleware: [roleSuperAdmin],
        },
      },

      {
        path: 'moderation/rejected',
        name: 'admin.moderation.rejected',
        component: ModerationRejected,
        meta: {
          middleware: [roleSuperAdmin],
        },
      },

      {
        path: 'winners/claimed',
        name: 'admin.winners.claimed',
        component: WinnersClaimed,
        meta: {
          middleware: [roleSuperAdmin],
        },
      },
      {
        path: 'winners/pending',
        name: 'admin.winners.pending',
        component: WinnersPending,
        meta: {
          middleware: [roleSuperAdmin],
        },
      },

      {
        path: 'helpdesk',
        name: 'admin.helpdesk',
        component: HelpDesk,
        meta: {
          middleware: [roleSuperAdmin],
        },
      },

      {
        path: 'exports',
        name: 'admin.exports',
        component: Exports,
        meta: {
          middleware: [roleSuperAdmin],
        },
      },

      {
        path: 'inventory',
        name: 'admin.inventory',
        component: Inventory,
        meta: {
          middleware: [roleSuperAdmin],
        },
      },

      {
        path: 'statistics',
        name: 'admin.statistics',
        component: Statistics,
        meta: {
          middleware: [roleSuperAdmin],
        },
      },

      {
        path: 'users',
        name: 'users',
        component: Users,
      },
      {
        path: 'roles',
        name: 'roles',
        component: Roles,
      },
      {
        path: 'permissions',
        name: 'permissions',
        component: Permissions,
      },
      {
        path: 'phpinfo',
        name: 'phpinfo',
        component: defineAsyncComponent(
          () => import('@/views/admin/PhpInfo.vue'),
        ),
      },
      {
        path: 'app-settings',
        name: 'app-settings',
        component: AppSettings,
      },
    ],
    meta: {
      middleware: [roleAdmin],
    },
  },
  {
    path: '/login',
    component: Login,
    name: 'login',
    meta: {
      middleware: [guest],
    },
  },
  {
    path: '/forgot-password',
    component: ForgotPassword,
    name: 'forgot-password',
    meta: {
      middleware: [guest],
    },
  },
  {
    path: '/reset-password/:token',
    props: (route) => ({
      token: route.params.token,
      email: route.query.email,
    }),
    component: ResetPassword,
    name: 'reset-password',
    meta: {
      middleware: [guest],
    },
  },
  {
    path: '/register',
    component: Register,
    name: 'register',
    meta: {
      middleware: [guest],
    },
  },
  {
    path: '/verify-email/:id/:hash',
    props: (route) => ({
      id: route.params.id,
      hash: route.params.hash,
    }),
    component: VerifyEmail,
    name: 'verify-email',
  },
  {
    path: '/settings',
    component: Settings,
    redirect: {
      name: 'account',
    },
    name: 'settings',
    meta: {
      middleware: [auth],
    },
    children: [
      {
        path: 'account',
        component: Account,
        name: 'account',
        meta: {
          middleware: [auth],
        },
      },
      {
        path: 'profile',
        component: Profile,
        name: 'profile',
        meta: {
          middleware: [auth],
        },
      },
      {
        path: 'password',
        component: Password,
        name: 'password',
        meta: {
          middleware: [auth],
        },
      },
    ],
  },
  {
    path: '/:pathMatch(.*)*',
    component: NotFound,
    name: 'NotFound',
  },
  {
    path: '/users/about',
    component: UsersAbout,
    name: 'users-about',
    meta: {
      middleware: [auth],
    },
  },
  {
    path: '/users/terms',
    component: UsersTerms,
    name: 'users-terms',
    meta: {
      middleware: [auth],
    },
  },
  {
    path: '/profile/settings',
    component: profileSettings,
    name: 'profile-settings',
    meta: {
      middleware: [auth],
    },
  },
];
