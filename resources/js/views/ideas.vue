<template>
	<div>
		<main class="mn-inner no-p">
		    <div class="content">
		      	<div class="row no-m-t no-m-b">
		       	 	<div class="col s12 m12 l12">
		       	 		<h5>
		       	 			<router-link to="/" class="footer-text left-align">
				            <i class="material-icons arrow-l">arrow_back</i>
				          	</router-link> Ideas de Proyecto 
				     	</h5>
				        <div class="card stats-card">
				            <div class="card-content">
					            	<select id="miSelect" v-model="selected">
								    <option v-for="opt in options" v-bind:value="opt.value">
								      {{ opt.text }}
								    </option>
								  </select>
								  <span>Selected: {{ selected }}</span>
				            </div>
				        </div>
		       	 	</div>
		       	</div>
		    </div>
		</main>
	</div>
</template>
<script >
	export default {
		data:  function() {
    		return{
		    	selected: 'A',
    			options: [
      				{ text: 'One', value: 'A' },
      				{ text: 'Two', value: 'B' },
      				{ text: 'Three', value: 'C' }
    			]
			}	
		},
		mounted() {
            console.log('Component mounted.')
            $('#miSelect').select2({
			    placeholder: 'Select an option'
			});

        },
	}

	
	
</script>