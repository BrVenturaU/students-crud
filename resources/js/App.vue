<template>
    <div class="container mt-5">
        <h1 class="mb-4">Listado de estudiantes</h1>
        <StudentList />
        <Create/>
    </div>
</template>

<script>
import StudentList from './components/StudentList.vue'
import Create from './components/CreateStudent.vue'
    export default {
        components:{
            StudentList,
            Create
        }
    }
</script>
