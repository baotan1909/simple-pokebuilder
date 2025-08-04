<template>
    <section class="py-12 px-4 px-md-12 bg-blue-lighten-4" aria-labelledby="contact-heading" role="form">
        <v-row justify="center">
            <v-col cols="12" md="8">
                <h2 id="contact-heading" class="text-h3 font-weight-bold text-center mb-6">Contact Me</h2>
                <v-form @submit.prevent="onSubmit">
                    <v-text-field label="Name" variant="solo-filled" color="white" class="mb-4" v-model="nameField"
                                :aria-invalid="nameErrors.length > 0"
                                :aria-describedby="nameErrors.length ? 'name-error' : null"
                                :error-messages="nameErrors"/>
                    <v-text-field label="Email"  type="email" variant="solo-filled" color="white" class="mb-4" v-model="emailField"
                                :error-messages="emailErrors"
                                :aria-invalid="emailErrors.length > 0"
                                :aria-describedby="emailErrors.length ? 'email-error' : null"/>
                    <v-text-field label="Subject" variant="solo-filled" color="white" class="mb-4" v-model="subjectField"
                                :error-messages="subjectErrors"
                                :aria-invalid="subjectErrors.length > 0"
                                :aria-describedby="subjectErrors.length ? 'subject-error' : null"/>
                    <v-textarea label="Message" variant="solo-filled" color="white" rows="4" class="mb-6" v-model="messageField"
                                :error-messages="messageErrors"
                                :aria-invalid="messageErrors.length > 0"
                                :aria-describedby="messageErrors.length ? 'message-error' : null"/>
                    <v-row justify="center">
                        <v-btn color="primary" type="submit" class="px-8 text-h6 rounded-xl" style="min-height: 56px; min-width: 200px;"
                                aria-label="Send your message">
                            Send Message
                        </v-btn>
                    </v-row>
                </v-form>
            </v-col>
        </v-row>
    </section>
</template>
  
<script setup>
    import * as yup from 'yup'
    import emailjs from '@emailjs/browser'
    import { useForm, useField } from 'vee-validate'
    import { useNotify } from '../composables/useNotify'

    const { notify, confirm } = useNotify();

    const schema = yup.object({
        name: yup.string(),
        email: yup.string().email('Must be a valid email').required('Email is required'),
        subject: yup.string().required('Subject is required'),
        message: yup.string().required('Message cannot be empty'),
    });

    const { handleSubmit, resetForm } = useForm({validationSchema: schema});

    const { value: nameField, errorMessage: nameErrors } = useField('name')
    const { value: emailField, errorMessage: emailErrors } = useField('email')
    const { value: subjectField, errorMessage: subjectErrors } = useField('subject')
    const { value: messageField, errorMessage: messageErrors } = useField('message')

    const onSubmit = handleSubmit(async (values) => {
        try {
            const confirmed = await confirm('Are you sure you want to send this message?');
            if (!confirmed) {return}

            await emailjs.send(
                import.meta.env.VITE_EMAILJS_SERVICE_ID,
                import.meta.env.VITE_EMAILJS_TEMPLATE_ID,
                {
                    name: values.name?.trim() || 'No name',
                    email: values.email,
                    subject: values.subject,
                    message: values.message,
                },
                import.meta.env.VITE_EMAILJS_USER_ID
            );
            
            notify('Your message was sent successfully!')
            resetForm()
        } catch (error) {
            console.error('Failed to send email:', error);
            notify('Failed to send message. Please try again later.');
        }
    });
</script>