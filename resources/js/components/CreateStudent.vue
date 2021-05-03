<template>

    <div class="container">
    <div 
        class="modal fade" 
        :id="modalId"  
        tabindex="-1" 
        aria-labelledby="createModalLabel" 
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Encabezado del modal -->
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel">{{editStudent != undefined 'Editar' : 'Crear'}} Estudiante</h4>
                </div>
                <!-- Cuerpo/Contenido del Modal -->
                <div class="modal-body">
                    <form @submit.prevent="addStudent()" class="needs-validation">
                        <div class="row">
                            <div class="col">
                                <label for="name">Nombre</label>
                                <input 
                                    id="name"
                                    type="text"
                                    v-model="student.name"
                                    required 
                                    class="form-control" 
                                    placeholder="Nombre">
                            </div>
                            <div class="col">
                                <label for="lastname">Apellido</label>
                                <input 
                                    id="lastname"
                                    type="text"
                                    v-model="student.last_name" 
                                    required
                                    class="form-control" 
                                    placeholder="Apellido">
                            </div>
                        </div>
                        <div class="mt-3 row">
                            <div class="col">
                                <label for="date">Fecha de nacimiento</label>
                                <input 
                                    id="date"
                                    type="date"
                                    v-model="student.birth_date"
                                    required
                                    class="form-control" >
                            </div>
                        </div>
                        <div class="mt-3 row">
                            <div class="col">                                          
                                <label for="inputState">Genero</label>
                                <select 
                                    id="inputState"
                                    v-model="student.gender" 
                                    required
                                    class="form-control">
                                    <option selected>Seleccionar...</option>
                                    <option value="F">Femenino</option>
                                    <option value="M">Masculino</option>
                                </select>       
                            </div>
                            <div class="col">
                                <label for="code">Codigo</label>
                                <input 
                                    id="code"
                                    type="text"
                                    v-model="student.code"
                                    required 
                                    class="form-control" 
                                    placeholder="Codigo de estudiante">
                            </div>
                        </div>
                    </form>
                </div>    
                    <!-- Pie/Footer del Modal -->
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary" 
                            data-dismiss="modal"
                            @click="closeModal();">
                            Cancelar
                        </button>
                        <button 
                            type="button" 
                            class="btn btn-primary"
                            data-dismiss="modal"
                            @click="addStudent()">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    name: 'CreateStudent',
    props:{
        modalId: String,
        editStudent: Object
    },
    created(){
        let vm = this;
        if(vm.editStudent != undefined){
            vm.student.id = vm.editStudent.id;
            vm.student.name = vm.editStudent.name;
            vm.student.last_name = vm.editStudent.last_name;
            vm.student.birth_date = vm.editStudent.birth_date;
            vm.student.gender = vm.editStudent.gender;
            vm.student.code = vm.editStudent.code;
        }
    },
    data () {
        return {
            student: {
                name: '',
                last_name:'',
                birth_date:'',
                gender:'F',
                code:''
            }
        }
    },
    methods: {
        async addStudent(){
            let vm = this;
            try {
                let response = await axios.post('students/', vm.student);
                let data = response.data;
                alert(data.message);
                vm.$emit('onChangeStudent');
            }
            catch(e) {
                console.log(e.message)
            }

        },
        closeModal(){
            this.modal=0
        }
    }

}
</script>

<style scoped>

</style>