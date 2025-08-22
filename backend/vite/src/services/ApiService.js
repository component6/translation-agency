import axios from "axios"

class ApiService {
  static baseUrl() {
    return import.meta.env.VITE_APP_URL
  }

  static taskUrl() {
    return `${this.baseUrl()}/api/task`
  }

  static employeeUrl() {
    return `${this.baseUrl()}/api/employee`
  }

  static getDefaultHeaders() {
    return {
      'Content-Type': 'application/json;charset=UTF-8',
    }
  }

  static async sendRequest(url, options = {}) {
    let res = { status: false, data: null }

    try {
      const config = {
        ...options,
        headers: {
          ...this.getDefaultHeaders(),
          ...(options.headers || {}),
        },
      }

      const resp = await axios.request({ url, ...config })
      if (resp.status) {
        return { ...res, status: true, data: resp.data.data }
      }
    } catch (e) {
      console.error('ApiService=> sendRequest=> e:', e)
      return res
    }
  }

  static async getTasks() {
    const url = `${this.taskUrl()}/tasks`;
    return await this.sendRequest(url)
  }

  static async getEmployees() {
    const url = `${this.employeeUrl()}/employees`;
    return await this.sendRequest(url)
  }

  static async getFieldsTask() {
    const url = `${this.taskUrl()}/fields-task`;
    return await this.sendRequest(url)
  }

  static async getFieldsEmployee() {
    const url = `${this.employeeUrl()}/fields-employee`;
    return await this.sendRequest(url)
  }

  static async saveTask(data = {}) {
    const url = `${this.taskUrl()}/save-task`;
    return await this.sendRequest(url, { method: 'post', data })
  }
}

export default ApiService