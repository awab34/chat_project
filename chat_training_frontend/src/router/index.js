import { createRouter, createWebHistory } from 'vue-router'
import store from '../store/index.js'
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/Auth/login.vue')
    },
    {
      path: '/register',
      name: 'register',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/Auth/register.vue')
    },
    {
      path: '/home',
      name: 'home',
      meta:{requiresAuth:true},
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/user/index.vue')
    },
    {
      path: '/showfriends',
      name: 'showfriends',
      meta:{requiresAuth:true},
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/friend/index.vue')
    },
    {
      path: '/showfriendrequests',
      name: 'showfriendrequests',
      meta:{requiresAuth:true},
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/friend/friendRequest.vue')
    },
    {
      path: '/createfriends',
      name: 'createfriends',
      meta:{requiresAuth:true},
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/friend/create.vue')
    },
    {
      path: '/friendinfo',
      name: 'friendinfo',
      meta:{requiresAuth:true},
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/friend/info.vue')
    },
    {
      path: '/userinfo',
      name: 'userinfo',
      meta:{requiresAuth:true},
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/user/info.vue')
    },
    {
      path: '/groupinfo',
      name: 'groupinfo',
      meta:{requiresAuth:true},
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/Group/info.vue')
    },
    {
      path: '/showfriendchat',
      name: 'showfriendchat',
      meta:{requiresAuth:true},
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/FriendChat/index.vue')
    },
    {
      path: '/creategroup',
      name: 'creategroup',
      meta:{requiresAuth:true},
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/Group/create.vue')
    },
    {
      path: '/updategroup',
      name: 'updategroup',
      meta:{requiresAuth:true},
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/Group/update.vue')
    },
    {
      path: '/showgroup',
      name: 'showgroup',
      meta:{requiresAuth:true},
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/Group/show.vue')
    },
    {
      path: '/updateUser',
      name: 'updateUser',
      meta:{requiresAuth:true},
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/user/update.vue')
    },
    
  ]
})
router.beforeEach((to,from,next) => {
  let redirectBool = localStorage.getItem('accessToken') == null ? false : true;
    console.log(redirectBool)
    if(to.meta.requiresAuth && !redirectBool ){
      next({name:'login'})
    }else if( (to.name == 'login' || to.name == 'register') && redirectBool){
      next({name:'home'})
    }else{
      next()
    }
})

export default router
