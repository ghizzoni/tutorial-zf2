$(function () {
    // pegar elemento com corpo da mensagem
    var corpo_alert = $("#alert-message");
    
    // verificar se o elemento está presente na página
    if (corpo_alert.length)
        // gerar efeito para o elemento encontrado na página
            corpo_alert.fadeOut().fadeIn().fadeOut().fadeIn();
});