<template>
    <div class="table-responsive">    
        <h5>Students Calling To Action</h5>
        <table class="table text-nowrap">
            <thead>
                <tr>
                    <th class="border-top-0">Student</th>
                    <th class="border-top-0">Student Code</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(noti, index) in totalNotifications" :key="index">
                    <td>{{ noti.data ? noti.data.student.name : noti.student.name }}</td>
                    <td>{{ noti.data ? noti.data.student.code : noti.student.code }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['user', 'notifications'],
        data() {
            return {
                totalNotifications: this.notifications,
            }
        },
        mounted() {
            Echo.private('App.Models.User.' + this.user)
                .notification((notific) => {
                    this.totalNotifications.unshift(notific);
                })
                .listen('AssistantSubmitted', (e) => {
                    const index = this.totalNotifications.findIndex(item => {
                        if ( item.data ) {
                            return (e.student.id == item.data.student.id && e.exam_id == item.data.exam.id)
                        }
                        else {
                            return (e.student.id == item.student.id && e.exam_id == item.exam.id)
                        }
                    });

                    this.$delete(this.totalNotifications, index)
                });
        }
    }
</script>
