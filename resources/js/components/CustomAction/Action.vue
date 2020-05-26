<template>
    <div v-if="showCustomAction">

        <button
            class="inline-flex appearance-none cursor-pointer text-70 ml-3"
            :class="icon.class"
            @click.prevent="openActionModal"
            v-tooltip.click="__(customAction.name)"
            :disabled="processing"
        >
<!--            <icon view-box="0 0 20 20" type="menu"/> -->
            <svg
                xmlns="http://www.w3.org/2000/svg"
                :width="icon.width"
                :height="icon.height"
                :viewBox="icon.viewBox"
                class="fill-current"
            >
                <path
                    :d="icon.path" />
            </svg>
        </button>

        <portal
            to="modals"
            transition="fade-transition"
            v-if="actionModalOpen"
        >
            <action-modal
                :resource="resource"
                :resource-name="resourceName"
                :resource-id="resourceId"
                :resource-fields="resourceFields"
                :custom-action="customAction"
                v-if="actionModalOpen"
                @close="closeActionModal"
                @confirm="confirmActionModal"
            ></action-modal>
        </portal>
    </div>
</template>

<script>
    export default {

        props: [

            'resource',

            'resourceName',

            'resourceId',

            'customAction',

        ],

        data: () => ({

            actionModalOpen: false,

            showCustomAction: false,

            resourceFields: null,

            icon: {
                width: 20,
                height: 20,
                viewBox: "0 0 20 20",
                path: "M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z",
                class: "hover:text-primary",
            }

        }),

        async created() {

            if (Nova.missingResource(this.resourceName)) {

                return this.$router.push({ name: 404 })

            }

            this.prepareIcon()

            this.shouldDisplayCustomAction()

        },

        methods: {

            prepareIcon() {

                if (this.customAction.icon.class) {

                    this.icon.class = this.customAction.icon.class

                }

                if (this.customAction.icon.icon) {

                    this.icon.path = this.customAction.icon.icon

                }

                if (this.customAction.icon.width) {

                    this.icon.width = this.customAction.icon.width

                }

                if (this.customAction.icon.height) {

                    this.icon.height = this.customAction.icon.height

                }

                if (this.customAction.icon.width && this.customAction.icon.height) {

                    this.icon.viewBox = `0 0 ${this.customAction.icon.width} ${this.customAction.icon.height}`

                }

            },

            async shouldDisplayCustomAction() {

                let rules = JSON.parse(this.customAction.rules)

                let ruleCheck = true

                for (const rule of rules) {

                    let field = this.resource.fields.find(field => field.attribute == rule.attributes.name)

                    if(!field) {

                        if(!this.resourceFields) {

                            await this.resourceCheck()

                        }

                        field = this.resourceFields.find(field => field.attribute == rule.attributes.name)

                    }

                    // check if the field is exists. field that have onlyOn rule doesnt exist
                    if(field) {

                        if (rule.attributes.value == field.value) {

                            continue

                        }
                        else {

                            ruleCheck = false

                            break

                        }

                    }

                }

                if(ruleCheck) {

                    this.showCustomAction = true

                } else {

                    this.showCustomAction = false

                }

                this.processing = false
            },

            async resourceCheck() {

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

                )

                this.resourceFields = fields

            },

            openActionModal() {

                this.actionModalOpen = true

            },

            closeActionModal() {

                this.actionModalOpen = false

            },

            confirmActionModal() {

                this.indexPageRefresh()

                this.closeActionModal()

            },

            indexPageRefresh() {

                this.$parent.$parent.$parent.$parent.$parent.$parent.$parent.getResources()

            },

        }

    }
</script>
