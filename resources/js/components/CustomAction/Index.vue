<template>
    <div v-if="hasCustomAction" class="flex">
        <custom-action
            v-for="(action, index) in customAction"
            :key="index"
            :resource="resource"
            :resource-name="resourceName"
            :resource-id="resourceId"
            :custom-action="action"
        ></custom-action>
    </div>
</template>


<script>
    export default {

        props: [

            'resourceName',

            'field',

        ],

        data: () => ({

            resource: null,

            resourceId: null,

            hasCustomAction: false,

            customAction: null,

        }),

        created() {

            this.getResource()

            this.hasCustomActionField()

        },

        mounted() {

            this.fixPosition()

        },

        methods: {

            getResource() {

                this.resource = this.$parent.resource

                this.resourceId = this.resource['id'].value

            },

            hasCustomActionField() {

                let customAction = this.resource.fields.find(field => field.component == 'custom-action-field').customAction

                if (customAction.length > 0) {

                    this.customAction = customAction

                    this.hasCustomAction = true

                }

            },

            fixPosition() {

                let parentElement = this.$el.parentElement;

                parentElement.classList.add("td-fit");

                parentElement.style.paddingRight = "0px";

                parentElement.style.minWidth = "auto";

            },

        },

    }
</script>
