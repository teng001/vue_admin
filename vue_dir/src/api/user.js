import fetch from '@/utils/fetch'

export function fetchUserList(param) {
  return fetch({
    url: '/admin/userList',
    method: 'get',
    params: param
  })
}

export function fetchUserDetail(id) {
  return fetch({
    url: '/admin/userDetail/' + id,
    method: 'get'
  })
}

export function fetchSaveUser(param) {
  return fetch({
    url: '/admin/saveUser',
    method: 'post',
    params: param
  })
}
