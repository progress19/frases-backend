document.addEventListener('DOMContentLoaded', function() {
  const baseUrl = document.getElementById('baseUrl').value;
  const csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');

  const typeEffect = (element, text, speed) => {
    let i = 0;
    const interval = setInterval(() => {
      if (i < text.length) {
        element.value += text.charAt(i);
        i++;
      } else {
        clearInterval(interval);
      }
    }, speed);
  };

  document.getElementById('autocompletar').addEventListener('click', function() {
    const esText = document.getElementById('es').value;
    if (!esText) {
      alert('Por favor, ingrese un texto en Español.');
      return;
    }

    const button = this;
    const saveButton = document.getElementById('send');
    button.disabled = true;
    button.innerHTML = '<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i> Autocompletar';

    const translate = (targetLang, elementId) => {
      fetch(`${baseUrl}/proxy/deepl`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
          text: [esText],
          source_lang: 'ES',
          target_lang: targetLang
        })
      })
      .then(response => response.json())
      .then(data => {
        const element = document.getElementById(elementId);
        element.value = '';
        typeEffect(element, data.translations[0].text, 50);
      })
      .catch(error => {
        console.error('Error:', error);
      });
    };

    translate('EN', 'en');
    translate('PT', 'pr');
    
    setTimeout(() => {
      button.disabled = false;
      button.innerHTML = '<i class="fa fa-magic" aria-hidden="true"></i> Autocompletar';
      saveButton.classList.add('animate__animated', 'animate__heartBeat');
      setTimeout(() => {
        saveButton.classList.remove('animate__animated', 'animate__heartBeat');
      }, 1000); // Duration of the animation
    }, 3000); // Adjust the timeout as needed
  });
});
