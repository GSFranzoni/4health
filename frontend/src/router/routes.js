import AuthService from '../services/AuthService';
import Store from '../store/index';

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    redirect: '/home',
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('token');
      if(!token) {
        Store.commit('logout');
        return next('/auth');
      }
      AuthService.me(token).then(res => {
        Store.commit('setUsuario', res.data.usuario);
        Store.commit('setInfo', res.data.info);
        next();
      })
      .catch(err => {
        Store.commit('logout');
        next('/auth');
      });
    },
    children: [
      {
        path: 'home',
        component: () => import('pages/Index.vue'),
      },
      {
        path: 'paciente',
        component: () => import('layouts/Root.vue'),
        redirect: '/home',
        beforeEnter: (to, from, next) => {
          if(Store.state.usuario.tipo_usuario == 3) {
            next();
          }
          else {
            Store.commit('logout');
            next('/auth')
          }
        },
        children: [
          {
            path: 'medicos',
            component: () => import('pages/paciente/MedicosList.vue'),
          },
          {
            path: 'ficha',
            component: () => import('pages/paciente/ExamesList.vue'),
          }
        ]
      },
      {
        path: 'medico',
        component: () => import('layouts/Root.vue'),
        redirect: '/home',
        beforeEnter: (to, from, next) => {
          if(Store.state.usuario.tipo_usuario == 2) {
            next();
          }
          else {
            Store.commit('logout');
            next('/auth')
          }
        },
        children: [
          {
            path: 'pacientes',
            component: () => import('pages/medico/PacientesList.vue'),
          },
          {
            path: 'exames',
            component: () => import('pages/medico/ExamesMedico.vue'),
            props: true
          },
          {
            path: 'pacientes/:paciente/exames',
            component: () => import('pages/medico/ExamesPaciente.vue'),
            props: true
          }
        ]
      },
      {
        path: 'admin',
        component: () => import('layouts/Root.vue'),
        redirect: '/home',
        beforeEnter: (to, from, next) => {
          if(Store.state.usuario.tipo_usuario == 1) {
            next();
          }
          else {
            Store.commit('logout');
            next('/auth')
          }
        },
        children: [
          {
            path: 'pacientes',
            component: () => import('layouts/Root.vue'),
            children: [
              {
                path: '',
                component: () => import('pages/admin/PacientesList.vue'),
              }
            ]
          }, 
          {
            path: 'medicos',
            component: () => import('layouts/Root.vue'),
            children: [
              {
                path: '',
                component: () => import('pages/admin/MedicosList.vue'),
              }
            ]
          }
        ]
      },
    ]
  },
  {
    path: '/auth',
    name: 'auth',
    beforeEnter: (to, from, next) => {
      if(localStorage.getItem('token')) {
        next('/');
      }
      else {
        next()
      }
    },
    component: () => import('pages/Auth.vue')
  },
  {
    path: '/logout',
    component: () => import('pages/Logout.vue')
  },
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
