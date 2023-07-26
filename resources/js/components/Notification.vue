<template>
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle notification-custom" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span><i class="fas fa-bell"></i></span>
            <span class="badge" v-if="unreadNotifications.length >'0'">{{ unreadNotifications.length }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDarkDropdownMenuLink">
            <li>
                <a class="dropdown-item" href="#" >
                    <i class="fas fa-lock-open"></i> Change Password
                </a>
            </li>
        </ul>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['unreads', 'user','notifications'],
        data() {
            return {
                totalNotifications: this.notifications,
                unreadNotifications: this.unreads
            }
        },
        mounted() {
            Echo.private('App.Models.User.' + this.user)
                .notification((notification) => {
                    this.totalNotifications.unshift(notification);
                    this.unreadNotifications.unshift(notification);
                });
        },
        methods: {
            notificationClick: function(event){
                this.$http.post(
                    '/api/notification-read', 
                    { 
                        unreads: this.unreadNotifications,
                    }
                );
                this.unreadNotifications=[];
                
            }
        }
    }
</script>
