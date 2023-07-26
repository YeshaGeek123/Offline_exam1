<template>
    <div class="table-responsive">
        <table class="table text-nowrap">
            <thead>
                <tr>
                    <th class="border-top-0">Code</th>
                    <th class="border-top-0">Exam</th>
                    <th class="border-top-0">Cubcile</th>
                    <th class="border-top-0">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(student, index) in allStudents" :key="index">
                    <td>{{ student.code }}</td>
                    <td>{{ student.exam.title }}</td>
                    <td>{{ student.submission_cubicle }}</td>
                    <td>
                        <a :ref="'btn-'+student.id" :href="'/evaluator/evaluate-form/' + student.id" class="btn btn-primary btn-rounded" :class="{ 'disabled btn-warning': student.is_being_evaluated }"><i class="fas fa-tasks"></i> <span v-if="student.is_being_evaluated">Evaluation in progress...</span>
                        <span v-else>Evaluate</span> </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['students', 'user'],
        data() {
            return {
                selectedRef: '',
                allStudents: this.students
            }
        },
        mounted() {
            Echo.private('App.Models.User.' + this.user)
                .listen('AssistantSubmitted', (e) => {
                    // console.log(e);
                    this.allStudents.push(e.student);
                })
                .listen('EvaluationStarted', (e) => {
                    const index = this.allStudents.findIndex(item => {
                        return (e.student_id == item.id)
                    });

                    this.allStudents[index].is_being_evaluated = 1;
                })
                .listen('EvaluationLimitReached', (e) => {
                    const index = this.allStudents.findIndex(item => {
                        return (e.student_id == item.id)
                    });

                    this.$delete(this.allStudents, index)
                })
                .listen('EvaluationEnded', (e) => {
                    const index = this.allStudents.findIndex(item => {
                        return (e.student_id == item.id)
                    });

                    this.allStudents[index].is_being_evaluated = 0;
                });
        }
    }
</script>
