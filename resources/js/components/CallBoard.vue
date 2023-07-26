<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2" v-for="(cube, index) in allCubicles" :key="index">
                <div class="card"  style="border-radius: 20px; height: calc(100% - 20px) !important; margin-bottom: 20px !important;" :style="{'background-color': colors[index]}" >
                    <div class="card-body text-white">
                        <h5 class="card-title">Cubicle Number: <strong> {{ cube.cubicle_number }}</strong></h5>
                        <h5 class="card-title" v-if="cube.recent_evaluation">Student Code: <strong> {{ cube.recent_evaluation.student.sequence_number }}</strong></h5>
                        <h5 class="card-title" v-else>Student Code: <strong> N/A</strong></h5>

                        <hr>

                        <div v-if="cube.has_failed">
                            <h5 class="card-title">Manager: <strong> {{ manager.name }}</strong></h5>

                            <h5 class="card-title">Status: <strong> FAILED</strong></h5>
                        </div>

                        <div v-else>
                            <h5 class="card-title" v-if="cube.recent_evaluation">Evaluator: <strong> {{ cube.recent_evaluation.user.name }}</strong></h5>
                            <h5 class="card-title" v-else>Evaluator: <strong> N/A</strong></h5>

                            <h5 class="card-title" v-if="cube.recent_evaluation && cube.need_cleanup == 0">Status:
                                <strong v-if="cube.recent_evaluation.status == 1"> EVALUATING</strong>
                                <strong v-else> ASSIGNED </strong></h5>
                            <h5 class="card-title" v-else-if="cube.need_cleanup == 1">Status:
                                <strong> CLEANUP REQUIRED </strong></h5>
                            <h5 class="card-title" v-else>Status: <strong> EMPTY</strong></h5>
                        </div>
                        <h5 class="card-title" v-if="cube.recent_evaluation">Evaluation Cycle
                            <p class="mt-2">
                                <span class="mt-3" v-for="n in 3" :key=n>
                                    <i class="fa fa-circle me-2" :class="{ 'text-success': n < cube.recent_evaluation.count_position  || ( cube.recent_evaluation.count_position == n && cube.recent_evaluation.status > 1 ), 'text-warning': n == cube.recent_evaluation.count_position && cube.recent_evaluation.status <= 1, 'text-light': n > cube.recent_evaluation.count_position }"></i>
                                </span>
                            </p>
                        </h5>
                        <h5 class="card-title" v-else>Evaluation Cycle
                            <p class="mt-2">
                                <strong> N/A</strong>
                            </p>
                        </h5>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
   props: ['cubicles', 'evaluators', 'examid', 'manager'],
  data() {
    return {
                allCubicles: this.cubicles,
                allEvaluators: this.evaluators,
                eid: this.examid,
                colors : [
                    '#403A3A',
                    '#d571c8',
                    '#3b9cca',
                    '#7E7B52',
                    '#035da6',
                    '#B44C43',
                    '#5e533e',
                    '#0e811d',
                    '#6F4F28',
                    '#62a4fc',
                    '#fccb02',
                    '#ee10de',
                    '#98381e',
                    '#a5b49f',
                    '#9a3f75',
                    '#746ea9',
                    '#c063f7',
                    '#276785',
                    '#287222',
                    '#59616e'
                ]
            }
  },
  mounted() {
    Echo.channel('call-board')
                .listen('AssignedToCubicle', (e) => {
                    const index = this.allCubicles.findIndex(item => {
                        return (e.cubicle_id == item.id)
                    });

                    this.allCubicles[index].has_failed = 0;
                    this.allCubicles[index].need_cleanup = 0;
                    this.allCubicles[index].recent_evaluation = e;
                })
                .listen('EvaluationStarted', (e) => {
                    const index = this.allCubicles.findIndex(item => {
                        return (item.recent_evaluation && e.eid == item.recent_evaluation.id)
                    });

                    this.allCubicles[index].recent_evaluation.status = 1;
                })
                .listen('NeedCleanup', (e) => {
                    const index = this.allCubicles.findIndex(item => {
                        return (item.id == e.id)
                    });

                    this.allCubicles[index].recent_evaluation = null;
                    this.allCubicles[index].has_failed = 0;
                    this.allCubicles[index].need_cleanup = 1;
                })
                .listen('CleanedUp', (e) => {
                    const index = this.allCubicles.findIndex(item => {
                        return (item.id == e.id)
                    });

                    this.allCubicles[index].need_cleanup = 0;
                })
                .listen('TwoFailed', (e) => {
                    const index = this.allCubicles.findIndex(item => {
                        return (item.id == e.cubicle)
                    });

                    this.allCubicles[index].has_failed = 1;
                    this.allCubicles[index].recent_evaluation.status = 3;
                })
  },
};
</script>


<style scoped>
    .card-title span {
        margin-right: 5px;
    }
</style>

