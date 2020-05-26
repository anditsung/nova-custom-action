<template>
    <modal
        @modal-close="handleClose"
    >
        <form
            @submit.prevent="submitModal"
            class="bg-white rounded-lg shadow-lg overflow-hidden max-w-full"
            ref="form"
        >
            <div class="p-8 bg-primary-30%">
                <heading :level="1" v-html="modalTitle"></heading>
            </div>

            <card>
                <loading-view
                    :loading="loading"
                >

                    <div class="p-8" v-if="customActionFields.length == 0" v-html="modalMessage" />

                    <component
                        v-else
                        v-for="(field, index) in customActionFields"
                        :key="index"
                        :is="componentIs(field.attributes)"
                        :error="validationErrors"
                        :resource-id="resourceId"
                        :resource-name="resourceName"
                        :field="componentField(field.attributes)"
                        @file-deleted="$emit('update-last-retrieved-at-timestamp')"
                    ></component>

                </loading-view>
            </card>

            <div class="bg-30 px-6 py-3 flex">
                <div class="ml-auto">
                    <button
                        class="btn text-80 font-normal h-9 px-3 mr-3 btn-link"
                        @click.prevent="handleClose"
                    >
                        {{ __('Cancel') }}
                    </button>

                    <progress-button
                        type="submit"
                        :disabled="isWorking"
                        :processing="isWorking"
                    >
                        {{ __('Confirm') }}
                    </progress-button>
                </div>
            </div>

        </form>
    </modal>

</template>



<script>
    import { Errors, InteractsWithResourceInformation } from 'laravel-nova'

    export default {

        mixins: [ InteractsWithResourceInformation ],

        props: [

            'resource',

            'resourceName',

            'resourceId',

            'resourceFields',

            'customAction'

        ],

        data: () => ({

            loading: true,

            isWorking: false,

            modalTitle: 'Modal Title',

            modalMessage: 'Modal Messsage',

            validationErrors: new Errors(),

            lastRetrievedAt: null,

            customActionFields: null,

            localFields: null,

        }),

        async created() {

            if (Nova.missingResource(this.resourceName)) {

                return this.$router.push({ name: 404 })

            }

            this.prepareCustomActionFields()

            this.prepareModal()

            this.updateLastRetrievedAtTimestamp()

            if(!this.resourceFields) {

                this.getResourceFields()

            } else {

                this.localFields = this.resourceFields

            }

        },

        methods: {

            async getResourceFields() {

                const {

                    data: { fields },

                } = await Nova.request().get(

                    `/nova-api/${this.resourceName}/${this.resourceId}/update-fields`,

                    {

                        params: {

                            editing: true,

                            editMode: 'update'

                        }

                    },

                ).catch(error => {

                    if (error.response.status == 404) {

                        return this.$router.push({ name: 404 })

                    }

                })

                /* fix for resource using tabs */
                if (fields.Tabs) {

                    /* fields on Tabs is object. convert it to array */
                    this.localFields = Object.keys(fields.Tabs.fields).map(function (key) { return fields.Tabs.fields[key] })

                } else {

                    this.localFields = fields

                }

                this.loading = false

                Nova.$emit('resource-loaded')

            },

            prepareModal() {

                if (this.customAction.modal_title) {

                    this.modalTitle = this.customAction.modal_title

                }

                if (this.customAction.modal_message) {

                    this.modalMessage = this.customAction.modal_message

                }

            },

            prepareCustomActionFields() {

                let fields = JSON.parse(this.customAction.changes)

                let customActionFields = []

                for (const field of fields) {
                    if(field.attributes.value == "") {
                        customActionFields.push(field)
                    }
                }

                this.customActionFields = customActionFields

            },

            handleClose() {

                this.$emit('close')

            },

            async submitModal() {

                this.isWorking = true

                if (this.$refs.form.reportValidity()) {

                    try {

                        const {

                            data: { redirect },

                        } = await Nova.request().post(
                            `/nova-api/${this.resourceName}/${this.resourceId}`,
                            this.resourceFormData,
                            {
                                params: {
                                    editing: true,
                                    editMode: 'update'
                                }
                            }
                        )

                        this.$emit('confirm')

                    } catch ( error ) {

                        if (error.response.status == 422) {

                            this.validationErrors = new Errors(error.response.data.errors)

                            Nova.error(this.__('There was a problem submitting the action.'))

                        }

                        if (error.response.status == 409) {

                            Nova.error(this.__('Another user has updated this resource since this page was loaded. Please refresh the page and try again.'))

                        }

                    }

                }

                this.isWorking = false

            },

            updateLastRetrievedAtTimestamp() {

                this.lastRetrievedAt = Math.floor(new Date().getTime() / 1000)

            },

            findComponentValue(component) {

                switch (component)
                {

                    case 'belongs-to-field':
                        return 'belongsToId'

                    default:
                        return 'value'

                }

            },

            componentIs(attributes) {

                if(!this.loading) {

                    let field = this.localFields.find(field => field.attribute == attributes.name)

                    return `form-${field.component}`

                }

            },

            componentField(attributes) {

                if(!this.loading) {

                    let field = this.localFields.find(field => field.attribute == attributes.name)

                    return field

                }

            },

            generateValue(field, attributes) {

                let today = new Date()

                switch(field.component)
                {

                    case "date":
                        if(attributes.value == 'now') {

                            return today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ("0" + (today.getDate())).slice(-2)

                        }
                        else if(attributes.value == 'null') {

                            return ''

                        }
                        return attributes.value



                    case "date-time":
                        if (attributes.value == 'now') {

                            return today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ("0" + (today.getDate())).slice(-2) + " " + ("0" + today.getHours()).slice(-2) + ":" + ("0" + today.getMinutes()).slice(-2)

                        }
                        else if(attributes.value == 'null') {

                            return ''

                        }
                        return attributes.value



                    default:
                        return attributes.value

                }
            },

        },

        computed: {

            resourceFormData() {

                const formData = new FormData()

                let fields = null

                if (this.resourceFields) {

                    fields = this.resourceFields

                } else {

                    fields = this.localFields

                }

                let changes = JSON.parse(this.customAction.changes)

                fields.forEach(field => {

                    let cField = changes.find(component => component.attributes.name == field.attribute)

                    if(cField) {

                        let fieldValue = this.generateValue(field, cField.attributes)

                        formData.append(field.attribute, fieldValue)

                    } else {

                        let fieldValue = this.findComponentValue(field.component)

                        /* if the value is null return empty string */
                        formData.append(field.attribute, field[fieldValue] ? String(field[fieldValue]) :  '')
                    }

                })

                formData.append('_method', 'PUT')

                formData.append('_retrieved_at', this.lastRetrievedAt)

                return formData
            },

        },
    }
</script>
