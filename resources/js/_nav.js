export default [
    {
      component: 'CNavItem',
      name: 'Explore Now',
      to: '/',
      icon: 'cil-drop',
    },
    {
        component: 'CNavGroup',
        name: 'User Management',
        to: '/base',
        icon: 'cil-puzzle',
        items: [
            {
                component: 'CNavItem',
                name: 'Permissions',
                to: '/base/accordion',
            },
            {
                component: 'CNavItem',
                name: 'Roles',
                to: '/base/breadcrumbs',
            },
            {
                component: 'CNavItem',
                name: 'Cards',
                to: '/base/cards',
            },
        ],
    },
    {
        component: 'CNavItem',
        name: 'Article',
        to: '/theme/typography',
        icon: 'cil-pencil',
      },
]
