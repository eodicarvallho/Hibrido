<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="author" content="">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"> </script>
<script src="/qs.js"></script>

</head>

<body>

<div id="app">
  <h4 class="head" style="text-align:center;"> Cadastro de clientes da hibrido</h4>
  <div class="container">

    <table class="table-responsive bordered highlight centered hoverable z-depth-2" v-show="clientes.length">
      <thead>
        <tr>
          <th v-for="column in columns">
            {{column}}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cliente in clientes">
          <td>{{cliente.id}}</td>
          <td>
            {{cliente.nome}}
          </td>
          <td>
            {{cliente.cpf}}
          </td>
          <td>
            {{cliente.email}}
          </td>
          <td>
            {{cliente.telefone}}
          </td>
          <td style="width: 18%;">
            <a href="#modal" @click="edit(cliente.id)" class="btn waves-effect waves-light yellow darken-2"><i class="material-icons">edit</i>
            </a>
            <a href="#!" @click="deplete(cliente.id)" class="btn waves-effect waves-light red darken-2"><i class="material-icons">delete</i>
            </a>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <div class="input-field">
              <input placeholder="Nome do cliente" ref="nome" v-model="input.nome" id="nome" type="text">
              <label for="nome">Nome</label>
            </div>
          </td>
          <td>
            <div class="input-field">
              <input placeholder="Placeholder" v-model="input.cpf" id="cpf" type="text">
              <label for="cpf">CPF</label>
            </div>
          </td>
          <td>
            <div class="input-field">
              <input placeholder="Placeholder" v-model="input.email" id="email" type="text">
              <label for="email">Email</label>
            </div>
          </td>
          <td>
            <div class="input-field">
              <input placeholder="Placeholder" v-model="input.telefone" id="telefone" type="text">
              <label for="telefone">Telefone</label>
            </div>
          </td>
          <td><a href="#!" @click="add" class="btn btn-waves green darken-2"><i class="material-icons">add</i></a></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div id="modal" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4 class="center-align">Editar</h4>
      <p class="center-align">Editar Cliente</p>
      <div class="row">
        <form class="col s12">
          <div class="row">
            <div class="input-field col s6">
              <input placeholder="id" id="eid" type="hidden" v-model="editInput.id">
              <input placeholder="Nome" id="enome" type="text" v-model="editInput.nome">
              <label for="nome">Nome</label>
            </div>
            <div class="input-field col s6">
              <input placeholder="CPF" id="ecpf" type="text" v-model="editInput.cpf">
              <label for="cpf">CPF</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s6">
              <input placeholder="Email" id="eemail" type="text" v-model="editInput.email">
              <label for="email">Email</label>
            </div>
            <div class="input-field col s6">
              <input placeholder="Telefone" id="etelefone" type="text" v-model="editInput.telefone">
              <label for="telefone">Telefone</label>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
      <a href="#!" @click="update" class="btn waves-effect waves-light"><i class="material-icons">edit</i></a>
    </div>
  </div>
</div>
</body>
<script>
const config = {
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded'
  }
}

function verificaNome($data){
   nome = $data
   
   if(nome.match(/^[a-zA-Z\u00C0-\u017F´]+\s+[a-zA-Z\u00C0-\u017F´]{0,}$/) && nome.trim().split(' ').length == 2){
   }else{
       alert("nome INVÁLIDO");
   }
}

function verificaEmail($data){
  var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);

  var email = $data

  if( email == '' || !er.test(email) ) { alert('Preencha o campo email corretamente'); return false; }
}
	
new Vue({
  el: '#app',
  data: {
    columns: ['ID', 'Nome', 'CPF', 'email', 'Telefone', 'Acoes '],
    clientes: [],
    bin: [],
    input: {
      nome: "Diego",
      cpf: "06012548785",
      email: "diegocarvalho.dev@gmail.com",
      telefone: "73988556655"
    },
    editInput: {
      nome: "",
      cpf: "",
      email: "",
      telefone: ""
    }
  },
  mounted () {
    axios.get('http://localhost:8000/clientes').then((response) => {
    		this.clientes = response.data.mensagem,
    		console.log(response.data['status'])
    		var status = response.data['status'];
    		
    if (status == "Erro") {
    	axios.get('http://localhost:8000/').then((response) => {
    		this.clientes = response.data,
    		console.log(response.data)
    		})
		}
		})

  },
    //
  methods: {

    add: function() {    
      const requestBody = {
        nome: this.input.nome,
        cpf: this.input.cpf,
        email: this.input.email,
        telefone: this.input.telefone
      }
      
      url = "/clientes/addcliente"
      verificaNome(this.input.nome);
      verificaEmail(this.input.email);
      axios.post(url, Qs.stringify(requestBody), config)
      .then((result) => {
          if(result.data['status'] == "Erro"){
          	alert(result.data['mensagem'])
          } else {
            //this.clientes.push({
            //nome: this.input.nome,
            //cpf: this.input.cpf,
            //email: this.input.email,
            //telefone: this.input.telefone
            //});
            window.location.reload();
      }
          ///console.log(result.data['status'])
          //alert(result.data);
      }).catch((err) => {
          console.log(err)
      })

      for (var key in this.input) {
        this.input[key] = '';
      }
      this.$refs.nome.focus();
    },
    //function to handle data edition
    edit: function(id) {
     axios
       .get('http://localhost:8000/cliente/'+id).then((response) => {
    	  this.data = response.data,
    	  console.log(this.data);
	      this.editInput.id = this.data.id;
	      this.editInput.nome = this.data.nome;
	      this.editInput.cpf = this.data.cpf;
	      this.editInput.telefone = this.data.telefone;
	      this.editInput.email = this.data.email;
    	  })
    },
    //function to restore data
    restore: function(index,id) {
      this.clientes.push(this.bin[index]);
      this.bin.splice(index, id);
    },
    //function to update data
    update: function(){
       const requestBodyUpd = {
        nome: this.editInput.nome,
        cpf: this.editInput.cpf,
        email: this.editInput.email,
        telefone: this.editInput.telefone
      }
      
      console.log(requestBodyUpd);
      
      url = "/cliente/"+this.editInput.id;
          
     axios
       .post(url, Qs.stringify(requestBodyUpd), config).then((response) => {
    	  this.data = response,
    	  console.log(this.data);
            this.editInput.id = this.data.id;
            this.editInput.nome = this.data.nome;
            this.editInput.cpf = this.data.cpf;
            this.editInput.telefone = this.data.telefone;
            this.editInput.email = this.data.email;
            if(response.data['status'] == "Erro"){
          	alert(response.data['mensagem']);
          	window.location.reload();
            } else {
            	window.location.reload();
            }
    	  })
       for (var key in this.editInput) {
        this.editInput[key] = '';
      }
      //
    },
    //function to defintely delete data 
    deplete: function(id) {
      url = "/cliente/"+id;
      axios.delete(url, config)
      .then((result) => {
          if(result.data['status'] == "Erro"){
          	alert(result.data['mensagem'])
          } else {
            window.location.reload();
      }
          ///console.log(result.data['status'])
          //alert(result.data);
      }).catch((err) => {
          console.log(err)
      })
    }
  }
});

$(function() {
  //initialize modal box with jquery
  $('.modal').modal();
});
</script>
</html>





