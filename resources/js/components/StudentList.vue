<template>
<div>
    <div class="mb-4 custom-control custom-switch">
        <input class="custom-control-input" type="checkbox" name="order" id="order" v-model="order" @change="orderStudents()">
        <label class="custom-control-label" for="order">{{order == 1 ? 'Ascendente' : 'Descendente'}}</label>
    </div>
    
    <div class="row justify-content-center">    
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
                    <button href="#" class="shadow btn btn-success" data-toggle="modal" @click="showModal(`#${student.name}-${student.id}`)"><feather type="eye" class="align-middle" size="20"></feather></button>
                    <ShowStudent :student="student" />
                    <button href="#" class="shadow btn btn-danger"><feather type="trash-2" class="align-middle" size="20"></feather></button>
                </div>
            </div>
        </div>
        <nav>
            <ul class="pagination">
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
</template>

<script>
import ShowStudent from './ShowStudent.vue';
export default {
    components:{
        ShowStudent
    },
    created(){
        this.get();
    },
    data() {
        return {
            students: [],
            order: true,
            pagination:{total:0, current_page:0, per_page:0, last_page:0, from:0, to:0},
            offset: 3
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
            await this.get(this.pagination.current_page);
        },
        async get(page=1){
            let vm = this;
            let response = (await axios.get(`students?page=${page}&order=${vm.order}`)).data;
            vm.pagination = {total:response.total, current_page:response.current_page, per_page:response.per_page, last_page:response.last_page, from:response.from, to:response.to};
            let data = response.data;
            this.students = data;
        },
        delete(id){
            console.log(id);
        },
        showModal(id){
            $(id).modal('show');
        },
        changePage(page){
            this.pagination.current_page = page;
            this.get(page);
        },
    },
}
</script>
<style scoped>

</style>