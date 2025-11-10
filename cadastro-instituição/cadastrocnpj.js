document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formInstituicao");

    form.addEventListener("submit", (e) => {
        const campos = ["instituicao", "endereco", "cnpj", "numero", "email", "cep", "senha", "foto"];

        for (let campo of campos) {
            const input = form[campo];

            // Verifica se está vazio
            if (!input.value.trim()) {
                alert("Por favor, preencha o campo: " + campo.toUpperCase());
                input.focus();
                e.preventDefault(); // impede o envio
                return;
            }
        }

        // Validação extra: formato de e-mail
        const email = form["email"].value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert("Digite um e-mail válido!");
            form["email"].focus();
            e.preventDefault();
            return;
        }

        // Validação extra: CNPJ com 14 dígitos (somente números)
        const cnpj = form["cnpj"].value.replace(/\D/g, "");
        if (cnpj.length !== 14) {
            alert("CNPJ deve conter 14 números!");
            form["cnpj"].focus();
            e.preventDefault();
            return;
        }


        const cep = form["cep"].value.replace(/\D/g, "");
        if (cep.length !== 8) {
            alert("O CEP deve conter 8 números!");
            form["cep"].focus();
            e.preventDefault();
            return;
        }

        // Se passou de todas as verificações, o form será enviado
    });
});
