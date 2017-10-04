import fetch from '@/utils/fetch'

export function fetchPermissionList() {
  return fetch({
    url: '/admin/permissionList',
    method: 'get'
  })
}

export function fetchPermissionDetail(id) {
  return fetch({
    url: '/admin/permissionDetail/' + id,
    method: 'get'
  })
}

export function fetchSavePermission(param) {
  return fetch({
    url: '/admin/savePermission',
    method: 'post',
    params: param
  })
}

export function getTreeMenu() {
  return fetch({
    url: '/admin/getTreeMenu',
    method: 'get'
  })
}

export function fetchPermissionDelete(id) {
  return fetch({
    url: '/admin/delPermission/' + id,
    method: 'post'
  })
}
