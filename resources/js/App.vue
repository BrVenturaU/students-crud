<template>
    <div class="container mt-5">
        <h1 class="mb-4">Listado de estudiantes</h1>
        <StudentList />
        <CreateStudent/>
        <EditStudent/>
    </div>
</template>

<script>
import StudentList from './components/StudentList.vue'
import CreateStudent from './components/CreateStudent.vue'
import EditStudent from './components/EditStudent.vue'

    export default {
        components:{
            StudentList,
            CreateStudent,
            EditStudent
        }
    }
</script>
