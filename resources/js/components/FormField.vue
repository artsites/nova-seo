<template>
    <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText" :full-width-content="fullWidthContent">
        <template #field>

            <div v-if="field.has_auto_title" class="form-group mb-3">
                <label class="mb-1 block">Auto Title:</label>
                <input
                    :id="field.name+'-auto_title'"
                    type="checkbox"
                    class="checkbox mt-2"
                    v-model="value.auto_title"
                />
            </div>

            <div class="form-group mb-3">
                <label class="mb-1 block">Title:</label>
                <input
                    :id="field.name+'-title'"
                    type="text"
                    class="w-full form-control form-input form-input-bordered"
                    :class="errorClasses"
                    placeholder="Title"
                    v-model="value.title"
                    :readonly="!!value.auto_title"
                    :disabled="!!value.auto_title"
                />
                <div class="flex space-x-2">
                    <charcounter :value="value.title ?? ''" :max-chars="maxTitleChars"
                                 :warning-threshold="titleWarningAt"></charcounter>
                </div>
            </div>

            <div v-if="field.has_auto_description" class="form-group mb-3">
                <label class="mb-1 block">Auto Description:</label>
                <input
                    :id="field.name+'-auto_description'"
                    type="checkbox"
                    class="checkbox mt-2"
                    v-model="value.auto_description"
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
                    :readonly="!!value.auto_description"
                    :disabled="!!value.auto_description"
                />
                <div class="flex space-x-2">
                    <charcounter :value="value.description ?? ''" :max-chars="maxDescriptionChars"
                                 :warning-threshold="descriptionWarningAt"></charcounter>
                </div>
            </div>

        </template>
    </DefaultField>
</template>

<script>
import {FormField, HandlesValidationErrors} from "laravel-nova";
import Charcounter from './Charcounter.vue';

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ["resourceName", "resourceId", "field"],

    components: {
        'charcounter': Charcounter,
    },

    data() {
        return {
            maxTitleChars: 191,
            titleWarningAt: 70,

            maxDescriptionChars: 500,
            descriptionWarningAt: 140,
        }
    },

    methods: {
        /**
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value;

            if (this.value?.auto_title) {
                this.value.auto_title = this.value.auto_title == '1' ? true : false
            }

            if (this.value?.auto_description) {
                this.value.auto_description = this.value.auto_description == '1' ? true : false
            }

            if (!this.value) {
                this.value = {
                    has_auto_title: this.field.has_auto_title,
                    auto_title: this.field.auto_title,
                    title: this.field.title ?? '',
                    has_auto_description: this.field.has_auto_description,
                    auto_description: this.field.auto_description,
                    description: this.field.description ?? '',
                }
            }
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
