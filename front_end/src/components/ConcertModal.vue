<template>
    <el-dialog :visible="showModal"
               id="concertModal"
               width="100%"
               :title="isNew ? 'Add Concert' : 'Edit Concert'"
               :before-close="closeModal">

            <el-form :model="concertForm" :rules="rules" ref="concertForm" status-icon>

                <!--Headliner Input-->
                <el-form-item label="Headliner" prop="headliner">
                    <el-input v-model="concertForm.name" placeholder="Indigo Joseph"/>
                </el-form-item>

                <!--Opening Act(s) Input-->
<!--                <el-form-item label="Opening Act(s)" prop="openingActs">-->
<!--                    <el-input-tag v-model="concertForm.openingActs" />-->
<!--                </el-form-item>-->



            </el-form>


        <span slot="footer" class="dialog-footer">
            <el-button @click="closeModal">Cancel</el-button>
            <el-button type="primary" @click="closeModal">Confirm</el-button>
      </span>

    </el-dialog>
</template>

<script>
    //import {ElInputTag} from 'el-input-tag';

    export default {
        name: "ConcertModal",
        props: {
            concert: {
                type: Object,
                default: () => ({
                    id: null,
                    headliner: null,
                    venue: null,
                    date: false,
                    openingActs: []
                })
            },
            showModal: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                concertForm: Object.assign({}, this.concert),
                rules: {}
            }
        },
        computed: {
            isNew() { return this.concert.id === null }
        },
        methods: {
            closeModal() {
                this.$emit('close-modal');
            }
        },
        components: {
            //ElInputTag
        }
    }
</script>

<style scoped>
    #concertModal {
        max-width: 500px;
        margin: 0 auto;
    }
</style>