import fetch from '@/utils/fetch'

export function fetchRoleList(param) {
  return fetch({
    url: '/admin/roleList',
    method: 'get',
    params: param
  })
}

export function fetchRoleDetail(id) {
  return fetch({
    url: '/admin/roleDetail/' + id,
    method: 'get'
  })
}

export function fetchSaveRole(param) {
  return fetch({
    url: '/admin/saveRole',
    method: 'post',
    params: param
  })
}

export function fetchSavePermissionRole(param) {
  return fetch({
    url: '/admin/saveRolePermission',
    method: 'post',
    params: param
  })
}

export function fetchUserRoleList() {
  return fetch({
    url: '/admin/getUserRoleList',
    method: 'get'
  })
}
