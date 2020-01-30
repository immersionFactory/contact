<template>
    <div id="form-container">
        <span class="form-title">How can we help you?</span>
        <contact-form></contact-form>
    </div>
</template>
<script>
    import ContactForm from '../components/ContactForm';

    export default {
        components: {
            ContactForm
        },
    };
</script>
<style lang="scss">

    @use '../../sass/global.scss';

    body {
        background: #004D71;
    }

    #app {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100vh;
        color: white;
        background: #004D71;
        @include global.for-phone-only {
            justify-content: flex-start;
            margin-top: 10px;
        }
    }

    #form-container {
        display: flex;
        flex-direction: column;
        justify-items: center;
        align-items: center;
        width: 100%;

        span {
            margin: 0 auto;
        }

        contact-form {
            margin: auto 0;
        }
    }

    .form-title {
        font-size: 1.6rem;
        font-family: 'Open Sans', sans-serif;
    }
</style>
