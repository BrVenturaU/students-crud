<template>
    <div class="container">
        <section>
        <!-- Boton para abrir el modal -> CreateStudent -->
        <button 
            class="btn btn-success"     
            data-toggle="modal" 
            data-target="#createModal" >
            <feather type="plus" class="align-middle" size="20"></feather>
            Crear/Agregar
        </button>

            <!-- Start Modal -->
        <div 
            class="modal fade" 
            id="createModal"  
            tabindex="-1" 
            aria-labelledby="createModalLabel" 
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Encabezado del modal -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="createModalLabel">Crear/Agregar Estudiante</h4>
                        <button 
                            type="button" 
                            class="close" 
                            data-dismiss="modal" 
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Cuerpo/Contenido del Modal -->
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col">
                                    <label for="name">Nombre</label>
                                    <input 
                                        id="name"
                                        type="text" 
                                        class="form-control" 
                                        placeholder="Nombre">
                                </div>
                                <div class="col">
                                    <label for="lastname">Apellido</label>
                                    <input 
                                        id="lastname"
                                        type="text" 
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
                                        class="form-control" >
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">                                          
                                    <label for="inputState">Genero</label>
                                    <select id="inputState" class="form-control">
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
                            data-dismiss="modal">
                            Cancelar
                        </button>
                        <button 
                            type="button" 
                            class="btn btn-primary">
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

}
</script>

<style scoped>

</style>