async function salvarEncontro(formData) {
    // ENDEREÇO ABSOLUTO DO XAMPP
    const url = 'http://localhost/sistema-paroquial/api/salvar_encontro.php';

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            alert("ERRO 404: O navegador não achou o ficheiro PHP. Verifique se a pasta no htdocs se chama 'sistema-paroquial'.");
            return;
        }

        const res = await response.json();
        alert(res.mensagem); // Se aparecer "DADO GRAVADO", funcionou!

    } catch (error) {
        console.error(error);
        alert("O JavaScript não conseguiu falar com o XAMPP. Certifique-se que o Apache está ligado!");
    }
}