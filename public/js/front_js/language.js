// Evento de clic en cualquier parte del documento
$(document).click(function(event) {

  var target = event.target;
  
    // Verificar si se hizo clic dentro del menú de idiomas o en el selector de idiomas
    if (!$(target).closest('#languageOptions').length && !$(target).closest('.languageSelector').length) {
      closeLanguageMenu();
    }
  });
  
  // Evento de scroll en la ventana
  $(window).scroll(function() {
    closeLanguageMenu();
  });
  
  // Función para cerrar el menú de idiomas
  function closeLanguageMenu() {
    var languageOptions = $('#languageOptions');
    var chevronIcon = $('.languageSelector .fa-chevron-up');
  
    if (!languageOptions.hasClass('hidden')) {
      languageOptions.removeClass('animate__fadeInDown');
      languageOptions.addClass('animate__fadeOutUp');
      chevronIcon.removeClass('fa-chevron-up');
      chevronIcon.addClass('fa-chevron-down');
      chevronIcon.removeClass('animate__rotateIn');
      setTimeout(function() {
        languageOptions.addClass('hidden');
        languageOptions.removeClass('animate__fadeOutUp');
      }, 500); // Tiempo de duración de la animación en milisegundos (0.5 segundos)
    }
  }
  
  // Evento de clic en el selector de idiomas
  $('.languageSelector').click(function(event) {
    
    var languageOptions = $('#languageOptions');
    var chevronIcon = $('.languageSelector .fa-chevron-down');
  
    if (languageOptions.hasClass('hidden')) {
      languageOptions.removeClass('hidden');
      languageOptions.addClass('animate__animated animate__fadeInRight');
      chevronIcon.removeClass('fa-chevron-down');
      chevronIcon.addClass('fa-chevron-up');
      chevronIcon.addClass('animate__animated animate__rotateIn');
    } else {
      languageOptions.removeClass('animate__fadeInRight');
      languageOptions.addClass('animate__fadeOutUp');
      chevronIcon.removeClass('fa-chevron-up');
      chevronIcon.addClass('fa-chevron-down');
      chevronIcon.removeClass('animate__rotateIn');
      setTimeout(function() {
        languageOptions.addClass('hidden');
        languageOptions.removeClass('animate__fadeOutUp');
      }, 500); // Tiempo de duración de la animación en milisegundos (0.5 segundos)
    }
      event.stopPropagation(); // Evitar que el evento de clic se propague al documento
  });
  