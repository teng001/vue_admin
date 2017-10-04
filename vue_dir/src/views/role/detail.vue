<template>
  <div class="app-container">
    <el-form ref="roleDetail" :model="roleDetail" label-width="160px">
      <el-form-item label="角色名称">
        <el-input v-model="roleDetail.display_name"></el-input>
      </el-form-item>
      <el-form-item label="角色标识">
        <el-input v-model="roleDetail.name"></el-input>
      </el-form-item>
      <el-form-item label="描述">
        <el-input v-model="roleDetail.description"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">保存</el-button>
        <el-button>取消</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
import { fetchRoleDetail, fetchSaveRole } from '@/api/role'
export default {
  data() {
    return {
      roleDetail: {
        id: '',
        name: '',
        display_name: '',
        description: ''
      }
    }
  },
  methods: {
    onSubmit() {
      this.$refs.roleDetail.validate(valid => {
        if (valid) {
          this.loading = true
          fetchSaveRole(this.roleDetail).then(response => {
            console.log(response)
          })
          this.$notify({
            title: '成功',
            message: '发布文章成功',
            type: 'success',
            duration: 2000
          })
          this.loading = false
        } else {
          console.log('error submit!!')
          return false
        }
      })
    },
    getRoleDetail() {
      const t = this
      const id = this.$route.params.id
      fetchRoleDetail(id).then(response => {
        if (response.data.data.id) {
          t.roleDetail = response.data.data
        }
      }).catch(error => {
        console.log(error)
      })
    }
  },
  created() {
    this.getRoleDetail()
  }
}

</script>
