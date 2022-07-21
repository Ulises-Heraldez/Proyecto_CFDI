function cargarXML(theFile) {
  return function(e) {
    console.log('importando ' + theFile.name);
    try {
      //minusculas y reemplazar cfdi
      var contenido = e.target.result
        .toUpperCase()
        .replace(/<\?.+\?>/g, '')
        .replace(/CFDI:/g, '')
        .replace(/\n/g, '')
        .replace(/\>\s+\</g, '><');
      //comprobante es el primer tag
      var comprobante = $(contenido)[0];
      var emisor = $(comprobante).children('EMISOR')[0];
      var receptor = $(comprobante).children('RECEPTOR')[0];
      var impuesto = $(comprobante).children('IMPUESTOS')[0];
      var out = {
        archivo: theFile.name,
        fecha: " ",
        rfc: " " ,
        nombre: " " ,
        rfc_receptor: " ",//Checar
        nombre_receptor: " ", //Checar
        conceptos: [],
        total_importe: 0,
        sub_total: 0,//Checar
        serie: " ",//Checar
        tipo: " ",//Checar
        fact: " ",//Checar
        iva: 0,//Checar
        descuento: 0,//Checar
        excento: 0, //Checar
      };

      if (comprobante.attributes['FECHA']) {
        out.fecha = comprobante.attributes['FECHA'].value.replace(/T.+/g, '');
      }
      else{
        out.fecha = " ";
      }

      if (comprobante.attributes['SUBTOTAL']) {
        out.sub_total = comprobante.attributes['SUBTOTAL'].value;
      }
      else{
        out.sub_total = 0;
      }

      if (comprobante.attributes['TOTAL']) {
        out.total_importe = comprobante.attributes['TOTAL'].value;
      }
      else{
        out.total_importe = 0;
      }

      if (emisor.attributes['RFC']) {
        out.rfc = emisor.attributes['RFC'].value;
      }
      else{
        out.rfc = "X";
      }
      
      if (emisor.attributes['NOMBRE']) {
        out.nombre = emisor.attributes['NOMBRE'].value;
      }
      else{
        out.nombre = "X";
      }

      if (receptor.attributes['RFC']) {
        out.rfc_receptor = receptor.attributes['RFC'].value;
      }
      else{
        out.rfc_receptor = "X";
      }

      if (receptor.attributes['NOMBRE']) {
        out.nombre_receptor = receptor.attributes['NOMBRE'].value;
      }
      else{
        out.nombre_receptor = " ***** ";
      }

      if (comprobante.attributes['TIPODECOMPROBANTE']) {
        out.tipo = comprobante.attributes['TIPODECOMPROBANTE'].value;
      }
      else{
        out.tipo = "X";
      }

      if (comprobante.attributes['FOLIO']) {
        out.fact = "F-" + comprobante.attributes['FOLIO'].value;
      }
      else{
        out.fact = "X";
      }

      if (comprobante.attributes['SERIE']) {
        out.serie = comprobante.attributes['SERIE'].value;
      }
      else{
        out.serie = "X";
      }

      if (comprobante.attributes['DESCUENTO']) {
        out.descuento = comprobante.attributes['DESCUENTO'].value;
      }
      else{
        out.descuento = 0;
      }

      if ($(comprobante).children('IMPUESTOS')[0]) {
        out.iva = parseFloat($(comprobante).children('IMPUESTOS')[0].attributes['TOTALIMPUESTOSTRASLADADOS'].value);
      }
      else{
        out.iva = 0;
      }
      
      var conceptos = $(comprobante)
        .children('CONCEPTOS')
        .children('CONCEPTO');
      conceptos.each(function(i) {
        concepto = conceptos[i];
        //obtener los atributos
        var cantidad = parseInt($(concepto).attr('CANTIDAD'));
        var descripcion = $(concepto).attr('DESCRIPCION');
        var importe = parseFloat($(concepto).attr('IMPORTE'));

        // iteramos en los traslados
        var traslados = [];
        var impuestos = $(concepto)
          .children('IMPUESTOS')
          .children('TRASLADOS')
          .children('TRASLADO');

        impuestos.each(function(i) {
          impuesto = impuestos[i];
          var tasa = $(impuesto).attr('TASAOCUOTA');
          var tipo = $(impuesto).attr('TIPOFACTOR');
          traslados.push({
            tasa: tasa,
            tipo: tipo,
          });
        });

        //asignar al objeto
        out.conceptos.push({
          cantidad: cantidad,
          descripcion: descripcion,
          importe: importe,
          traslados: traslados,
        });
      });
      app.agregar(out);
    } catch (e) {
      app.errores.push({
        archivo: theFile.name,
        mensaje: e.message,
      });
    }
  };
}
