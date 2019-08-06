<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap/dist/css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />
</head>
<body>

<div id="app">
	<div class="container">
		<h2 class="text-center">Listado de tabla usuarios con conexion a base de dados mysql usando el patron de arquitectura MVC</h2>

		<br>
		<button @click="abrirModal('agregar')" class="btn btn-primary">Nuevo</button>
		<br>
		<br>
			<table class="table table-bordered">
			<thead>
				<tr style="  background-color: black; color:white;">
					<th scope="col">#</th>
					<th scope="col">Nombre</th>
					<th scope="col">Edad</th>
					<th scope="col">Editar</th>
					<th scope="col">Eliminar</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="usuario in arrayUsuarios" :key="usuario.id">
					<td v-text="usuario.id"></td>
					<td v-text="usuario.nombre"></td>
					<td v-text="usuario.edad"></td>
					<td><button @click="abrirModal('',usuario)" class="btn btn-warning" >Editar</button></td>
					<td><button @click="eliminar(usuario.id)" class="btn btn-danger" >Eliminar</button></td>
				</tr>
			</tbody>
			</table>
	</div>

	   <!--inicio del modal-->
	   <b-modal v-model="show">
            <template  slot="modal-header">
              <!-- Emulate built in modal header close button action -->
              
               <h5>{{tituloModal}}</h5>
               <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                           <span aria-hidden="true">×</span>
                </button>
                
            </template>
            
          <b-container fluid>
            <div>
              <b-form>
              
                <b-form-group  class="mb-0 mt-0" label="Nombre:">
                  <b-form-input type="text" v-model="nombre"></b-form-input>
                  <hr>
                </b-form-group>

                <b-form-group  class="mb-0 mt-0" label="Edad:">
                  <b-form-input type="number" v-model="edad"></b-form-input>
                  <hr>
                </b-form-group>
               
                </b-form-group>
                  
              </b-form>
            </div>
          </b-container>

            <div slot="modal-footer" class="w-100">
              <b-button v-if="modoAgregar"
                variant="primary"
                class="float-right ml-2"
                @click="agregar"
              >Agregar
              <i class="fas fa-plus-circle"></i>
              </b-button>

              <b-button v-else
                variant="primary"
                class="float-right ml-2"
                @click="editar"
              >Editar
              <i class="fas fa-pen"></i>
              </b-button>

              <b-button
                variant="danger"
                class="float-right"
                @click="cerrarModal()"
              >
              Cerrar
              <i class="fas fa-times-circle"></i>
              </b-button>
            </div>

          </b-modal>
</div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="//unpkg.com/vue@latest/dist/vue.min.js"></script>
<script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
var app = new Vue({
    el : '#app',

    data() {
      return {
     
      	arrayUsuarios:[],
        id : 0,
        nombre : '',
        edad : '',
        modoAgregar : true,
        tituloModal : '',
        show : false
 
      }
    },
  	methods: {
	    listar(){
			let t=this;
			const url= '../controladores/controlador.php';
			axios.get(url).then(function (response){
			
				t.arrayUsuarios= response.data;
			
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		agregar(){
			const params = {
				nombre_a: this.nombre,
				edad : this.edad
			};
			
			axios.post('../controladores/controlador.php',params)
			.then((response)=>{ 
				if(response.data){
					Swal.fire(
						'Exito!',
						'Registro agregado.',
						'success'
					)
					this.listar();
          this.cerrarModal();
				}
				else
					alert("error al agregar");
			});		
		},
		editar(){
			const params = {
        id : this.id,
				nombre: this.nombre,
				edad : this.edad
			};
			
			axios.post('../controladores/controlador.php',params)
			.then((response)=>{ 
				if(response.data){
					Swal.fire(
						'Exito!',
						'Registro editado.',
						'success'
					)
					this.listar();
          this.cerrarModal();
				}
				else
					alert("error al editar");
			});		
		},
		eliminar(id){
			const params = {
				id_borrar: id,
			};
			

      Swal.fire({
        title: 'Estas seguro?',
        text: "Vas a a eliminar a este usuario!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
      }).then((result) => {
        if (result.value) {
          axios.post('../controladores/controlador.php',params)
          .then((response)=>{ 
            if(response.data){
                Swal.fire(
                'Borrado!',
                'Usuario eliminado con exito.',
                'success'
              )
              this.listar();
            }
            else
              alert("error al eliminar");
          });  
        }
      })
		},
		abrirModal(modo, usuario = []){
        this.show = true;
        if(modo == 'agregar')
        {
          this.tituloModal = 'AGREGAR';
        }
        else
        {
          this.modoAgregar = false;
          this.tituloModal= 'EDITAR';
          this.nombre = usuario.nombre;
          this.edad = usuario.edad;
          this.id = usuario.id;
        }
    },
    cerrarModal(){
        this.show = false;
        this.nombre = '';
        this.edad = '';
        this.modoAgregar = true;
    }
	}, 
  mounted() {
    this.listar();
  }
 })
</script>