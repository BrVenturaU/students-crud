<template>
    <div class="modal fade" :id="`${student.name}-${student.id}`" tabindex="-1" :aria-labelledby="`${student.name}Modal`" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Estudiante: {{student.full_name}} - Código: {{student.code}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Código: {{student.code}}</li>
                        <li class="list-group-item">Genero: {{student.gender == 'F' ? 'Femenino' : 'Masculino'}}</li>
                        <li class="list-group-item">Edad: {{student.age}}</li>
                        <li class="list-group-item">Fecha de nacimiento: {{student.birth_date}}</li>
                        <li class="list-group-item">Fecha de creación: {{student.created_at}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:{
        student: Object
    }  
}
</script>
<style scoped>

</style>
