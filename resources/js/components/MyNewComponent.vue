<template>
   <div>
     <span class="time shadow" v-text="date"></span>
              <span class="time " v-text=" currentTime"></span>
   </div>
    					
                     
</template>

<script>
	import chartjs from 'chart.js'
    export default {
      name: "clock",
    	data:  function() {
    		return{
		    	message: 'Current Time:',
		    	currentTime: null,
          time: null,
          date: null,
          
		    
			}	
		},
        mounted() {
            console.log('Component mounted.')

        },
        methods: {
        	
        	updateCurrentTime() {
		      this.currentTime = moment().format('LTS');
          this.currentTime = moment().format('LTS');
          this.date = moment().format("MMM Do YY");


		    },
        updateTime() {
          var week = ['Domingo', 'Lunes', 'Martes', 'Miécoles', 'Jueves', 'Viernes', 'Sabado'];
          var cd = new Date();
          this.time = this.zeroPadding(cd.getHours(), 2) + ':' + this.zeroPadding(cd.getMinutes(), 2) + ':' + this.zeroPadding(cd.getSeconds(), 2);
          this.date = week[cd.getDay()] + ' ' +this.zeroPadding(cd.getDate(), 2) + '/' + this.zeroPadding(cd.getMonth()+1, 2) + '/' + this.zeroPadding(cd.getFullYear(), 4);
      },
        zeroPadding(num, digit) {
            var zero = '';
            for(var i = 0; i < digit; i++) {
                zero += '0';
            }
            return (zero + num).slice(-digit);
        }

        },
        created() {
		    this.currentTime = moment().format('LTS');
		    setInterval(() => this.updateCurrentTime(), 1 * 1000);
        setInterval(()=>this.updateTime(), 1 *1000);
        
		},
		ready: function () {
        this.updateTime();
	    	this.updateCurrentTime();

        

		}


    }

    
</script>