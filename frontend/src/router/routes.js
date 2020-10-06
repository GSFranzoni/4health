import AuthService from '../services/AuthService';
import Store from '../store/index';

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
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
        path: '',
        component: () => import('pages/Index.vue'),
      },
      {
        path: 'paciente',
        component: () => import('layouts/PacienteRoot.vue'),
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
            path: '',
            component: () => import('pages/Index.vue'),
          },
          {
            path: 'medicos',
            component: () => import('pages/paciente/MedicosList.vue'),
          },
          {
            path: 'ficha',
            component: () => import('pages/paciente/Ficha.vue'),
          }
        ]
      },
      {
        path: 'medico',
        component: () => import('layouts/MedicoRoot.vue'),
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
            path: '',
            component: () => import('pages/Index.vue'),
          },
          {
            path: 'pacientes',
            component: () => import('pages/medico/PacientesList.vue'),
          },
          {
            path: 'pacientes/:id/ficha',
            component: () => import('pages/paciente/Ficha.vue'),
            props: true
          }
        ]
      },
      {
        path: 'admin',
        component: () => import('layouts/AdminRoot.vue'),
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
            path: '',
            component: () => import('pages/Index.vue'),
          },
          {
            path: 'pacientes',
            component: () => import('layouts/Pacientes.vue'),
            redirect: 'pacientes/list',
            children: [
              {
                path: 'list',
                component: () => import('pages/admin/PacientesList.vue'),
              },
              {
                path: ':id/edit',
                component: () => import('components/forms/PacienteForm.vue'),
                props: true
              },
              {
                path: 'create',
                component: () => import('components/forms/PacienteForm.vue'),
              },
              {
                path: ':paciente/usuario/create',
                component: () => import('components/forms/UsuarioForm.vue'),
                props: true
              }
            ]
          },
          {
            path: 'medicos',
            component: () => import('layouts/Medicos.vue'),
            redirect: 'medicos/list',
            children: [
              {
                path: 'list',
                component: () => import('pages/admin/MedicosList.vue'),
              },
              {
                path: ':id/edit',
                component: () => import('components/forms/MedicoForm.vue'),
                props: true
              },
              {
                path: 'create',
                component: () => import('components/forms/MedicoForm.vue'),
              },
              {
                path: ':medico/usuario/create',
                component: () => import('components/forms/UsuarioForm.vue'),
                props: true
              }
            ]
          },
          {
            path: 'usuarios',
            component: () => import('layouts/Usuarios.vue'),
            children: [
              {
                path: ':id/edit',
                component: () => import('components/forms/UsuarioForm.vue'),
                props: true
              },
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
