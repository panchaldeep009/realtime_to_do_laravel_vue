<template>
<div class="col-8">
    <span class="text-center m-8">Tasks</span>
    <p class="card-text text-danger">{{error}}</p>
    <form class="input-group mb-3" @submit.prevent="newTask">
        <input v-model="new_tesk" type="text" class="form-control" placeholder="New Task" aria-label="New Task" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Add</button>
        </div>
    </form>
    <ul class="list-group">
        <li class="list-group-item" 
            v-for="(task) in tasks" :key="task.to_do_id">
            <div class="d-flex justify-content-between align-items-center">
                <strong v-if="!edit_tasks_node.includes(task.to_do_id)" >{{task.to_do_task}}</strong>
                <form class="input-group" 
                    v-if="edit_tasks_node.includes(task.to_do_id)" 
                    @submit.prevent="editTask(task.to_do_id)">
                    <input
                        v-model="edit_tesk_field.find(({to_do_id}) => task.to_do_id).to_do_task"
                        type="text" class="form-control" 
                        placeholder="Edit Task" aria-label="Edit Task" 
                        aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-warning" type="submit">Save</button>
                    </div>
                </form>
                
                <div class="d-flex">
                    <button type="button" 
                        @click.prevent="edit_tasks_node.push(task.to_do_id)"
                        v-if="!edit_tasks_node.includes(task.to_do_id)" 
                        class="btn btn-small btn-outline-primary">Edit</button>
                    <button type="button" 
                        @click.prevent="unEditTask(task.to_do_id)"
                        v-if="edit_tasks_node.includes(task.to_do_id)" 
                        class="btn btn-small btn-outline-danger">Cancel</button>
                </div>
            </div>
            <br/>   
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted">{{getUserName(task.to_do_user_id)}}</span>
                <button type="button" 
                    @click.prevent="deleteTask(task.to_do_id)"
                    v-if="edit_tasks_node.includes(task.to_do_id)" 
                    class="btn btn-small btn-danger">Delete</button>
            </div>
        </li>
    </ul>
</div>
</template>
<script>
import axios from 'axios';

export default {
    name: 'Tasks',
    props: ['tasks'],
    data(){
        return{
            new_tesk: "",
            edit_tasks_node: [],
            edit_tesk_field: [],
            error: "",
        }
    },
    methods: {
        newTask(){

            axios.post('/api/task', {
                task: this.new_tesk},
                { headers: { "X-CSRF": window.Laravel.csrfToken } })
            .then((response) => {
                if(response.status == 200){
                    this.error = "";
                } else {
                    this.error = response.data.error;
                }
            });
        },
        unEditTask(id){
            this.edit_tasks_node = (this.edit_tasks_node.filter((i) => i != id))
        },
        editTask(id){
            axios.put('/api/task', {
                task: this.edit_tesk_field.find(({to_do_id}) => id).to_do_task,
                task_id: id },
                { headers: { "X-CSRF": window.Laravel.csrfToken } })
            .then((response) => {
                if(response.status == 200){
                    this.error = "";
                    this.unEditTask(id);
                } else {
                    this.error = response.data.error;
                }
            });
        },
        deleteTask(id){
            axios.delete('/api/task', { 
                headers: { "X-CSRF": window.Laravel.csrfToken }, 
                data: {task_id: id}
            })
            .then((response) => {
                if(response.status == 200){
                    this.error = "";
                    this.unEditTask(id);
                } else {
                    this.error = response.data.error;
                }
            });
        },
        getUserName(id){
            const users = [ this.$root.user, ...this.$root.users ];
            return users.find(({to_do_user_id}) => id == to_do_user_id)['to_do_user_name'];
        }
    },
    watch: {
        tasks(){
            this.tasks.forEach((task) => {
               if(!this.edit_tesk_field.find(({to_do_id}) => to_do_id == task.to_do_id)){
                   this.edit_tesk_field.push(task)
               }
            });
        }
    },

}
</script>
<style lang="sass" scoped>

</style>
