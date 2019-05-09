

export const routes = [
	{
		path: '/',
		component: require('./components/spa/Home.vue').default,
		meta: {
			requiresAuth: true
		}
	},
	{
			path: '/ideas',
			component: require('./views/Ideas.vue').default,

	},
	{
			path: '/login',
			component: require('./components/auth/Login.vue').default,

	},
	{
			path: '/home',
			component: require('./views/Home.vue').default,

	},

];