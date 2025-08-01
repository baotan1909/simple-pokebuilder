<template>
    <v-container class="py-12">
        <v-row justify="center">
            <v-col cols="12" md="8">
            <h2 class="text-h4 font-weight-bold text-center mb-6">Contact Me</h2>
            <v-form @submit.prevent="onSubmit">
                <v-text-field label="Name" v-model="nameField" :error-messages="nameErrors" outlined class="mb-4"/>
                <v-text-field label="Email" v-model="emailField" :error-messages="emailErrors" type="email" outlined class="mb-4"/>
                <v-text-field label="Subject" v-model="subjectField" :error-messages="subjectErrors" outlined class="mb-4"/>
                <v-textarea label="Message" v-model="messageField" :error-messages="messageErrors" outlined rows="4" class="mb-6"/>
                <v-row justify="center">
                    <v-btn color="primary" type="submit" class="px-8 text-h6 rounded-xl" style="min-height: 56px; min-width: 200px;">
                    Send Message
                    </v-btn>
                </v-row>
            </v-form>
            </v-col>
        </v-row>
    </v-container>
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