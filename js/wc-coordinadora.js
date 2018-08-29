jQuery(document).ready(function ($) {

  $form = jQuery('#wc-coordinadora-track-my-order');
  $results = jQuery('#wc-coordinadora-track-result');
  $button = $form.find('button');


  var data = {
    'action': 'wc_coordinadora'
  };

  $button.on('click', function (ev) {
    ev.preventDefault();
    $button.after('<img src="'+wc_coordinadora.spinner+'" class="spin-icon" style="display: inline-block; width: 26px"/>');


    jQuery.post(wc_coordinadora.ajaxurl, data, function (response) {
      var html = '';
      html += '<ul>';
      html += '<li><strong>Guía</strong>: ' + response.codigo_remision + '</li>';
      html += '<li><strong>Promesa de servicio</strong>: ' + response.dias_promesa_servicio + ' dias</li>';
      html += '<li><strong>Origen</strong>: ' + response.nombre_origen + '</li>';
      html += '<li><strong>Destino</strong>: ' + response.nombre_destino + '</li>';
      html += '</ul>';



      if ('estados' in response) {
        html += '<table>';
        html += '<tr><th>Estado</th><th>Fecha</th></tr>'
        response.estados.item.forEach(element => {
          html += '<tr><td>'+element.descripcion +'</td><td>'+element.fecha+ '</td></tr>';
        });
        html += '</table>'
      }

      html += '<img src="data:image/png;base64, '+response.imagen+'" />'

      $results.html(html);
      $form.find('.spin-icon').remove();
    });


    return false;
  });
});
