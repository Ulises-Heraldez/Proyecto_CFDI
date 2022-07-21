var app = new Vue({
  el: '#app',
  data: {
    cfdis: [],
    errores: [],
  },
  mounted: function() {
    this.$refs.drop.addEventListener('dragover', this.handleDragOver, false);
    this.$refs.drop.addEventListener('drop', this.handleFileSelect, false);
  },
  computed: {
    total_suma: function() {
      var total = 0;
      for (var i = this.cfdis.length - 1; i >= 0; i--) {
        //console.log(this.cfdis[i].total_importe);
        total += parseFloat(this.cfdis[i].total_importe);
      }
      return total;
    },
    total_iva: function() {
      var total = 0;
      for (var i = this.cfdis.length - 1; i >= 0; i--) {
        //console.log(this.cfdis[i].total_importe);
        total += parseFloat(this.cfdis[i].iva);
      }
      return total;
    },
    cantidad: function() {
      return this.cfdis.length;
    },
    total_ingresos: function() {
      var total = 0;
      for (var i = this.cfdis.length - 1; i >= 0; i--) {
        //console.log(this.cfdis[i].tipo);
        if(this.cfdis[i].tipo === "I"){
          total = total + 1;
        }
      }
      return total;
    },
    total_egresos: function() {
      var total = 0;
      for (var i = this.cfdis.length - 1; i >= 0; i--) {
        //console.log(this.cfdis[i].tipo);
        if(this.cfdis[i].tipo === "E"){
          total = total + 1;
        }
      }
      return total;
    },
    total_traslados: function() {
      var total = 0;
      for (var i = this.cfdis.length - 1; i >= 0; i--) {
        //console.log(this.cfdis[i].tipo);
        if(this.cfdis[i].tipo === "T"){
          total = total + 1;
        }
      }
      return total;
    },
    total_nomina: function() {
      var total = 0;
      for (var i = this.cfdis.length - 1; i >= 0; i--) {
        //console.log(this.cfdis[i].tipo);
        if(this.cfdis[i].tipo === "N"){
          total = total + 1;
        }
      }
      return total;
    },
    total_pago: function() {
      var total = 0;
      for (var i = this.cfdis.length - 1; i >= 0; i--) {
        //console.log(this.cfdis[i].tipo);
        if(this.cfdis[i].tipo === "P"){
          total = total + 1;
        }
      }
      return total;
    },
  },
  methods: {
    handleDragOver: function(evt) {
      evt.stopPropagation();
      evt.preventDefault();
      evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
    },
    handleFileSelect: function(evt) {
      evt.stopPropagation();
      evt.preventDefault();
      var files = evt.dataTransfer.files; // FileList object.
      for (var i = 0, f; (f = files[i]); i++) {
        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = cargarXML(f);
        // Read in the image file as a data URL.
        reader.readAsText(f);
      }
    },
    total: function(item){
      //Obtener totales de conceptos
      var suma = 0;
      var total = 0;
      for (var i = item.conceptos.length - 1; i >= 0; i--) {
        console.log(item.total_importe);
        suma += item.conceptos[i].importe;
      }
      total = suma;
      return total;
    },
    agregar: function(item) {
      //borrar si es que estuviera duplicado
      var arr = this.cfdis.filter(function(el) {
        return el.archivo != item.archivo;
      });
      arr.push(item);
      this.cfdis = arr;
      //console.log('cfdis:');
      //console.log(arr);
    },
  },
});