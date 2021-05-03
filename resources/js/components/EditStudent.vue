<template>
    <div class="container">
        <section>
            <!-- Start Modal -->
        <div 
            class="modal fade" 
            id="editModal"  
            tabindex="-1" 
            aria-labelledby="editModalLabel" 
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Encabezado del modal -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="editModalLabel">Editar Estudiante</h4>
                        <button 
                            type="button" 
                            class="close" 
                            @click="openModal();"
                            data-dismiss="modal" 
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Cuerpo/Contenido del Modal -->
                    <div class="modal-body">
                        <form  class="needs-validation">
                            <div class="row">
                                <div class="col">
                                    <label for="name">Nombre</label>
                                    <input 
                                        id="name"
                                        type="text"
                                        v-model="students.name"
                                        required 
                                        class="form-control" 
                                        placeholder="Nombre">
                                </div>
                                <div class="col">
                                    <label for="lastname">Apellido</label>
                                    <input 
                                        id="lastname"
                                        type="text"
                                        v-model="students.last_name" 
                                        required
                                        class="form-control" 
                                        placeholder="Apellido">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="date">Fecha de nacimiento</label>
                                    <input 
                                        id="date"
                                        type="date"
                                        v-model="students.birth_date"
                                        required
                                        class="form-control" >
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">                                          
                                    <label for="inputState">Genero</label>
                                    <select 
                                        id="inputState"
                                        v-model="students.gender" 
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
                                        v-model="students.code"
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
                            >
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
        </section>
    </div>
</template>

<script>
export default {
    name: 'EditStudent',
    data () {
        return {
            students: {
                name: '',
                last_name:'',
                birth_date:'',
                gender:'',
                code:''
            },
        }
    },
    methods: {
        // async addStudent(){
        //     try {
        //         this.axios
        //         .post('students/' + this.students)
        //         .then(respose => (
        //             this.students = respose.data
        //         ))
        //         // const res = await axios.post('students/' + this.students);
        //         // this.students = res.data;
        //     }
        //     catch(e) {
        //         console.log(e.message)
        //     }
        //     this.students()
        // },
        openModal(){
            this.id=0,
            this.students.name='',
            this.students.last_name='',
            this.students.birth_date='',
            this.students.gender='',
            this.students.code=''
        },
        closeModal(){
            this.modal=0
        }
    }
}
</script>

<style>

</style>