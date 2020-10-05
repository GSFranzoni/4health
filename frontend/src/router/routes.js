
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '/admin',
        component: () => import('layouts/AdminRoot.vue'),
        children: [
          {
            path: '/admin/pacientes',
            component: () => import('pages/admin/Pacientes.vue')
          },
          {
            path: '/admin/medicos',
            component: () => import('pages/admin/Medicos.vue')
          }
        ]
      },
    ]
  },
  {
    path: '/auth',
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
