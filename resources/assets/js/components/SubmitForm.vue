<template>
    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary" :disabled="status">
                {{ name }}
                <i v-show="status" class="fas fa-circle-notch fa-spin"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "submitForm",
        props: ['name', 'status'],
    }
</script>

<style scoped>

</style>