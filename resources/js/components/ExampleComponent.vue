<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Example Component</div>

                <div class="card-body">
                    I'm an example component.
                    <button class="btn btn-success" @click="testApi">Test Api <feather class="align-middle" type="external-link" size="20"></feather></button>
                    <button class="btn btn-primary" @click="laravelApi">Laravel Api <feather class="align-middle" type="link" size="20"></feather></button>

                    <pre class="text-muted">{{test}}</pre>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                test:{}
            }
        },

        methods: {
            async testApi(){
                let vm = this;
                let response = await axios.get("https://jsonplaceholder.typicode.com/todos/1");
                console.log(response);
                vm.test = response.data;
            },
            async laravelApi(){
                let vm = this;
                let response = await axios.get("students/1");
                console.log(response);
                vm.test = response.data;
            }
        },
    }
</script>
