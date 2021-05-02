<template>
<div>
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
    
    <div class="mb-3 row">    
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
        let vm = this;
        vm.debouncedGet = _.debounce(vm.get, 500);
        vm.get();
    },
    data() {
        return {
            students: [],
            order: true,
            code: '',
            perPage: 4,
            pagination:{total:0, current_page:0, per_page:0, last_page:0, from:0, to:0},
            offset: 3
        }
    },
    watch:{
        code: function(){
            let vm = this;
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
            let page = this.pagination.current_page;
            let url = `students?code=${vm.code}&page=${page}&perPage=${vm.perPage}&order=${vm.order}`;
            let response = (await axios.get(url)).data;
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