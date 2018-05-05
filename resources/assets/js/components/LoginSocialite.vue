<template>
    <main>
        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <a href="/login/facebook" class="btn btn-link">
                    <i class="fab fa-facebook-square fa-2x"></i>
                </a>

                <a href="/login/google" class="btn btn-link">
                    <i class="fab fa-google fa-2x"></i>
                </a>

                <a href="/login/twitter" class="btn btn-link">
                    <i class="fab fa-twitter fa-2x"></i>
                </a>
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        name: 'login-socialite'
    }
</script>

<style lang="scss">
    $color_icon: #424242;

    .fa-facebook-square {
        color: $color_icon;
        &:hover {
            color: #0D47A1;
        }
    }

    .fa-google {
        color: $color_icon;
        &:hover {
            color: #F44336;
        }
    }

    .fa-twitter {
        color: $color_icon;
        &:hover {
            color: #2196F3;
        }
    }
</style>
