<template>
	<div>
          <div class="form-group" v-bind:class="{ 'has-error': $v.firstName.$error }">
            <label >First name</label>
            <input class="form-control" v-model.trim="firstName" @input="$v.firstName.$touch()">
              <label id="firstName-error" class="error" v-if="$v.firstName.$error && !$v.firstName.required">First name is required</label>
          </div>
          <div class="form-group" v-bind:class="{ 'has-error': $v.lastName.$error }">
            <label>Last name</label>
            <input class="form-control" v-model.trim="lastName" @input="$v.lastName.$touch()">
             <span class="help-block" v-if="$v.lastName.$error && !$v.lastName.required">Last name is required</span>
          </div>
          
          <div class="form-group" v-bind:class="{ 'has-error': $v.email.$error }">
            <label>Email</label>
            <input class="form-control" v-model.trim="email" @input="$v.email.$touch()">
            <span class="help-block" v-if="$v.email.$error && !$v.email.required">Email is required</span>
            <span class="help-block" v-if="$v.email.$error && !$v.email.email">This is not a valid email!</span>
          </div>
        </div>
</template>
<script>
	const { required, minLength,email } = require('vuelidate/lib/validators');
	export default {
		name: 'step1',
		 data() {
		    return {
		      firstName: '',
		      lastName: '',
		      email: ''
		    }
		  },
		  validations: {
		    firstName: {
		      required
		    },
		    lastName: {
		      required
		    },
		    email: {
		      required,
		      email
		    },
		    form: ['firstName', 'lastName', 'email']
		  },
		  methods: {
		    validate() {
		      this.$v.form.$touch();
		      var isValid = !this.$v.form.$invalid
		      this.$emit('on-validate', this.$data, isValid)
		      return isValid
		    }
		  }
	}
</script>