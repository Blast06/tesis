<template>
    <div class="container">
        <h4 class="mt-5 text-center">Opiniones de los usuarios</h4>
        <div class="row">
            <div class="col-md-12 mt-2" v-for="review in dataReviews" v-if="dataReviews.length > 0">
                <div class="comment-wrap">
                    <div class="photo">
                        <div class="avatar" :style="{'background-image': 'url(' + review.user.avatar + ')' }" data-toggle="tooltip" data-placement="top" :title="review.user.name"></div>
                    </div>
                    <div class="comment-block">
                        <p class="comment-text" v-text="review.comment"></p>
                        <div class="bottom-comment">
                            <div class="comment-date">{{ review.created_at | moment('MMMM Do YYYY, h:mm:ss a') }}</div>
                            <star-rating
                                    class="float-right"
                                    v-model="review.rating"
                                    v-bind:increment="1"
                                    v-bind:max-rating="5"
                                    :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]"
                                    border-color="#d8d8d8"
                                    v-bind:rounded-corners="true"
                                    v-bind:border-width="2"
                                    v-bind:show-rating="false"
                                    v-bind:read-only="true"
                                    v-bind:star-size="15">
                            </star-rating>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-2" v-else>
                <div class="container">
                    <div class="alert alert-info" role="alert">
                            <em> Aun no comentan este articulo </em>
                    </div>
                </div>
            </div>

            <div class="col-md-6" v-if="isAuth && isOrder">
                <star-rating
                        v-model="form.rating"
                        v-bind:increment="1"
                        v-bind:max-rating="5"
                        :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]"
                        border-color="#d8d8d8"
                        v-bind:rounded-corners="true"
                        v-bind:border-width="4"
                        v-bind:show-rating="false"
                        v-bind:read-only="false"
                        v-bind:star-size="90">
                </star-rating>
            </div>

            <div class="col-md-6" v-if="isAuth && isOrder">
                <b-form-textarea id="comment"
                                 v-model="form.comment"
                                 placeholder="Cuéntale a los demás lo que piensas sobre este artículo. ¿Lo recomendarías y por qué?"
                                 :rows="3"
                                 :max-rows="6">
                </b-form-textarea>
            </div>

            <div class="col-md-12 mt-2" v-if="isAuth && isOrder">
                <button class="btn-primary btn-block"
                        :disabled="form.rating < 1"
                        @click.prevent="create"
                        v-if="dataIsReview">Valorar articulo
                </button>

                <button class="btn-primary btn-block"
                        :disabled="form.rating < 1"
                        @click.prevent="update"
                        v-else>Actualizar valoracion
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['isAuth', 'isReview', 'isOrder', 'reviews', 'review', 'article', 'user'],
        name: "rating_article",
        data() {
            return {
                form: new Form({
                    rating: (this.review !== null && this.isset(this.review.rating) && this.review.rating > 0) ? this.review.rating : 0,
                    comment: (this.review !== null && this.isset(this.review.comment) && this.review.comment.length > 0) ? this.review.comment : ''
                }),
                dataReviews: this.reviews,
                dataReview: this.review,
                dataIsReview: this.isReview,
                loading: false,
            }
        },
        methods: {
            create(){
                this.$validator.validateAll().then((valid) => {
                    if (valid) {
                        this.loading = true;
                        this.form.post(`/articles/${this.article.id}/reviews`)
                            .then((response) => {
                                this.dataIsReview = false;
                                this.dataReview = response.data;

                                this.dataReviews.push({
                                    id: this.dataReview.id,
                                    rating: this.form.rating,
                                    comment: this.form.comment,
                                    created_at: Date.now(),
                                    user: {
                                        avatar: this.user.avatar,
                                        name: this.user.name
                                    }
                                });

                            });
                    }
                });
            },
            update(){
                this.$validator.validateAll().then((valid) => {
                    if (valid) {
                        this.loading = true;
                        this.form.put(`/articles/${this.dataReview.article_id}/reviews/${this.dataReview.id}`)
                            .then((response) => {
                                let update_review = this.dataReviews.find(review => review.id === this.dataReview.id);
                                update_review.rating = this.form.rating;
                                update_review.comment = this.form.comment;
                                this.dataReview = response.data;
                            });
                    }
                });
            },
            isset(attribute){
                if (attribute === undefined || attribute === null || attribute === 'undefined') {
                    return false;
                }
                return true;
            }
        }
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>

<style lang="scss">
    .comment-wrap {
        margin-bottom: 1.25rem;
        display: table;
        width: 100%;
        min-height: 5.3125rem;

        .photo {
            padding-top: 0.625rem;
            display: table-cell;
            width: 3.5rem;

            .avatar {
                height: 2.25rem;
                width: 2.25rem;
                border-radius: 50%;
                background-size: contain;
            }
        }

        .comment-block {
            padding: 1rem;
            background-color: #fff;
            display: table-cell;
            vertical-align: top;
            border-radius: 0.1875rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08);

            p {
                line-height: 1.3125rem;
            }

            .bottom-comment {
                color: #acb4c2;
                font-size: 0.875rem;
            }

            .comment-date {
                float: left;
            }
        }
    }
</style>