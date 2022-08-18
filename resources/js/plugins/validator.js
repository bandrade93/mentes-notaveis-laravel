export default {
	texts: {
		min: 'O campo :field deve ter pelo menos :min caracteres!',
		max: 'O campo :field não pode ter mais que :max caracteres!',
		required: 'Preencha o campo :field!',
		same: 'O campo :field2 não corresponde ao campo :field',
		emailInvalid: 'Digite um e-mail válido!',
		checkbox: 'Marque o campo :field',
		charsInvalid: 'Caracteres Inválidos no campo :field',
		atLeast: 'Marque pelo menos uma opção de :field!',
		selectOption: 'Selecione uma opção em :field!',
	},
	isUsernameValid(username) {
		const RE = /^[a-zA-Z]+[a-zA-Z0-9._]+$/;

		return RE.test(username);
	},
	isEmailValid(email) {
		const RE = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

		return RE.test(email);
	},
	install(Vue, options) {
		Vue.prototype.validateForm = (elements) => {
			for (let el of elements) {
				$(el).focus();

				if (el.type != 'button' && el.type != 'hidden') {
					let $el = $(el);
					$el.addClass('is-invalid');

					if ($el.is('input[type="radio"]') && !$el.is(':checked')) {
						return 'Selecione ' + el.placeholder;
					} else if (el.required && el.type == 'file' && !$el.val().length) {
						return 'Selecione ' + el.placeholder;
					} else if (el.required && $el.is('select') && !$el.val().length) {
						return this.texts.selectOption.replace(':field', el.title);
					} else if (el.required && !$el.val().length) {
						return this.texts.required.replace(':field', el.placeholder);
					} else if (el.type == 'checkbox' && el.checked == false) {
						if ($el.length > 1) {
							if ($el.filter(':checked').length === 0) {
								return this.texts.atLeast.replace(':field', el.placeholder);
							}
						} else if (el.required) {
							return this.texts.checkbox.replace(':field', el.placeholder);
						}
					} else if (el.minLength != -1 && $el.val().length < el.minLength) {
						return this.texts.min
							.replace(':field', el.placeholder)
							.replace(':min', el.minLength);
					} else if (el.maxLength != -1 && $el.val().length > el.maxLength) {
						return this.texts.max
							.replace(':field', el.placeholder)
							.replace(':max', el.maxLength);
					} else if (el.name == 'password') {
						let elConfirm = $('[name="confirm_password"]');
						
						if (elConfirm.length && $el.val() !== elConfirm.val()) {
							return this.texts.same
								.replace(':field2', elConfirm.attr('placeholder'))
								.replace(':field', el.placeholder);
						}
					} else if (
						el.name === 'email' &&
						$el.val().length &&
						!this.isEmailValid($el.val())) {
						return this.texts.emailInvalid;
					} else if (el.name === 'username' && !this.isUsernameValid($el.val())) {
						return this.texts.charsInvalid.replace(':field', el.placeholder);
					}

					$el.removeClass('is-invalid');
					$el.addClass('is-valid');
				}
			}

			return '';
		};
	}
}