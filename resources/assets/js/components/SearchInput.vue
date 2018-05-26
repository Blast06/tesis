<template>
    <div class="search nav-block">
        <svg xmlns="http://www.w3.org/2000/svg" style="display:none">
            <symbol xmlns="http://www.w3.org/2000/svg" id="sbx-icon-search-18" viewBox="0 0 40 40">
                <path d="M30.776 27.146l-1.32-1.32-3.63 3.632 1.32 1.32 3.63-3.632zm1.368 1.368l6.035 6.035c.39.39.4 1.017.008 1.408l-2.23 2.23c-.387.387-1.015.387-1.41-.008l-6.035-6.035 3.63-3.63zm-8.11 1.392c-2.356 1.363-5.092 2.143-8.01 2.143C7.174 32.05 0 24.873 0 16.023S7.174 0 16.024 0c8.85 0 16.025 7.174 16.025 16.024 0 2.918-.78 5.654-2.144 8.01l8.96 8.962c1.175 1.174 1.184 3.07.008 4.246l-1.632 1.632c-1.17 1.17-3.067 1.173-4.247-.007l-8.96-8.96zm-8.01.54c7.965 0 14.422-6.457 14.422-14.422 0-7.965-6.457-14.422-14.422-14.422-7.965 0-14.422 6.457-14.422 14.422 0 7.965 6.457 14.422 14.422 14.422zm0-2.403c6.638 0 12.018-5.38 12.018-12.02 0-6.636-5.38-12.017-12.018-12.017-6.637 0-12.018 5.38-12.018 12.018 0 6.638 5.38 12.02 12.018 12.02zm0-1.402c5.863 0 10.616-4.752 10.616-10.616 0-5.863-4.753-10.616-10.616-10.616-5.863 0-10.616 4.753-10.616 10.616 0 5.864 4.753 10.617 10.616 10.617z"
                      fill-rule="evenodd" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="sbx-icon-clear-5" viewBox="0 0 20 20">
                <path d="M10 20c5.523 0 10-4.477 10-10S15.523 0 10 0 0 4.477 0 10s4.477 10 10 10zm1.35-10.123l3.567 3.568-1.225 1.226-3.57-3.568-3.567 3.57-1.226-1.227 3.568-3.568-3.57-3.57 1.227-1.224 3.568 3.568 3.57-3.567 1.224 1.225-3.568 3.57zM10 18.272c4.568 0 8.272-3.704 8.272-8.272S14.568 1.728 10 1.728 1.728 5.432 1.728 10 5.432 18.272 10 18.272z"
                      fill-rule="evenodd" />
            </symbol>
        </svg>

        <form novalidate="novalidate" action="/search" method="get" class="searchbox sbx-custom">
            <div role="search" class="sbx-custom__wrapper">
                <input type="search" name="q" placeholder="B U S C A R" autocomplete="off" required="required" class="sbx-custom__input">
                <button type="submit" title="Pulsa aqui para consulta la búsqueda." class="sbx-custom__submit">
                    <svg role="img" aria-label="Search">
                        <use xlink:href="#sbx-icon-search-18"></use>
                    </svg>
                </button>
                <button type="reset" title="Clear the search query." class="sbx-custom__reset">
                    <svg role="img" aria-label="Reset">
                        <use xlink:href="#sbx-icon-clear-5"></use>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "SearchInput"
    }
</script>

<style lang="scss">
    $custom:(
            //input-width: 400px,
            //input-height: 50px,
            border-width: 0,
            input-border-color: #FFFFFF,
            input-focus-border-color: #FFFFFF,
            input-background: #FFFFFF,
            input-focus-background: #FFFFFF,
            font-size: 12px,
            placeholder-color: #CCCCCC,
            icon: sbx-icon-search-18,
            icon-size: 20px,
            icon-position: left,
            icon-color: #CCCCCC,
            icon-background: #FFFFFF,
            icon-background-opacity: 0,
            icon-clear: sbx-icon-clear-5,
            icon-clear-size: 18px
    );


    @function even-px($value) {
        @if type-of($value) == 'number' {
            @if (unitless($value)) {
                $value: $value * 1px;
            } @else if unit($value) == 'em' {
                $value: ($value / 1em * 16px);
            } @else if unit($value) == 'pts' {
                $value: $value * 1.3333 * 1px;
            } @else if unit($value) == '%' {
                $value: $value * 16 / 100% * 1px;
            };
        $value: round($value);
        @if ($value % 2 != 0) {
        $value: $value + 1;
        }
        @return $value;
        }
    }

    @mixin searchbox(
        $font-size: 90%,
        $input-width: 350px,
        $input-height: $font-size * 2.4,
        $border-width: 1px,
        $border-radius: $input-height / 2,
        $input-border-color: #ccc,
        $input-focus-border-color: #1ec9ea,
        $input-background: #f8f8f8,
        $input-focus-background: #fff,
        $placeholder-color: #aaa,
        $icon: 'sbx-icon-search-1',
        $icon-size: $input-height / 1.6,
        $icon-position: left,
        $icon-color: #888,
        $icon-background: $input-focus-border-color,
        $icon-background-opacity: .1,
        $icon-clear: 'sbx-icon-clear-1',
        $icon-clear-size: $font-size / 1.1
    ) {
        display: inline-block;
        position: relative;
        width: $input-width;
        height: even-px($input-height);
        white-space: nowrap;
        box-sizing: border-box;
        font-size: $font-size;

        &__wrapper {
            width: 100%;
            height: 100%;
        }

        &__input {
            display: inline-block;
            transition: box-shadow .4s ease, background .4s ease;
            border: 0;
            border-radius: even-px($border-radius);
            box-shadow: inset 0 0 0 $border-width $input-border-color;
            background: $input-background;
            padding: 0;
            padding-left: if($icon-position == 'right',
                    even-px($font-size / 2) + even-px($border-radius / 2),
                    even-px($input-height) + if($icon-background-opacity == 0, 0, even-px($font-size * 1.2)));
            width: 100%;
            height: 100%;
            vertical-align: middle;
            white-space: normal;
            font-size: inherit;
            appearance: none;

            &::-webkit-search-decoration,
            &::-webkit-search-cancel-button,
            &::-webkit-search-results-button,
            &::-webkit-search-results-decoration {
                display: none;
            }

            &:hover {
                box-shadow: inset 0 0 0 $border-width darken($input-border-color, 10%);
            }

            &:focus,
            &:active {
                outline: 0;
                box-shadow: inset 0 0 0 $border-width $input-focus-border-color;
                background: $input-focus-background;
            }

            &::placeholder {
                color: $placeholder-color;
            }

        }

        &__submit {
            position: absolute;
            top: 0;
            @if $icon-position == 'right' {
                right: 0;
                left: inherit;
            } @else {
                right: inherit;
                left: 0;
            }
            margin: 0;
            border: 0;
            border-radius: if($icon-position == 'right', 0 $border-radius $border-radius 0, $border-radius 0 0 $border-radius);
            background-color: rgba($icon-background, $icon-background-opacity);
            padding: 0;
            width: even-px($input-height) + if($icon-background-opacity == 0, 0, even-px($font-size / 2));
            height: 100%;
            vertical-align: middle;
            text-align: center;
            font-size: inherit;
            user-select: none;

            // Helper for vertical alignement of the icon
            &::before {
                display: inline-block;
                margin-right: -4px;
                height: 100%;
                vertical-align: middle;
                content: '';
            }

            &:hover,
            &:active {
                cursor: pointer;
            }

            &:focus {
                outline: 0;
            }

            svg {
                width: even-px($icon-size);
                height: even-px($icon-size);
                vertical-align: middle;
                fill: $icon-color;
            }
        }

        &__reset {
            display: none;
            position: absolute;
            top: (even-px($input-height) - even-px($icon-clear-size)) / 2 - 4px;
            right: if($icon-position == 'right',
                    even-px($input-height) + if($icon-background-opacity == 0, 0 , even-px($font-size)),
                    (even-px($input-height) - even-px($icon-clear-size)) / 2 - 4px);
            margin: 0;
            border: 0;
            background: none;
            cursor: pointer;
            padding: 0;
            font-size: inherit;
            user-select: none;
            fill: rgba(#000, .5);

            &:focus {
                outline: 0;
            }

            svg {
                display: block;
                margin: 4px;
                width: even-px($icon-clear-size);
                height: even-px($icon-clear-size);
            }
        }

        &__input:valid ~ &__reset {
            display: block;
            animation-name: sbx-reset-in;
            animation-duration: .15s;
        }

        @at-root{
            @keyframes sbx-reset-in {
                0% {
                    transform: translate3d(-20%, 0, 0);
                    opacity: 0;
                }

                100% {
                    transform: none;
                    opacity: 1;
                }
            }
        }
    }

    .sbx-custom{
        @include searchbox($custom...);
    }
</style>