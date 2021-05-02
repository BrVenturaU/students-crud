<template>
    <div class="container mt-5">
        <h1 class="mb-4">Listado de estudiantes</h1>
        <StudentList />
    </div>
</template>

<script>
import StudentList from './components/StudentList.vue'
    export default {
        components:{
            StudentList
        }
    }
</script>
