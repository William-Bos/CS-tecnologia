document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formPessoa");

    form.addEventListener("submit", (e) => {
        const campos = ["instituicao", "nome", "cpf", "contato", "email", "cep", "senha", "foto"];

        // Verifica campos vazios
        for (let campo of campos) {
            const input = form[campo];
            if (!input.value.trim()) {
                alert("Por favor, preencha o campo: " + campo.toUpperCase());
                input.focus();
                e.preventDefault();
                return;
            }
        }

        // Validação: e-mail válido
        const email = form["email"].value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert("Digite um e-mail válido!");
            form["email"].focus();
            e.preventDefault();
            return;
        }

        // Validação: CPF com 11 números
        const cpf = form["cpf"].value.replace(/\D/g, "");
        if (cpf.length !== 11) {
            alert("O CPF deve conter 11 números!");
            form["cpf"].focus();
            e.preventDefault();
            return;
        }

        // Validação: CEP com 8 números
        const cep = form["cep"].value.replace(/\D/g, "");
        if (cep.length !== 8) {
            alert("O CEP deve conter 8 números!");
            form["cep"].focus();
            e.preventDefault();
            return;
        }

        // Se tudo estiver certo, o formulário será enviado
    });
});
