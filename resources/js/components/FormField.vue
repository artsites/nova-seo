<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <div class="form-group mb-3">
                <label class="mb-1 block">Title:</label>
                <input
                    :id="field.name+'-title'"
                    type="text"
                    class="w-full form-control form-input form-input-bordered"
                    :class="errorClasses"
                    placeholder="Title"
                    v-model="value.title"
                />
            </div>
            <div class="form-group mb-3">
                <label class="mb-1 block">Description:</label>
                <textarea
                    :id="field.name+'-description'"
                    type="text"
                    class="w-full form-control form-input form-input-bordered py-3 h-auto"
                    :class="errorClasses"
                    placeholder="Description"
                    v-model="value.description"
                />
            </div>
        </template>
    </default-field>
</template>

<script>
import {FormField, HandlesValidationErrors} from "laravel-nova";

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ["resourceName", "resourceId", "field"],

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            console.log(this.value);

            this.value = this.field.value || "";
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value ? JSON.stringify(this.value) : "");
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value;
        }
    }
};
</script>
