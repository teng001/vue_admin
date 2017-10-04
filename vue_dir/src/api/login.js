import fetch from '@/utils/fetch'

export function loginByUsername(username, password) {
  const data = {
    username,
    password
  }
  return fetch({
    url: '/admin/login',
    method: 'post',
    data
  })
}

export function logout() {
  return fetch({
    url: '/login/logout',
    method: 'post'
  })
}

export function getUserInfo(token) {
  return fetch({
    url: '/admin/userInfo',
    method: 'get',
    params: { token }
  })
}

export function getMenuList() {
  return fetch({
    url: '/admin/menuList',
    method: 'get'
  })
}
