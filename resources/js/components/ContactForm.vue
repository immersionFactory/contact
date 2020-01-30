<template>
    <div id="form-box">
        <form id="my-contact-form" @submit="formSubmit" method="POST">
            <div class="form-row">
                <div class="form-column" :class="{ 'has-error' : errorFields.includes('fullName') }">
                    <label for="name-input">Name</label>
                    <input type="text" :disabled="isDisabledSubmit" id="name-input" name="name-input" v-model.trim="formFields.fullName" />
                </div>
                <div class="form-column" :class="{ 'has-error' : errorFields.includes('email') }">
                    <label for="email-input">Email</label>
                    <input type="text" :disabled="isDisabledSubmit" id="email-input" name="email-input" v-model.trim="formFields.email" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-column" :class="{ 'has-error' : errorFields.includes('company') }">
                    <label for="company-input">Company</label>
                    <input type="text" :disabled="isDisabledSubmit" name="company-input" id="company-input" v-model.trim="formFields.company" />
                </div>
                <div class="form-column" :class="{ 'has-error' : errorFields.includes('phone') }">
                    <label for="phone-number-input">Phone Number</label>
                    <input type="text" :disabled="isDisabledSubmit" name="phone-number-input" id="phone-number-input" v-model.trim="formFields.phone" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-column" :class="{ 'has-error' : this.errorFields.includes('subject') }">
                    <label for="subject-input">Subject</label>
                    <input type="text" :disabled="isDisabledSubmit" name="subject-input" id="subject-input" v-model.trim="formFields.subject" />
                </div>
            </div>
            <div class="form-row message-row">
                <div class="form-column single" :class="{ 'has-error' : errorFields.includes('message') }">
                    <label for="message-text">Message</label>
                    <textarea :disabled="isDisabledSubmit" name="message-text" id="message-text" maxlength="1000" v-model.trim="formFields.message"></textarea>
                </div>
            </div>
            <div class="form-row">
                <button :disabled="isDisabledSubmit" type="submit" value="submit">{{sendButtonText}}</button>
            </div>
        </form>
        <div id="success-message" class="message" v-show="showSuccess">
            <div class="image-container">
                <img src="/images/sendIcn.svg" />
            </div>
            <span class="message-title">Thank you for reaching out!</span>
            <span class="message-subtitle">We'll get back to you shortly!</span>
        </div>
        <div id="error-message" class="message" v-show="showError">
            <div class="image-container">
                <img src="/images/alert.svg" />
            </div>
            <span class="message-title">The form broke. We failed!</span>
            <span class="message-subtitle">Please email us: <a href="mailto:contact@immersionfactory.com">contact@immersionfactory.com</a>.</span>
        </div>
    </div>
</template>
<script>

    let defaultFormFields = { fullName: '', email: '', company: '', phone: '', subject: '', message: '' };
    let requiredFields = [ "fullName", "email", "phone", "subject", "message" ];

    export default {
        name: 'ContactForm',
        data: () => ({
            formFields: defaultFormFields,
            isDisabledSubmit: false,
            sendButtonText: 'send',
            errorFields: [],
            showSuccess: false,
            showError: false
        }),
        methods: {
            sendToApi_form() {
                return axios.post('/contact', {
                    name: this.formFields.fullName,
                    email: this.formFields.email,
                    phone: this.formFields.phone,
                    company: this.formFields.company,
                    subject: this.formFields.subject,
                    message: this.formFields.message
                });
            },
            validate() {
                this.errorFields = [];
                requiredFields.forEach(key => {
                    if(this.formFields.hasOwnProperty(key) && this.formFields[key] === '') {
                        this.errorFields.push(key);
                        console.log('returning false');
                    } else if(key === 'email') {
                        let regEx =
                            /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                        if(!this.formFields[key].match(regEx)) this.errorFields.push(key);
                    }
                })

                if(this.errorFields.length === 0) {
                    return true;
                } else { return false }
            },
            show_success() {
                this.showSuccess = true;
            },
            show_error() {
                this.showError = true;
            },
            resetForm() {
                this.formFields = defaultFormFields;
            },
            formSubmit(e) {
                e.preventDefault();
                // this.show_error();
                // this.show_success();
                if (this.validate()) {
                    this.sendButtonText = 'sending';
                    this.isDisabledSubmit = !this.isDisabledSubmit;
                    this.sendToApi_form().then(() => { this.show_success() }).catch((error) => {  console.log(error); this.show_error() });
                }
            }
        }
    };
</script>
<style lang="scss" scoped>

    @use '../../sass/global.scss';

    #form-box {
        margin: 10px 0 0 0;
        padding: 0;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, .33);
        position: relative;
        display: flex;
        flex-direction: column;
        width: 700px;
        max-width: 90%;
        background: #ffffff;

        form {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            color: #666666;

            input, textarea {
                border: 0;
                width: 100%;
                height: 100%;
                padding-top: 20px;

                &:focus {
                    outline-width: 0;
                }
            }

            .form-row {
                position: relative;
                display: flex;
                flex-direction: row;
                flex: 1;
                flex-wrap: wrap;
                align-items: flex-start;
                /*width: 100%;*/
                /*height: auto;*/
                @include global.for-phone-only {
                    border-bottom: 0px;
                }

                &:last-child {
                    border-bottom: 0;
                }

                &.message-row  {
                    height: 200px;
                }

                .form-column {
                    position: relative;
                    min-height: 50px;
                    height: 100%;
                    flex: 1;
                    border-bottom: 1px #999999 solid;
                    @include global.for-phone-only {
                        flex-basis: 100%;
                        border-bottom: 1px #666666 solid;
                    }

                    &:nth-child(2) {
                        border-left: 1px #999999 solid;
                        @include global.for-phone-only {
                            border-left: 0;
                        }
                    }

                    &.single {
                        width: 100%;
                    }

                    label {
                        z-index: 1000;
                        color: #777777;
                        font-family: Roboto, sans-serif;
                        font-size: .8rem;
                        position: absolute;
                        top: 5px;
                        margin-left: 5px;
                        text-transform: lowercase;
                        background-color: transparent;
                    }

                    input, textarea {
                        position: absolute;
                        top: 0px;
                        padding-left: 5px;
                        font-size: 1rem;
                        background-color: transparent;
                    }

                    textarea {
                        padding-top: 27px;
                        height: 200px;
                        resize: none;
                    }

                    &.has-error {

                        border-bottom: red 1px solid;

                        label {
                            color: red;

                            &:after {
                                font-style: italic;
                                content: " !";
                            }
                        }
                    }
                }
            }

            button {
                margin: 0;
                padding: 0;
                border: 0;
                border-radius: 0;
                height: 3.125rem;
                width: 50%;
                color: white;
                font-weight: bold;
                font-size: 1.1rem;
                text-transform: lowercase;

                &[type="submit"] {
                    margin-left: auto;
                    background-color: red;

                    &:focus {
                        outline-width: 0;
                    }

                    &:active {
                        background-color: darken(red, 20%);
                    }

                    &:disabled {
                        background-color: lighten(red, 20%);

                        //https://codepen.io/thetallweeks/pen/yybGra/
                        &:after {
                            overflow: hidden;
                            display: inline-block;
                            vertical-align: bottom;
                            -webkit-animation: ellipsis steps(4,end) 900ms infinite;
                            animation: ellipsis steps(4,end) 900ms infinite;
                            content: "\2026";
                            width: 0px;
                        }

                        @keyframes ellipsis {
                            to {
                                width: 1.25em;
                            }
                        }
                    }
                }
            }
        }

        .message {
            z-index: 1001;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-items: center;
            justify-content: center;
            align-items: center;
            font-family: 'Open Sans', sans-serif;
            animation: scaleIn .5s forwards ease-in;

            &#success-message {
                background-color: #42b983;

                .image-container {
                    /*animation: scaleIn .5s 5s linear reverse;*/
                }

                img {
                    width: 110px;
                    height: 110px;
                    animation: 2s .5s fly forwards linear;
                }

                @keyframes fly {
                    0% {
                        transform: rotate(0deg) translateX(0vw) translateY(0vh);
                    }
                    50% {
                        transform: translateX(22vw) translateY(-8vh) rotate3D(.1, 0, 0, 50deg);
                    }
                    100% {
                        transform: translateX(45vw) translateY(-7.99vh) rotate3D(.1, 0, 0, 80deg);
                        opacity: 0;
                    }
                }

                @include global.for-phone-only {
                    @keyframes fly {
                        0% {
                            transform: rotate(0deg) translateX(0vw) translateY(0vh);
                        }
                        50% {
                            transform: translateX(22vw) translateY(-2vh) rotate3D(.1, 0, 0, 50deg);
                        }
                        100% {
                            transform: translateX(45vw) translateY(-1.99vh) rotate3D(.1, 0, 0, 80deg);
                            opacity: 0;
                        }
                    }
                }
            }

            &#error-message {
                background-color: #FF0000;

                img {
                    width: 95px;
                    height: 95px;
                }
            }

            .image-container {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 110px;
                height: 110px;
                border-radius: 50%;
                background: white;
            }

            .message-title {
                margin-top: 20px;
                font-weight: bold;
                font-size: 1.5rem;
            }

            .message-subtitle {
                margin-top: 3px;
                color: #dddddd;

                a, a:visited {
                    color: white;
                }
            }

        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

    }

</style>
