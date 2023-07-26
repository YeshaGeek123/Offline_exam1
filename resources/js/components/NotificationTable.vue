<template>
    <div class="table-responsive">    
        <table class="table text-nowrap">
            <thead>
                <tr>
                    <th class="border-top-0">Student</th>
                    <th class="border-top-0">Student Code</th>
                    <th class="border-top-0">Exam</th>
                    <th class="border-top-0">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(noti, index) in totalNotifications" :key="index">
                    <td>{{ noti.data ? noti.data.student.name : noti.student.name }}</td>
                    <td>{{ noti.data ? noti.data.student.code : noti.student.code }}</td>
                    <td>{{ noti.data ? noti.data.exam.title : noti.exam.title }}</td>
                    <td><b-button :data-student="noti.data ? noti.data.student.id : noti.student.id" :data-exam="noti.data ? noti.data.exam.id : noti.exam.id" :data-notification="noti.id" :data-key="index" @click="sendKey" v-b-modal.modal-1>Accept</b-button></td>
                </tr>
            </tbody>
        </table>

        <b-modal ref="my-modal" id="modal-1" hide-footer hide-backdrop no-close-on-esc no-close-on-backdrop hide-header-close title="Accept Submission">
            <form action="">
                <p>
                    <label for="">Cubicle</label>
                    <select v-model="cubicleid" class="form-control">
                        <option :value="cub.id" v-for="(cub, index) in cubicles" :key="index">{{ cub.title }}</option>
                        <option value="0">Waiting room</option>
                    </select>
                </p>
                <b-button class="mt-2" variant="success" block @click="submitModal">Submit</b-button>
                <b-button class="mt-2" variant="danger" block @click="hideModal">Cancel</b-button>
            </form>
        </b-modal>
    </div>
</template>

<script>
    export default {
        props: ['unreads', 'user', 'notifications'],
        data() {
            return {
                cubicles: '',
                cubicleid: '',
                selectedStudent: '',
                selectedExam: '',
                selectedNotification: '',
                selectedKey: '',
                totalNotifications: this.notifications,
                unreadNotifications: this.unreads
            }
        },
        mounted() {
            Echo.private('App.Models.User.' + this.user)
                .notification((notification) => {
                    this.totalNotifications.unshift(notification);
                    this.unreadNotifications.unshift(notification);
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
                
        },
        methods: {
            sendKey(e) {
                this.selectedStudent = e.target.dataset.student;
                this.selectedExam = e.target.dataset.exam;
                this.selectedKey = e.target.dataset.key;
                this.selectedNotification = e.target.dataset.notification;

                axios.get('/assistant/get-exam-cubicles/'+this.selectedExam)
                    .then((res) => {
                        this.cubicles = res.data.cubicles
                    })
                    .catch((error) => {
                        this.$swal(error);
                    });

            },
            hideModal() {
                this.$refs['my-modal'].hide()
            },
            submitModal() {
                if ( this.cubicleid != '' ) {
                    axios.post('/assistant/accept', {
                        notification_id: this.selectedNotification,
                        student_id: this.selectedStudent,
                        exam_id: this.selectedExam,
                        cubicle_id: this.cubicleid
                    })
                    .then((response) => {
                        this.hideModal()
                        if ( response.data.success ) {
                            this.$swal('Submission accepted!');
                        }
                        else {
                            this.$swal('Something went wrong.');
                        }
                    })
                    .catch((error) => {
                        this.$swal(error);
                    });
                }
            },
        }
    }
</script>
