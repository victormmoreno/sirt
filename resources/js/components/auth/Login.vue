<template>
	<div>
		<div class="valign">
        	<div class="row">
          		<div class="col s12 m6 l6 offset-l3 offset-m3">
            		<div class="card white darken-1">
              			<div class="card-content ">
              				<span class="card-title center-align">
			                  	<div class="row">
			                    	<div class="col s12 m12 l12">
			                      		
			                      		<router-link to="/" >
			                        		<img  width="200px" height="60px" src="" class="chapter-title responsive-img" v-bind:src="logo"></img>
			                      		</router-link>
			                    	</div>
			                    	<br>
			                    	<br>
			                    	<div class="col s12 m12 l12">
			                      		<div class="divider" style="background:#008981;"></div>
			                      		
			                      		<router-link to="/" class="footer-text left-align">
			                      			<i class="material-icons arrow-l">arrow_back</i>
			                      			INICIAR SESIÓN
			                      		</router-link>
			                    	</div>
			                  	</div>
			                </span>
			                <div class="row">
			                  	<form  class="col s12" @submit.prevent="authenticate">
			                    	<div class="input-field col s12">
			                      		<i class="material-icons prefix">mail</i>
			                      		<input  type="email" class="validate" v-model="form.email" placeholder="Ingresa tu correo">
			                      		<label for="email" class="active">Correo</label>
			                    	</div>
			                    	<div class="input-field col s12">
			                      		<i class="material-icons prefix">lock_outline</i>
			                      		<input  type="password" class="validate"  v-model="form.password" placeholder="Ingresa tu contraseña">
			                      		<label for="password" class="active">Contraseña</label>
			                   		</div>
			                    	<div class="col s12 center-align m-t-sm">
			                      		<button type="submit"  class="waves-effect waves-light btn center-align"><i class="material-icons left">fingerprint</i> Ingresar</button>
			                      		<!-- <input type="submit" value="Ingresar"> -->
			                      		<br><br>
			                      		<a href="" class="m-t-sm  darken-text text-darken-2 center-align" style="color: #008987">Olvidé mi contraseña</a>
			                    	</div>
			                  	</form>
			                </div>
              			</div>
              		</div>
              	</div>
            </div>
        </div>
	</div>
</template>
 <script>
 	import {login} from '../../helpers/auth';
 	export default {
 		name: "login",
 		 data() {
            return {
            	logo: 'img/logonacional_Negro.png',
                form: {
                    email: '',
                    password: ''
                },
                error: null
            };
        },
        methods: {
            authenticate() {
                this.$store.dispatch('login');
                login(this.$data.form)
                    .then((res) => {
                        this.$store.commit("loginSuccess", res);
                        this.$router.push({path: '/'});
                    })
                    .catch((error) => {
                        this.$store.commit("loginFailed", {error});
                    });
            }
        },
        computed: {
            authError() {
                return this.$store.getters.authError;
            }
        }
 	}
 </script>

 