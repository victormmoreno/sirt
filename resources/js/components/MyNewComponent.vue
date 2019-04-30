<template>
    <div class="container">
        <div class="row">
            <div class="col s12 m10 l10">
                 <div class="row">
                    <div class="col s12 m6">
                      <div class="card ">
                        <div class="card-content ">
                          <span class="card-title">Card Title</span>
                          <p>I am a very simple card. I am good at containing small bits of information.
                          I am convenient because I require little markup to use effectively.</p>
                          julianondo
                        </div>
                        <div class="card-action">
                          	<button class="btn-floating btn-large waves-effect waves-light red" @click="makeAnAlert()">Alerta</button>
                        </div>
                        <h3 class="title is-3 shadow" v-text="message"></h3>
    					<p class="time shadow" v-text="currentTime"></p>
                      </div>
                    </div>
                    
                  </div>
            </div>
        </div>
    </div>
</template>

<script>
	import chartjs from 'chart.js'
    export default {
    	data:  function() {
    		return{
		    	message: 'Current Time:',
		    	currentTime: null,
		    
			}	
		},
        mounted() {
            console.log('Component mounted.')

        },
        methods: {
        	makeAnAlert: function () {
        		swal('hello word');
        		toastr.warning('hola soy developer');
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-center",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
        	},
        	updateCurrentTime() {
		      this.currentTime = moment().format('LTS');
		    },

        },
        created() {
		    this.currentTime = moment().format('LTS');
		    setInterval(() => this.updateCurrentTime(), 1 * 1000);
		},
		ready: function () {
	    	this.updateCurrentTime();
	    	updateTime();

		}
    }

    
</script>