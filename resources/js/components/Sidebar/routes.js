export default [
    {
      component: 'CNavItem',
      name: 'Explore Now',
      to: '/dashboard',
      icon: 'cil-drop',
    },
    {
        component: 'CNavGroup',
        name: 'User Management',
        to: '#',
        icon: 'cil-people',
        items: [
            {
                component: 'CNavItem',
                name: 'Users',
                to: '/users',
            },
            {
                component: 'CNavItem',
                name: 'Permissions',
                to: '/permissions',
            },
            {
                component: 'CNavItem',
                name: 'Roles',
                to: '/roles',
            },
        ],
    },
    {
        component: 'CNavGroup',
        name: 'Master Data',
        to: '#',
        icon: 'cil-book',
        items: [
            {
                component: 'CNavItem',
                name: 'Master Category',
                to: '/categories',
            },
            {
                component: 'CNavItem',
                name: 'Master Article',
                to: '/articles',
            },
        ],
    },
]
