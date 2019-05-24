<template>
	<div >
		<li class="hide-on-small-and-down" >
	        <a class="dropdown-button dropdown-right show-on-large"   :href="linkToNofitications" data-activates="dropdown1">
	            <i class="material-icons">
	                notifications_none
	            </i>
	            <span class="badge"  v-text="notifications.length" v-if="notifications.length"> </span>
	        </a>
	    </li>
		<ul  class="dropdown-content notifications-dropdown"   id="dropdown1">

            <li class="notificatoins-dropdown-container" v-if="notifications.length">
                <ul>
                    <li class="notification-drop-title">
                        Notificaciones
                    </li>
                    <li v-for="notification in notifications">
                        <a @click="markAsRead(notification)" :href="notification.data.link">
                            <div class="notification">
                                <div class="notification-icon circle cyan">
                                    <i class="material-icons">
                                        done
                                    </i>
                                </div>
                                <div class="notification-text">
                                    <p>
                                        <!-- <b>
                                            Alan Grey
                                        </b> -->
                                        <b v-text="notification.data.text"></b>
                                    </p>
                                    <span>
                                        7 min ago
                                    </span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <div class="divider"></div>
                    <li class="notification-drop-title center">
                       
                             <a href="/notificaciones">Ver más notificationes</a>
                        
                       
                    </li>
                    <li class="notification-drop-title center">
                       
                             <a @click="markAllAsRead" href="#">Marcar todo como leído</a>
                        
                       
                    </li>
                </ul>
            </li>
        </ul>
	</div>
	
</template>
<script>
	export default{
		data() {
            return {
            	notifications: [],
                
            };
        },
		mounted() {
			axios.get('notificaciones').then(res =>{
				// console.log(res.data);
				this.notifications = res.data;
			})
		},
		methods: {
			markAsRead(notification){
				axios.patch('/notificaciones/'+ notification.id)
					.then(res =>{
						this.notifications =res.data;
					})
			},
			markAllAsRead(){
				this.notifications.forEach(notification => {
					this.markAsRead(notification);
				})
			},

		},
		computed: {
			
			dropDownNotifications(){
				return ['dropdown-content notifications-dropdown','active'];
			},
			linkToNofitications(){
				return this.notifications.length ? "#" : "/notificaciones";
			}
			
		}
	}
</script>