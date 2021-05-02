<template>
    <div class="row justify-content-center">
        <div class="col-sm-3" v-for="student of students" :key="student.id">
            <div class="mb-4 shadow card">
                <div class="card-body">
                    <h3 class="card-title">{{student.full_name}}</h3>
                    <p class="card-text">Datos del estudiante:</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Código: {{student.code}}</li>
                    <li class="list-group-item">Genero: {{student.gender == 'F' ? 'Femenino' : 'Masculino'}}</li>
                    <li class="list-group-item">Edad: {{student.age}}</li>
                    <li class="list-group-item">Fecha de nacimiento: {{student.birth_date}}</li>
                </ul>
                <div class="card-body">
                    <button href="#" class="shadow btn btn-success"><feather type="eye" class="align-middle" size="20"></feather></button>
                    <button href="#" class="shadow btn btn-danger"><feather type="trash-2" class="align-middle" size="20"></feather></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    created(){
        this.get();
    },
    data() {
        return {
            students: []
        }
    },
    methods: {
        async get(){
            let response = await axios.get('students');
            let data = response.data;
            this.students = data;
        }
    },
}
</script>
<style scoped>

</style>