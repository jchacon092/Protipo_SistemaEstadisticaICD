<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Responder Encuesta                      
                    </div>
                    <template v-if="cambio==0">
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Departamento</th>
                                    <th>año</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                    <select class="form-control" v-model="departamento">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="indice in arrayIndice" :key="indice.id" :value="indice.id" v-text="indice.departamento"></option>
                                    </select> 
                                    </td> 
                                    <td>
                                    <select class="form-control" v-model="anio">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="indice in arrayIndice" :key="indice.id" :value="indice.id" v-text="indice.anio"></option>
                                    </select> 
                                    </td> 
                                </tr>                                
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary" @click="cambiartemplate()">Hacer Encuesta</button>
                    </div>
                    </template>
                    <template v-if="cambio==1">
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Pregunta</th>
                                    <th>Respuesta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="pregunta in arrayPregunta" :key="pregunta.id">
                                    <td v-text="pregunta.pregunta"></td> 
                                    <td>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Ingrese la respuesta aqui">                                        
                                    </div>    
                                    </td>                                                                                                   
                                </tr>                                
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary" @click="cambiartemplate()">Regresar</button>
                        <button type="button" class="btn btn-primary" @click="registrarPilar()">Guardar</button>
                    <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
        </main>
</template>

<script>
    export default {
        data (){
            return {
                id: 1,
                cambio: 0,
                idpregunta : 1,
                nombre_indicador : '',
                pregunta : '',
                indice: '',
                ponderacion :0,
                condicion_organizacion: 0,
                nombre: '',
                arrayPregunta : [],
                arrayIndice : [],
                modal : 0,
                modal2 :0,
                tituloModal : '',
                tipoAccion : 0,
                errorPregunta : 0,
                errorMostrarMsjPregunta : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'pregunta',
                buscar : '',
                arrayIndicador :[]
            }
        },
       
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {

            listarIndice(page,buscar,criterio){
                let me=this;
                var url= '/indice?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayIndice = respuesta.indices.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiartemplate(){

            if (this.cambio==0) {
                this.cambio=1;
            } 
            else{
                this.cambio=0;
            }
            },
            listarPregunta(page,buscar,criterio){
                let me=this;
                var url= '/pregunta?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPregunta = respuesta.preguntas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectIndicador(){
                let me=this;
                var url= '/indicador/selectIndicador';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayIndicador = respuesta.indicadores;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarPregunta(page,buscar,criterio);
            },
            registrarPilar(){
                
                let me = this;

                axios.post('/respuesta/registrar',{
                    'id': this.id,
                    'ponderacion': this.ponderacion,
                    'idpregunta': this.idpregunta
                }).then(function (response) {
                    me.cerrarModal();
                    
                }).catch(function (error) {
                    console.log(error);
                });
            },
            registrarPregunta2(){
                if (this.validarPregunta()){
                    return;
                }
                
                let me = this;

                axios.post( '/pregunta/registrar',{
                    'pregunta':this.pregunta,
                    'idindicador': this.idindicador,
                    'condicion_organizacion': 1,
                    'nombre': this.nombre,
                }).then(function (response) {
                    me.cerrarModal2();
                    me.listarPregunta(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPregunta2(){
               if (this.validarPregunta()){
                    return;
                }
                
                let me = this;

                axios.put('/pregunta/actualizar',{ 
                    'pregunta':this.pregunta,
                    'idindicador': this.idindicador,
                    'condicion_organizacion': 1,
                    'nombre': this.nombre,
                    'id': this.pregunta_id
                }).then(function (response) {
                    me.cerrarModal2();
                    me.listarPregunta(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            actualizarPregunta(){
               if (this.validarPregunta()){
                    return;
                }
                
                let me = this;

                axios.put('/pregunta/actualizar',{ 
                    'pregunta':this.pregunta,
                    'idindicador': this.idindicador,
                    'condicion_organizacion': this.condicion_organizacion,
                    'nombre': this.nombre,
                    'id': this.pregunta_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPregunta(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarIndicador(id){
               swal({
                title: 'Esta seguro de desactivar esta pregunta?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put( '/pregunta/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPregunta(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarIndicador(id){
               swal({
                title: 'Esta seguro de activar esta pregunta?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/pregunta/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPregunta(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarPregunta(){
                this.errorPregunta=0;
                this.errorMostrarMsjPregunta=[];
                if (!this.pregunta) this.errorMostrarMsjPregunta.push("La pregunta no debe de estar vacia.");
                if (this.idindicador==0) this.errorMostrarMsjPregunta.push("Seleccione un indicador.");

                if (this.errorMostrarMsjPregunta.length) this.errorPregunta = 1;

                return this.errorPregunta;
            },
            validarIndice(){
                this.errorPregunta=0;
                this.errorMostrarMsjPregunta=[];
                if (!this.pregunta) this.errorMostrarMsjPregunta.push("La pregunta no debe de estar vacia.");
                if (this.idindicador==0) this.errorMostrarMsjPregunta.push("Seleccione un indicador.");

                if (this.errorMostrarMsjPregunta.length) this.errorPregunta = 1;

                return this.errorPregunta;
            },            
        },
        mounted() {
            this.listarIndice(1,this.buscar,this.criterio);
            this.listarPregunta(1,this.buscar,this.criterio);
            
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>