<template>
    <div class="table-responsive">    
        <h5>Evaluators</h5>
        <table class="table text-nowrap">
            <thead>
                <tr>
                    <th class="border-top-0">Name</th>
                    <th class="border-top-0">Status</th>
                    <th class="border-top-0">Student Code</th>
                    <th class="border-top-0">Cubicle</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(ev, index) in allEvaluators" :key="index">
                    <td>{{ ev.name }}</td>
                    <td v-if="ev.student"><i class="fas fa-circle text-warning"></i> Busy</td>
                    <td v-else><i class="fas fa-circle text-success"></i> Available</td>
                    <td>{{ ev.student ? ev.student.code : 'N/A' }}</td>
                    <td>{{ ev.student ? ev.student.submission_cubicle : 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['evaluators', 'examid'],
        data() {
            return {
                allEvaluators: this.evaluators,
                eid: this.examid
            }
        },
        mounted() {
            Echo.private('App.Models.Exam.' + this.eid)
                .listen('EvaluationStarted', (e) => {
                    // console.log(e);
                    const index = this.allEvaluators.findIndex(item => {
                        return (e.evaluator.id == item.id)
                    });

                    this.allEvaluators[index].student = e.student;
                })
                .listen('EvaluationEnded', (e) => {
                    // console.log(e);
                    const index = this.allEvaluators.findIndex(item => {
                        return (e.evaluator_id == item.id)
                    });

                    this.allEvaluators[index].student = null;
                })
        },
        methods: {
        }
    }
</script>
