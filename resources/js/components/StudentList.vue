<template>
<div>
    <!-- Boton para abrir el modal -> CreateStudent -->
    <button 
        class="mb-2 btn btn-success"     
        data-toggle="modal" 
        data-target="#modal-create" >
        <feather type="plus" class="align-middle" size="20"></feather>
        Crear/Agregar
    </button>
    <CreateStudent :modalId="'modal-create'"/>
    <form class="mb-4">
        <div class="form-row align-items-center">
            <div class="col col-sm-6">
                <input type="text" class="form-control" placeholder="Código..." v-model="code">
            </div>
            <div class="col">
                <select @change="onChangePerPage" class="form-control" v-model="perPage">
                    <option>4</option>
                    <option>8</option>
                    <option>16</option>
                    <option>32</option>
                </select>
            </div>
            <div class="col">
                <div class="custom-control custom-switch">
                    <input class="custom-control-input" type="checkbox" name="order" id="order" v-model="order" @change="orderStudents()">
                    <label class="custom-control-label" for="order">{{order == 1 ? 'Ascendente' : 'Descendente'}}</label>
                </div>
            </div>
            <div class="col col-sm-3">
                <nav v-if="pagination.total > 0">
                    <ul class="pagination justify-content-end">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item" v-for="(page, index) of pagesNumber" v-bind:class="[page == isActive ? 'active' : '']" :key="index">
                            <a class="page-link" href="#" @click.prevent="changePage(page)">{{page}}</a>
                        </li>

                        <li class="page-item"  v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </form>
    
    <div class="text-center" v-if="isLoading">
        <feather class="text-muted" type="loader" animation="spin" animation-speed="fast" size="4rem"></feather>
    </div>
    <div class="mb-3 row" v-else>    
        <div class="col-sm-3" v-for="student of students" :key="student.id">
            <div class="mb-4 shadow card">
                <div class="card-body">
                    <h3 class="card-title">{{student.full_name}}</h3>
                    <p class="card-text">Datos del estudiante:</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Genero: {{student.gender == 'F' ? 'Femenino' : 'Masculino'}}</li>
                    <li class="list-group-item">Edad: {{student.age}}</li>
                </ul>
                <div class="card-body">
                    <button class="shadow btn btn-success" data-toggle="modal" @click="showModal(`#modal-${student.id}`)"><feather type="eye" class="align-middle" size="20"></feather></button>
                    
                    <button class="text-white btn btn-warning" @click="showModal(`#modal-edit-${student.id}`)">
                        <feather type="edit" class="align-middle" size="20"></feather>
                    </button>
                    
                    <button class="shadow btn btn-danger" @click="deleteById(student.id)"><feather type="trash-2" class="align-middle" size="20"></feather></button>

                    <button 
                        class="btn btn-warning"     
                        data-toggle="modal" 
                        data-target="#editModal" >
                        <feather type="edit" class="align-middle" size="20"></feather>
                    </button>
                    
                </div>
            </div>
            <ShowStudent :student="student" />
            <CreateStudent :editStudent="student" :modalId="`modal-edit-${student.id}`" @onChangeStudent="get()" />
            <div class="bottom-0 right-0 p-3 position-fixed" style="z-index: 5; right: 0; bottom: 0;">
                <div :id="`toast-${student.id}`" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="600">
                    <div class="toast-header">
                        <feather type="check-circle" class="mr-2 align-middle text-success" size="20"></feather>
                        <strong class="mr-auto">App</strong>
                        <small>Now</small>
                        <button type="button" class="mb-1 ml-2 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        {{message}}
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
</template>

<script>
import ShowStudent from './ShowStudent.vue';
import CreateStudent from './CreateStudent.vue';
export default {
    components:{
        ShowStudent,
        CreateStudent
    },
    created(){
        let vm = this;
        vm.debouncedGet = _.debounce(vm.get, 500);
        vm.get();
    },
    data() {
        return {
            students: [],
            order: true,
            code: '',
            isLoading: true,
            message: '',
            perPage: 4,
            pagination:{total:0, current_page:0, per_page:0, last_page:0, from:0, to:0},
            offset: 2
        }
    },
    watch:{
        code: function(){
            let vm = this;
            vm.isLoading = true;
            vm.debouncedGet();
        }
    },
    computed:{
        isActive(){
            return this.pagination.current_page;
        },
        pagesNumber(){
            if(!this.pagination.to)
                return [];

            var from = this.pagination.current_page - this.offset;
            if(from < 1)
                from = 1;
            var to = from + (this.offset*2);
            if(to >= this.pagination.last_page)
                to = this.pagination.last_page;

            var pages = [];
            while(from <= to){
                pages.push(from);
                from++;
            }
            return pages;
        }
    },
    methods: {
        async orderStudents(){
            await this.get();
        },
        async get(){
            let vm = this;
            vm.isLoading = true;
            let page = this.pagination.current_page;
            let url = `students?code=${vm.code}&page=${page}&perPage=${vm.perPage}&order=${vm.order}`;
            let response = (await axios.get(url)).data;
            vm.pagination = {total:response.total, current_page:response.current_page, per_page:response.per_page, last_page:response.last_page, from:response.from, to:response.to};
            let data = response.data;
            this.students = data;
            vm.isLoading = false;
        },
        async deleteById(id){
            let response = await axios.delete(`students/${id}`);
            let data = response.data;
            this.message = data.message;
            this.showToast(`#toast-${id}`);
            _.delay(this.get, 600);
        },
        showModal(id){
            $(id).modal('show');
        },
        showToast(id){
            $(id).toast('show');
        },
        changePage(page){
            this.pagination.current_page = page;
            this.get();
        },
        onChangePerPage(){
            this.get();
        }
    },
}
</script>
<style scoped>

</style>