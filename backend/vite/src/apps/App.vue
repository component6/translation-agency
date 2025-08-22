<script setup>
import { onMounted, ref } from 'vue'

import ApiService from '../services/ApiService.js'

const tasks            = ref({})
const employees        = ref({})
const statusesTask     = ref({})
const statusesEmployee = ref({})
const typesEmployee    = ref({})
const formTask         = ref({
  id: null,
  title: null,
  status: null,
  curr_employee_id: null,
  employees: [],
})

onMounted(async () => {
  await fetchFieldsTask()
  await fetchFieldsEmployee()
  await fetchTasks()
  await fetchEmployees()
})

const fetchFieldsTask = async () => {
  const resp = await ApiService.getFieldsTask()
  statusesTask.value = resp?.data?.statuses || {}
}

const fetchFieldsEmployee = async () => {
  const resp = await ApiService.getFieldsEmployee()
  statusesEmployee.value = resp?.data?.statuses || {}
  typesEmployee.value = resp?.data?.types || {}
}

const fetchTasks = async () => {
  const resp = await ApiService.getTasks()
  tasks.value = resp?.data?.sort(compareStatus) || {}
}

const fetchEmployees = async () => {
  const resp = await ApiService.getEmployees()
  employees.value = resp?.data || {}
}

const saveTask = async (data = {}) => {
  const resp = await ApiService.saveTask({
    id: data.id ?? null,
    status: data.status ?? null,
    title: data.title ?? null,
    employeesIds: data.employees.map(item => item.id)
  })
}

const openModal = (task = null) => {
  formTask.value = {
    ...task,
    employees: task.employeesTask.map(item => item.employee),
  }
  $('#formTaskModal').modal('show')
}

const submitForm = async () => {
  await saveTask(formTask.value)
  await fetchTasks()
  $('#formTaskModal').modal('hide')
}

const addEmployee = () => {
  const findEmployee = employees.value.find(item => item.id === formTask.value.curr_employee_id)
  if (
    findEmployee !== undefined &&
    !formTask.value.employees.some(emp => emp.id === findEmployee.id)
  ) {
    formTask.value.employees.push(findEmployee)
    formTask.value.curr_employee_id = null
  }
}

const deleteEmployee = (employee) => {
  formTask.value.employees = formTask.value.employees.filter(item => item.id !== employee.id)
}

const compareStatus = (taskA, taskB) => {
  const statusOrder = Object.keys(statusesTask.value)

  const statusIndexA = statusOrder.indexOf(taskA.status)
  const statusIndexB = statusOrder.indexOf(taskB.status)

  return statusIndexA - statusIndexB
}

const getCssClassForEmployeeBadge = (employment_type = null) => {
  switch (employment_type) {
    case 1: return 'bg-primary'; break;
    case 2: return 'bg-info'; break;
    default: return 'bd-secondary'
  }
}

const getCssClassForEmployeeListGroup = (employment_type = null) => {
  switch (employment_type) {
    case 1: return 'list-group-item-primary'; break;
    case 2: return 'list-group-item-info'; break;
    default: return ''
  }
}
</script>

<template>
  <table
    v-show="Object.keys(tasks).length"
    class="table table-bordered"
  >
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Title</th>
        <th scope="col">Status</th>
        <th scope="col">Employees</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="task in tasks" :key="task.id">
        <th scope="row">{{ task.id }}</th>
        <td>{{ task.title }}</td>
        <td>{{ statusesTask?.[task.status] }}</td>
        <td>
          <span
            v-for="employeeTask in task?.employeesTask"
            :key="task.id"
            class="m-1 badge"
            :class="getCssClassForEmployeeBadge(employeeTask?.employee?.employment_type)"
          >
            {{ `${employeeTask?.employee?.title} (${typesEmployee?.[employeeTask?.employee?.employment_type]})` }}
          </span>
        </td>
        <td>
          <a href="#" @click.prevent="openModal(task)" data-toggle="modal" data-target="#formTaskModal">
            <svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"/></svg>
          </a>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- modal -->
  <div class="modal modal-lg fade" id="formTaskModal" tabindex="-1" role="dialog" aria-labelledby="formTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formTaskModalLabel">Редактировать задачу</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submitForm">
            <input type="hidden" v-model="formTask.id">
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" id="title" class="form-control" v-model="formTask.title" required>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select id="status" class="form-control" v-model="formTask.status" required>
                <option v-for="(statusTask, idx) in statusesTask" :key="idx" :value="idx">
                    {{ statusTask }}
                </option>
              </select>
            </div>
            <div class="mb-3">
              <label for="curr_employee_id" class="form-label">Employee</label>
              <select id="curr_employee_id" class="form-control" v-model="formTask.curr_employee_id">
                <option
                  v-for="(employee, idx) in employees"
                  v-show="!(formTask?.employees.map(item => item.id).includes(employee?.id))"
                  :key="employee?.id"
                  :value="employee?.id"
                >
                  {{ `${employee?.title} (${typesEmployee?.[employee?.employment_type]})` }}
                </option>
              </select>
              <button
                class="btn btn-outline-secondary mt-2"
                @click.prevent="addEmployee"
                :disabled="!formTask.curr_employee_id"
              >
                Добавить
              </button>
            </div>
            <div class="mb-3">
              <ul
                v-show="Object.keys(formTask?.employees).length"
                class="list-group my-2"
              >
                <li
                  v-for="(employee, idx) in formTask?.employees" :key="employee?.id"
                  class="list-group-item d-flex justify-content-between align-items-center"
                  :class="getCssClassForEmployeeListGroup(employee?.employment_type)"
                >
                  {{ `${employee?.title} (${typesEmployee?.[employee?.employment_type]})` }}
                  <button
                    type="button"
                    class="btn-close"
                    @click.prevent="deleteEmployee({...employee})"
                  ></button>
                </li>
              </ul>
            </div>
            <div class="mb-3">
              <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
